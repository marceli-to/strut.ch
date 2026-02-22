# Domain: Press

Press coverage and publications, optionally linked to a project. Supports both image media and downloadable PDF files.

---

## Model

### Press
**Table:** `press`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| title | string | DE/EN | Press item title |
| description | text | DE/EN | Description text |
| year | string | — | Year of publication |
| url | string | — | External link (auto-scheme) |
| media | string | — | Image filename |
| file | string | — | PDF filename |
| publish | boolean | — | Publishing flag |
| project_id | FK | — | → Project (nullable) |

**Relationships:**
- `hasOne` Project (via project_id)

**Scopes:**
- `published()` — where publish = 1

---

## Backend Controller

### PressController
**Namespace:** `App\Http\Controllers\Backend\Press`

| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/press/{year?}` | `get` | All press, ordered by year DESC, grouped by year |
| POST `/api/press/create` | `store` | Create press item |
| GET `/api/press/edit/{id}` | `edit` | Load for editing |
| POST `/api/press/update/{id}` | `update` | Update press item |
| POST `/api/press/clone/{id}` | `clone` | Duplicate with "(Kopie)" |
| DELETE `/api/press/{id}` | `destroy` | Delete press + media/file |
| POST `/api/press/status/{id}` | `status` | Toggle publish |
| DELETE `/api/press/delete/file/{filename}` | `unlink` | Remove media or file |

---

## Admin Form

**Component:** `resources/js/admin/components/press/Form.vue`

### Tabs

#### 1. Data

| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Titel | text input | `press.title.de` | Yes |
| Beschreibung | textarea | `press.description.de` | — |
| Jahr | select (years) | `press.year` | Yes |
| Projekt | select (API) | `press.project_id` | — |
| Link | text input | `press.url` | — |

**Project dropdown** fetches published projects from `/api/projects/fetch/1/asc`.
**Link field** auto-fixes URL protocol on blur.

#### 2. Media (Bild)
- Single image upload (jpg/png, max 8MB)
- Binds to: `press.media`

#### 3. File (Datei)
- Single PDF upload (max 8MB)
- Upload URL: `/api/media/upload/document`
- Binds to: `press.file`
