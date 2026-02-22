# Domain: News

News articles that can appear standalone or be embedded into homepage grid elements.

---

## Model

### News
**Table:** `news`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| date | string | DE | Date as free text (not a date column) |
| subtitle | string | DE | Subtitle |
| title | string | DE | Main title |
| text | text | DE | Body text |
| link | string | DE | External URL or email |
| linkText | string | DE | Anchor text for the link |
| media | string | — | Image filename |

**Note:** All translatable fields are DE-only (no EN translations in controller).

---

## Backend Controller

### NewsController
**Namespace:** `App\Http\Controllers\Backend\News`
**Uses:** GridService (to check if news is used on homepage)

| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/news` | `get` | All news items |
| POST `/api/news/create` | `store` | Create news |
| GET `/api/news/edit/{id}` | `edit` | Load for editing |
| POST `/api/news/update/{id}` | `update` | Update news |
| POST `/api/news/clone/{id}` | `clone` | Duplicate with "(Kopie)" |
| DELETE `/api/news/{id}` | `destroy` | Delete (blocked if used in grid) |
| POST `/api/news/status/{id}` | `status` | Toggle publish |
| DELETE `/api/news/delete/file/{filename}` | `unlink` | Remove image |

**Deletion guard:** If a news item is referenced by a HomeGridElement, deletion returns HTTP 422 with a German error message. The item must first be removed from the grid.

---

## Admin Form

**Component:** `resources/js/admin/components/news/Form.vue`

### Tabs

#### 1. Data

| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Datum | text input | `news.date.de` | — |
| Titel | text input | `news.title.de` | Yes |
| Subtitel | text input | `news.subtitle.de` | — |
| Text | textarea | `news.text.de` | — |
| Link/E-Mail | text input | `news.link.de` | — |
| Link Text | text input | `news.linkText.de` | — |

**Link field:** Auto-detects email addresses (adds `mailto:` prefix) or URLs (adds `http://` if no scheme).

#### 2. Media (Bild)
- Single image upload (jpg/png, max 8MB)
- Binds to: `news.media`
