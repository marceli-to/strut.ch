# Domain: Projects

The central domain of strut.ch. Projects represent architectural works and are organized by Category and CategoryType.

---

## Models

### Project
**Table:** `projects`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| title | string | DE | Short title for teasers |
| name | string | DE | Full project name |
| location | string | DE | Project location |
| description | text | DE | Rich text description |
| info | text | DE | Rich text additional info |
| year | string | — | Year of project |
| has_detail | boolean | — | Whether project has a detail page |
| status | string | — | "Ausgeführt", "In Planung", "Studie" |
| competition | string | — | Nullable: "1. Preis", "2. Preis", "Andere" |
| publish | boolean | — | Publishing flag |
| order | integer | — | Sort order |
| category_id | FK | — | → Category |
| category_type_id | FK | — | → CategoryType |

**Relationships:**
- `hasMany` ProjectImage
- `hasMany` ProjectVideo
- `hasMany` ProjectFile (aliased as `downloads`)
- `belongsTo` Category
- `belongsTo` CategoryType

**Scopes:**
- `published()` — where publish = 1
- `competition()` — where competition is not null

---

### Category
**Table:** `categories`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| name | string | DE/EN | Category name |
| publish | boolean | — | Publishing flag |
| show_types | boolean | — | Whether to display subcategories |

**Relationships:**
- `hasMany` CategoryType
- `activeTypes()` — CategoryTypes ordered by `order`, filtered by publish = 1
- `hasMany` Project

**Scopes:**
- `published()` — where publish = 1

---

### CategoryType
**Table:** `category_types`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| category_id | FK | — | → Category |
| name_singular | string | DE/EN | Singular display name |
| name_plural | string | DE/EN | Plural display name |
| order | integer | — | Sort order |

**Relationships:**
- `belongsTo` Category
- `hasMany` Project
- `activeProjects()` — Projects ordered by year DESC, publish = 1
- `activeProjectsWithDetail()` — Projects ordered by order ASC, publish = 1, has_detail = 1

---

### ProjectImage
**Table:** `project_images`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| name | string | — | Filename |
| caption | string | DE | Image caption |
| publish | boolean | — | Publishing flag |
| order | integer | — | Sort order |
| is_preview_type | boolean | — | Preview image for category type listing |
| is_preview_status | boolean | — | Preview image for status listing |
| is_preview_year | boolean | — | Preview image for year listing |
| is_grid | boolean | — | Whether image is used in a grid |
| project_id | FK | — | → Project |

**Relationships:**
- `belongsTo` Project

**Scopes:**
- `notInGrid()` — where is_grid = 0

---

### ProjectVideo
**Table:** `project_videos`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| name | string | — | Filename |
| caption | string | DE | Video caption |
| publish | boolean | — | Publishing flag |
| order | integer | — | Sort order |
| project_id | FK | — | → Project |

**Relationships:**
- `belongsTo` Project

---

### ProjectFile
**Table:** `project_files`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| name | string | — | Filename |
| caption | string | DE | File caption/label |
| publish | boolean | — | Publishing flag |
| order | integer | — | Sort order |
| project_id | FK | — | → Project |

**Relationships:**
- `belongsTo` Project

---

### ProjectGrid
**Table:** `project_grids`

| Field | Type | Notes |
|-------|------|-------|
| project_id | FK | → Project |
| layout_id | FK | → ProjectGridLayout |
| order | integer | Sort order |
| publish | boolean | Publishing flag |

**Relationships:**
- `hasOne` ProjectGridLayout (via layout_id)
- `hasMany` ProjectImage
- `hasMany` ProjectGridElement (via grid_id)

**Scopes:**
- `byProject($id)` — filter by project_id

---

### ProjectGridElement
**Table:** `project_grid_elements`

| Field | Type | Notes |
|-------|------|-------|
| position | string | Position slot in the grid layout |
| grid_id | FK | → ProjectGrid |
| project_id | FK | → Project |
| project_image_id | FK | → ProjectImage (nullable) |
| project_video_id | FK | → ProjectVideo (nullable) |

**Relationships:**
- `hasOne` ProjectImage
- `hasOne` ProjectVideo

**Scopes:**
- `byGrid($id)` — filter by grid_id
- `byProject($id)` — filter by project_id

---

### ProjectGridLayout
**Table:** `project_grid_layouts`

| Field | Type | Notes |
|-------|------|-------|
| key | string | Layout template identifier (e.g. "1-2", "2-1-1") |

**Relationships:**
- `belongsTo` ProjectGrid

---

## Backend Controllers

### ProjectController
**Namespace:** `App\Http\Controllers\Backend\Project`

| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/project/{id}` | `get` | Single project |
| GET `/api/projects` | `all` | All projects with images/videos |
| GET `/api/projects/fetch/{publish}/{order}` | `fetch` | Filter by publish, order by year |
| POST `/api/project/create` | `store` | Create project + nested assets |
| GET `/api/project/edit/{id}` | `edit` | Load for editing with all relations |
| POST `/api/project/update/{id}` | `update` | Update project + nested assets via updateOrCreate |
| POST `/api/project/clone/{id}` | `clone` | Duplicate with "(Kopie)" suffix |
| DELETE `/api/project/{id}` | `destroy` | Delete project + all media |
| POST `/api/project/status/{id}` | `status` | Toggle publish |
| POST `/api/projects/order` | `order` | Bulk update sort order |

### CategoryController
| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/categories/get` | `get` | All categories with types |
| POST `/api/category/create` | `store` | Create category |
| GET `/api/category/edit/{id}` | `edit` | Load for editing |
| POST `/api/category/update/{id}` | `update` | Update category |
| POST `/api/category/clone/{id}` | `clone` | Duplicate |
| DELETE `/api/category/{id}` | `destroy` | Delete |
| POST `/api/category/status/{id}` | `status` | Toggle publish (cascades to types) |

### CategoryTypeController
| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/types/get/{categoryId?}` | `get` | All types, optional category filter |
| POST `/api/type/create` | `store` | Create type |
| GET `/api/type/edit/{id}` | `edit` | Load for editing |
| POST `/api/type/update/{id}` | `update` | Update type |
| POST `/api/type/clone/{id}` | `clone` | Duplicate |
| DELETE `/api/type/{id}` | `destroy` | Delete |
| POST `/api/type/status/{id}` | `status` | Toggle publish |
| POST `/api/types/order` | `order` | Bulk update sort order |

### ProjectImageController
| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/project-images/{projectId?}` | `get` | Published images not in grids |
| POST `/api/project-image/status/{id}` | `status` | Toggle publish |
| DELETE `/api/project/delete/file/{filename}` | `unlink` | Delete image (grid-usage check) |

### ProjectVideoController
| Endpoint | Method | Description |
|----------|--------|-------------|
| DELETE `/api/project/delete/video/{filename}` | `unlink` | Delete video file |
| POST `/api/project-video/status/{id}` | `status` | Toggle publish |

### ProjectFileController
| Endpoint | Method | Description |
|----------|--------|-------------|
| DELETE `/api/project/delete/download/{filename}` | `unlink` | Delete download file |
| POST `/api/project-file/status/{id}` | `status` | Toggle publish |

### ProjectGridController
| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/project-grids/{projectId}` | `get` | Grids for project |
| POST `/api/project-grid/create/{projectId}/{layoutId}` | `store` | Create grid row |
| DELETE `/api/project-grid/{id}` | `destroy` | Delete grid + elements |
| POST `/api/project-grids/order` | `order` | Bulk update order |

### ProjectGridElementController
| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/project-grid-elements/{gridId}` | `get` | Elements for grid |
| POST `/api/project-grid-element/create` | `store` | Add element (sets is_grid=1) |
| DELETE `/api/project-grid-element/{id}` | `destroy` | Remove element (sets is_grid=0) |

### ProjectGridLayoutController
| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/project-grid-layouts` | `get` | All available layouts |

---

## Admin Form

**Component:** `resources/js/admin/components/project/Form.vue`

### Tabs

#### 1. Data (2-column layout)

**Main column:**
| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Kurztitel | text input | `project.title.de` | — |
| Name | text input | `project.name.de` | Yes |
| Ort | text input | `project.location.de` | Yes |
| Beschreibung | TinyMCE editor | `project.description.de` | — |
| Info | TinyMCE editor | `project.info.de` | — |

**Sidebar:**
| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Jahr | select (years) | `project.year` | Yes |
| Status | select | `project.status` | Yes |
| Wettbewerb | select | `project.competition` | — |
| Kategorie | select (API) | `project.category_id` | Yes |
| Typ | select (dynamic) | `project.category_type_id` | Yes |
| Detailseite? | radio (1/0) | `project.has_detail` | — |
| Publizieren? | radio (1/0) | `project.publish` | — |

**Status options:** "Ausgeführt", "In Planung", "Studie"
**Competition options:** "", "1. Preis", "2. Preis", "Andere"

#### 2. Images (Bilder)
- vue2-dropzone: max 50 files, 100MB, jpg/png
- Each image: caption (DE), publish toggle
- Checkboxes: `is_preview_type`, `is_preview_status`, `is_preview_year`
- Drag-to-reorder

#### 3. Videos
- vue2-dropzone: max 20 files, 200MB, mp4/webm/mov
- Each video: caption (DE), publish toggle
- Inline video preview

#### 4. Files (Dateien)
- vue2-dropzone: max 50 files, 8MB, PDF
- Upload URL: `/api/media/upload/document`
- Each file: caption (DE), publish toggle

---

### Category Form
**Component:** `resources/js/admin/components/category/Form.vue`

| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Name | text input | `category.name.de` | Yes |

---

### CategoryType Form
**Component:** `resources/js/admin/components/categoryType/Form.vue`

| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Name (Einzahl) | text input | `categoryType.name_singular.de` | Yes |
| Name (Mehrzahl) | text input | `categoryType.name_plural.de` | Yes |
| Kategorie | select (API) | `categoryType.category_id` | Yes |
