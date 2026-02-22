# Domain: Lectures

Lectures and talks, organized by year. Supports media, downloadable files, and external links.

---

## Model

### Lecture
**Table:** `lectures`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| title | string | DE/EN | Lecture title |
| description | text | DE/EN | Description text |
| year | string | — | Year given |
| media | string | — | Image filename |
| file | string | — | Document filename |
| url | string | — | External link (auto-scheme) |
| publish | boolean | — | Publishing flag |

**Scopes:**
- `published()` — where publish = 1

---

## Backend Controller

### LectureController
**Namespace:** `App\Http\Controllers\Backend\Lecture`

| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/lectures` | `get` | All lectures, ordered by year DESC, grouped by year |
| POST `/api/lecture/create` | `store` | Create lecture |
| GET `/api/lecture/edit/{id}` | `edit` | Load for editing |
| POST `/api/lecture/update/{id}` | `update` | Update lecture |
| POST `/api/lecture/clone/{id}` | `clone` | Duplicate with "(Kopie)" |
| DELETE `/api/lecture/{id}` | `destroy` | Delete lecture + media/file |
| POST `/api/lecture/status/{id}` | `status` | Toggle publish |
| DELETE `/api/lecture/delete/file/{filename}` | `unlink` | Remove media or file |

---

## Admin Form

**Component:** `resources/js/admin/components/lecture/Form.vue`

### Tabs

#### 1. Data

| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Titel | text input | `lecture.title.de` | Yes |
| Beschreibung | textarea | `lecture.description.de` | — |
| Jahr | select (years) | `lecture.year` | Yes |

#### 2. Media
- Single image upload (jpg/png, max 8MB)
- Binds to: `lecture.media`
