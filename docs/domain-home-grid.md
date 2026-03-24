# Domain: Home Grid

The homepage layout system. A grid-based builder that arranges project images, videos, and news articles into configurable layout rows. Includes a staging workflow (dev/prod) for safe content changes.

---

## Models

### HomeGrid
**Table:** `home_grids`

| Field | Type | Notes |
|-------|------|-------|
| layout_id | FK | → HomeGridLayout |
| order | integer | Sort order of grid rows |
| publish | boolean | Publishing flag |

**Relationships:**
- `hasOne` HomeGridLayout (via layout_id)
- `hasMany` ProjectImage
- `hasMany` HomeGridElement (via grid_id)

**Note:** `grid_id = 1` is reserved for the homepage highlight/hero slideshow.

---

### HomeGridElement
**Table:** `home_grid_elements`

| Field | Type | Notes |
|-------|------|-------|
| grid_id | FK | → HomeGrid |
| project_image_id | FK | → ProjectImage (nullable) |
| project_video_id | FK | → ProjectVideo (nullable) |
| news_id | FK | → News (nullable) |
| position | string | Slot position in the layout |
| environment | enum | "development" or "production" |
| action | enum | "keep" or "delete" |

**Relationships:**
- `hasOne` ProjectImage
- `hasOne` ProjectVideo
- `hasOne` News
- `belongsTo` HomeGrid

**Scopes:**
- `highlight()` — where grid_id = 1 (hero slideshow)
- `toDelete()` — where action = "delete"
- `isDevelopment()` — where environment = "development"
- `isProduction()` — where environment = "production"

---

### HomeGridLayout
**Table:** `home_grid_layouts`

| Field | Type | Notes |
|-------|------|-------|
| key | string | Layout template identifier (e.g. "highlight", "1-2", "2-1") |

**Relationships:**
- `belongsTo` HomeGrid

---

## Staging Workflow

The home grid uses a dev/prod environment system:

1. **New elements** are created with `environment = "development"`
2. **Deleting a production element** sets `action = "delete"` (soft-delete)
3. **Deleting a development element** removes it immediately (hard-delete)
4. **Deploy** (`deploy()`) promotes all dev elements to production and hard-deletes elements marked for deletion
5. **Reset** (`reset()`) reverts: restores soft-deleted production elements and removes new dev elements

---

## Backend Controllers

### HomeGridController
**Namespace:** `App\Http\Controllers\Backend\Home`

| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/home-grids` | `get` | All grids with layout + elements, ordered |
| POST `/api/home-grid/create/{layoutId}` | `store` | Create grid row |
| DELETE `/api/home-grid/{id}` | `destroy` | Delete grid + all elements |
| POST `/api/home-grids/order` | `order` | Bulk update sort order |
| POST `/api/home-grids/deploy` | `deploy` | Promote dev → prod |
| POST `/api/home-grids/reset` | `reset` | Revert dev changes |

### HomeGridElementController
| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/home-grid-elements/{gridId}` | `get` | Elements for grid (action=keep only) |
| POST `/api/home-grid-element/create` | `store` | Add element (environment=development) |
| DELETE `/api/home-grid-element/{id}` | `destroy` | Soft/hard delete depending on environment |

### HomeGridLayoutController
| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/home-grid-layouts` | `fetch` | All available layouts |

---

## Admin Form

### Article Form (News for Grid)
**Component:** `resources/js/admin/components/home/ArticleForm.vue`

Used to create inline news articles directly from the grid builder.

**Tabs:** Data, Media

| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Datum | text input | `news.date.de` | — |
| Titel | text input | `news.title.de` | Yes |
| Text | textarea | `news.text.de` | — |

Submission is handled by the parent grid builder component via `storeArticle()`.

### Grid Article Form
**Component:** `resources/js/admin/components/home/GridArticleForm.vue`

Identical structure to ArticleForm — used in a different grid context.

---

## Grid Layouts

10 layout templates are available (rendered from `resources/views/web/partials/grids/home/`). The `key` field on HomeGridLayout maps to the Blade partial filename. See `docs/grid-builder-images.md` for visual reference.
