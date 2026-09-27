# strut.ch — Architecture Overview

## Stack

- **Backend:** Laravel 11, PHP 8.2+
- **Frontend (Admin):** Vue 2.7 + Vuex + Vue Router, Laravel Mix 6
- **Frontend (Public):** Blade templates, SCSS
- **Auth:** JWT (php-open-source-saver/jwt-auth)
- **Image Processing:** Intervention Image v3 (GD driver)
- **Rich Text:** TinyMCE 5
- **Uploads:** vue2-dropzone
- **Translations:** spatie/laravel-translatable v6.5 (German)

## Models & Relationships

### Project
- Translatable fields: `title`, `name`, `location`, `description`, `info`
- Attributes: `year`, `status` (Ausgefuhrt/In Planung/Studie), `competition` (1./2. Preis/Andere), `has_detail`, `publish`, `order`
- Relations: `hasMany(ProjectImage)`, `hasMany(ProjectVideo)`, `hasMany(ProjectFile)`, `belongsTo(Category)`, `belongsTo(CategoryType)`

### ProjectImage
- Fields: `name`, `caption` (JSON), `order`, `publish`, `is_preview_type`, `is_preview_status`, `is_preview_year`, `is_grid`
- Belongs to Project
- `is_grid` flag tracks whether image is placed in a grid

### ProjectVideo
- Fields: `name`, `caption` (JSON), `order`, `publish`
- Belongs to Project
- Formats: mp4, webm, mov

### ProjectFile
- Document downloads attached to projects

### HomeGrid
- Fields: `layout_id`, `order`, `publish`
- Has one `HomeGridLayout` (defines template key)
- Has many `HomeGridElement`

### HomeGridLayout
- Field: `key` (template identifier, e.g. "1fr", "2fr1fr_stacked")

### HomeGridElement
- Fields: `position`, `grid_id`, `project_image_id`, `project_video_id`, `news_id`, `environment`, `action`
- `environment`: production or development (staging/deploy workflow)
- `action`: keep or delete (soft delete for production elements)
- Can reference a ProjectImage, ProjectVideo, or News item

### ProjectGrid / ProjectGridLayout / ProjectGridElement
- Same grid concept applied to project detail pages
- ProjectGridElement can hold a ProjectImage or ProjectVideo

### Category / CategoryType
- Project categorization (type + subtype)

## Grid System

The homepage is composed of grids, each with a layout template:

**Available layouts:**
- `1fr`, `2fr`, `3fr`, `3fr_landscape`
- `1fr2fr`, `2fr1fr`
- `1fr1fr1fr_stacked`, `1fr1fr_stacked1fr`, `1fr_stacked1fr1fr`
- `1fr_stacked2fr`, `2fr1fr_stacked`

Each grid has elements assigned to positions. Elements reference project images or videos and link to the associated project.

A shared `media.blade.php` partial handles rendering: video tag for videos, responsive image for images.

### Staging/Production Workflow
- New elements are created in `development` environment
- `deploy` endpoint promotes development to production
- `reset` clears development changes
- Production elements are soft-deleted (action = 'delete') rather than hard-deleted

### Highlight/Slideshow
- `grid_id = 1` is reserved for the homepage hero slideshow
- Elements are shuffled for random display order
- Supports both images and videos

## Media System (MediaService)

### Upload
- Sanitizes filenames, prepends `uniqid()_strut.ch_`
- Stores originals in `storage/app/public/media/`
- Skips thumbnail/resize for video files
- Max 100MB images, 200MB videos

### Image Processing
- On-demand resizing with caching (7-day TTL)
- Sizes: `thumb` (200x200 cover), `grid` (90px height), `xs` (500x350), `sm` (900x500), `md` (1200x800), `lg` (1600x1100)
- Aspect-ratio aware (landscape vs portrait)

### Storage Directories
```
storage/app/public/media/          # Originals
storage/app/public/media/thumbs/   # 200x200 square thumbnails
storage/app/public/media/grid/     # Grid previews (90px height)
storage/app/public/media/xsmall/   # Max 500x350
storage/app/public/media/small/    # Max 900x500
storage/app/public/media/medium/   # Max 1200x800
storage/app/public/media/large/    # Max 1600x1100
storage/app/public/media/downloads/ # Documents
```

## API Routes

All under `/api` with JWT auth.

### Projects
```
GET    /projects/get
GET    /projects/fetch/{publish?}/{order?}
GET    /project/get/{id}
POST   /project/create
GET    /project/edit/{id}
POST   /project/update/{id}
GET    /project/clone/{id}
GET    /project/status/{id}
DELETE /project/destroy/{id}
POST   /project/order
```

### Project Images / Videos
```
GET    /project/image/get/{projectId}
DELETE /project/image/delete/{file}
GET    /project/image/status/{id}
DELETE /project/video/delete/{file}
GET    /project/video/status/{id}
```

