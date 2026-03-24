# Domain: Jobs

Job postings/vacancies with descriptions and downloadable PDFs.

---

## Model

### Job
**Table:** `jobs`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| title | string | DE/EN | Job title |
| lead | text | DE/EN | Lead/short description |
| info | text | DE/EN | Rich text detailed info |
| media | string | — | PDF document filename |
| order | integer | — | Sort order |
| publish | boolean | — | Publishing flag |

**Scopes:**
- `published()` — where publish = 1

**Note:** The `media` field stores a PDF filename (not an image).

---

## Backend Controller

### JobController
**Namespace:** `App\Http\Controllers\Backend\Job`

| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/jobs` | `get` | All jobs ordered by order ASC |
| POST `/api/job/create` | `store` | Create job (order defaults to -1) |
| GET `/api/job/edit/{id}` | `edit` | Load for editing |
| POST `/api/job/update/{id}` | `update` | Update job |
| POST `/api/job/clone/{id}` | `clone` | Duplicate with "(Kopie)" |
| DELETE `/api/job/{id}` | `destroy` | Delete job + media |
| POST `/api/job/status/{id}` | `status` | Toggle publish |
| POST `/api/jobs/order` | `order` | Bulk update sort order |
| DELETE `/api/job/delete/file/{filename}` | `unlink` | Remove PDF file |

---

## Admin Form

**Component:** `resources/js/admin/components/jobs/Form.vue`

### Tabs

#### 1. Data

| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Titel | text input | `job.title.de` | Yes |
| Lead/Beschreibung | textarea | `job.lead.de` | Yes |
| Info | TinyMCE editor | `job.info.de` | — |

#### 2. Media
- Single PDF upload (max 8MB)
- Upload URL: `/api/media/upload/document`
- Binds to: `job.media`
