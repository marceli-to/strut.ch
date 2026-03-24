# Domain: Awards

Awards and honors received, organized by year.

---

## Model

### Award
**Table:** `awards`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| title | string | DE/EN | Award title |
| description | text | DE/EN | Description text |
| year | string | — | Year received |
| media | string | — | Image filename |
| file | string | — | Document filename |
| url | string | — | External link (auto-scheme) |
| publish | boolean | — | Publishing flag |

**Scopes:**
- `published()` — where publish = 1

---

## Backend Controller

### AwardController
**Namespace:** `App\Http\Controllers\Backend\Award`

| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/awards` | `get` | All awards, ordered by year DESC, grouped by year |
| POST `/api/award/create` | `store` | Create award |
| GET `/api/award/edit/{id}` | `edit` | Load for editing |
| POST `/api/award/update/{id}` | `update` | Update award |
| POST `/api/award/clone/{id}` | `clone` | Duplicate with "(Kopie)" |
| DELETE `/api/award/{id}` | `destroy` | Delete award + media/file |
| POST `/api/award/status/{id}` | `status` | Toggle publish |
| DELETE `/api/award/delete/file/{filename}` | `unlink` | Remove media or file |

---

## Admin Form

**Component:** `resources/js/admin/components/award/Form.vue`

### Tabs

#### 1. Data

| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Titel | text input | `award.title.de` | Yes |
| Beschreibung | textarea | `award.description.de` | — |
| Jahr | select (years) | `award.year` | Yes |

#### 2. Media
- Single image upload (jpg/png, max 8MB)
- Binds to: `award.media`