### Home Grids
```
GET    /home/grids
GET    /home/grids/deploy
GET    /home/grids/reset
GET    /home/grid/store/{layoutId}
DELETE /home/grid/delete/{id}
POST   /home/grids/order
POST   /home/grid/element/store
DELETE /home/grid/element/delete/{id}
GET    /home/grid/element/get/{id}
```

### Media
```
POST   /media/upload
POST   /media/upload/document
GET    /media/{file}/{size?}
```

## Models (app/Models/)

| Model | Purpose |
|---|---|
| `Project` | Core content type. Translatable: title, name, location, description, info. Has status, competition, category, order, publish. |
| `ProjectImage` | Image attached to project. Flags: `is_preview_type`, `is_preview_status`, `is_preview_year`, `is_grid`. |
| `ProjectVideo` | Video (mp4/webm/mov) attached to project. |
| `ProjectFile` | Document download attached to project. |
| `Category` / `CategoryType` | Two-level project categorization. |
| `HomeGrid` | Homepage row, has a layout and ordered elements. |
| `HomeGridLayout` | Defines template key (e.g. `2fr1fr_stacked`). |
| `HomeGridElement` | Slot in a grid: references ProjectImage, ProjectVideo, or News. Has `environment` (dev/prod) and `action` (keep/delete). |
| `ProjectGrid` / `ProjectGridLayout` / `ProjectGridElement` | Same grid concept for project detail pages. |
| `News` | News items, can appear in home grid. |
| `Content` | Static content (About, Contact etc). Has associated `ContentImage`. |
| `Team`, `Award`, `Lecture`, `Job`, `Press`, `Book` | Supporting modules for About/Publications sections. |

## Backend Controllers (app/Http/Controllers/Backend/)

Each module in its own subdirectory. Consistent pattern: `get`, `store`, `edit`, `update`, `clone`, `status`, `destroy`, `order`, `unlink`.

- **`Project/`** — `ProjectController`, `ProjectImageController`, `ProjectVideoController`, `ProjectFileController`, `CategoryController`, `CategoryTypeController`, `ProjectGridController`, `ProjectGridElementController`, `ProjectGridLayoutController`
- **`Home/`** — `HomeGridController` (includes `deploy`/`reset`), `HomeGridElementController`, `HomeGridLayoutController`
- **`News/`**, **`Content/`**, **`Award/`**, **`Book/`**, **`Press/`**, **`Lecture/`**, **`Job/`**, **`Team/`** — standard CRUD

## Frontend Controllers (app/Http/Controllers/Frontend/)

Blade-rendering controllers for the public site:
- `HomeController` — homepage with grids + highlight slideshow
- `ProjectsController` — project listing
- `WorksController` — filtered views (by type/year/state)
- `AboutController`, `ContactController`, `PublicationsController`, `DownloadsController`, `PdfController`, `PageController`, `ErrorController`

## Services (app/Services/)

- **`MediaService`** — upload handling (filename sanitization, storage), on-demand image resizing with 7-day cache, skips processing for videos
- **`GridService`** — grid-related business logic
- **`NavigationService`** — builds nav data for public site

## Full API Routes (routes/api.php)

All routes under `auth:api` JWT middleware.

```
# Jobs
GET    /jobs/get
POST   /job/create
GET    /job/edit/{id}
POST   /job/update/{id}
GET    /job/clone/{id}
GET    /job/status/{id}
DELETE /job/destroy/{id}
POST   /job/order
DELETE /job/delete/file/{file}

# Team
GET    /team/get
POST   /team/create
GET    /team/edit/{id}
POST   /team/update/{id}
GET    /team/clone/{id}
GET    /team/status/{id}
DELETE /team/destroy/{id}
POST   /team/order
DELETE /team/delete/file/{file}

# Books
GET    /books/get
POST   /book/create
GET    /book/edit/{id}
POST   /book/update/{id}
GET    /book/clone/{id}
GET    /book/status/{id}
DELETE /book/destroy/{id}
POST   /book/order
DELETE /book/delete/file/{file}

# Press
GET    /press/get/{year?}
POST   /press/create
GET    /press/edit/{id}
POST   /press/update/{id}
GET    /press/clone/{id}
GET    /press/status/{id}
DELETE /press/destroy/{id}
DELETE /press/delete/file/{file}

# Awards
GET    /awards/get
POST   /award/create
GET    /award/edit/{id}
POST   /award/update/{id}
GET    /award/clone/{id}
GET    /award/status/{id}
DELETE /award/destroy/{id}
DELETE /award/delete/file/{file}

# Lectures
GET    /lectures/get
POST   /lecture/create
GET    /lecture/edit/{id}
POST   /lecture/update/{id}
GET    /lecture/clone/{id}
GET    /lecture/status/{id}
DELETE /lecture/destroy/{id}
DELETE /lecture/delete/file/{file}

# Categories
GET    /categories/get
POST   /category/create
GET    /category/edit/{id}
POST   /category/update/{id}
GET    /category/clone/{id}
GET    /category/status/{id}
DELETE /category/destroy/{id}

# Category Types
GET    /types/get/{id?}
POST   /type/create
GET    /type/edit/{id}
POST   /type/update/{id}
GET    /type/clone/{id}
POST   /type/order
GET    /type/status/{id}
DELETE /type/destroy/{id}

# Projects
GET    /projects/get
GET    /projects/fetch/{publish?}/{order?}
GET    /project/get/{id}
POST   /project/create
GET    /project/edit/{id}
POST   /project/update/{id}
GET    /project/clone/{id}
GET    /project/status/{id}
DELETE /project/destroy/{id}
POST   /project/order

# Project Images
GET    /project/image/get/{projectId}
DELETE /project/image/delete/{file}
GET    /project/image/status/{id}

# Project Videos
DELETE /project/video/delete/{file}
GET    /project/video/status/{id}

# Project Files
DELETE /project/file/delete/{file}
GET    /project/file/status/{id}

# Project Grids
GET    /project/grids/{id}
POST   /project/grids/order
GET    /project/grid/store/{projectId}/{layoutId}
DELETE /project/grid/delete/{id}
GET    /project/grid/layouts

# Project Grid Elements
GET    /project/grid/images/{gridId}
POST   /project/grid/image/store
DELETE /project/grid/image/delete/{id}

# Home Grids
GET    /home/grids
GET    /home/grids/deploy
GET    /home/grids/reset
GET    /home/grid/store/{layoutId}
DELETE /home/grid/delete/{id}
POST   /home/grids/order
GET    /home/grid/layout/fetch

# Home Grid Elements
POST   /home/grid/element/store
DELETE /home/grid/element/delete/{id}
GET    /home/grid/element/get/{id}

# News
GET    /news/get
POST   /news/create
GET    /news/edit/{id}
POST   /news/update/{id}
GET    /news/clone/{id}
GET    /news/status/{id}
DELETE /news/destroy/{id}
DELETE /news/delete/file/{file}

# Content
GET    /contents/get
POST   /content/create
GET    /content/edit/{id}
POST   /content/update/{id}
GET    /content/status/{id}
DELETE /content/delete/file/{file}

# Media
POST   /media/upload
POST   /media/upload/document
GET    /media/{file}/{size?}

# Auth (no middleware)
POST   /auth/login
POST   /auth/logout
POST   /auth/refresh
POST   /auth/me
```

## Admin Vue SPA (resources/js/admin/)

- **`app.js`** + **`routes.js`** + **`store.js`** (Vuex) — SPA shell
- **Components per module:** `Index.vue`, `Create.vue`, `Edit.vue`, `Form.vue`
- **Modules:** `project/`, `home/`, `news/`, `content/`, `award/`, `books/`, `press/`, `lecture/`, `jobs/`, `team/`, `category/`, `categoryType/`
- **Home grid components:** `Highlight.vue`, `Row.vue`, `Media.vue`, `MediaSelector.vue`, `GridMedia.vue`, `GridMediaSelector.vue`, `Selector.vue`
- **Project grid components:** `project/grid/Index.vue`, `Row.vue`, `Media.vue`, `Selector.vue`, `ButtonAdd.vue`
- **UI helpers:** `ui/ImageUpload.vue`, `ui/MultiImageUpload.vue`, `ui/FileUpload.vue`
- **Config:** `config/dropzoneconfig-{image,video,file,fullscreen}.js`, `config/tinyconfig.js`
- **Mixins:** `mixins/grid.js`, `mixins/helpers.js`, `mixins/progress.js`

### Project Form (tabbed)
- **Data tab:** Title, name, location, year, description, status, competition, category
- **Images tab:** Dropzone upload, inline caption editing, preview flags, publish toggle
- **Videos tab:** Dropzone upload, caption editing, publish toggle
- **Files tab:** Document uploads

### Home Grid Management
- Grid list with layout selector
- Drag-drop ordering of grids
- MediaSelector component for assigning images/videos to grid positions
- Highlight section management (grid_id = 1)
- Deploy/Reset buttons for staging workflow

## Public Frontend (resources/js/web/)

Vanilla JS modules (no framework):
- `swiper.js` — highlight slideshow
- `packery.js` — masonry-style grid layout
- `fancybox.js` — image lightbox on project pages
- `menu.js`, `header.js`, `contact.js`, `maps.js`, `team.js`, `project.js`

## Blade Views (resources/views/)

- **`admin/app.blade.php`** — single shell for Vue SPA
- **`web/layout/app.blade.php`** — public site layout
- **`web/pages/`** — home, projects, works (type/year/state), about, contact, publications, PDF exports
- **`web/partials/grids/home/`** — 10 layout templates + shared `media.blade.php` partial
- **`web/partials/grids/projects/`** — 7 project detail grid layout templates
