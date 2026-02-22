# Domain: Content

CMS-like content blocks used for static pages (e.g. About, Contact). Each content block has a unique key and optional image gallery.

---

## Models

### Content
**Table:** `content`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| key | string | — | Unique identifier for the content block |
| title | string | DE/EN | Block title |
| text | text | DE/EN | Rich text body |
| media | string | — | Primary image filename |
| publish | boolean | — | Publishing flag |
| hasMedia | boolean | — | Whether block supports media uploads |

**Relationships:**
- `hasMany` ContentImage

**Scopes:**
- `published()` — where publish = 1

---

### ContentImage
**Table:** `content_images`

| Field | Type | Notes |
|-------|------|-------|
| name | string | Image filename |
| caption | string | Image caption |
| publish | boolean | Publishing flag |
| order | integer | Sort order |
| content_id | FK | → Content |

**Relationships:**
- `belongsTo` Content

---

## Backend Controller

### ContentController
**Namespace:** `App\Http\Controllers\Backend\Content`

| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/content` | `get` | All content blocks with images |
| POST `/api/content/create` | `store` | Create content + images |
| GET `/api/content/edit/{id}` | `edit` | Load with images |
| POST `/api/content/update/{id}` | `update` | Update content + images (updateOrCreate) |
| POST `/api/content/status/{id}` | `status` | Toggle publish |
| DELETE `/api/content/delete/file/{filename}` | `unlink` | Delete content image |

**Note:** No clone or destroy endpoints — content blocks are managed rather than created/deleted freely.

---

## Admin Form

**Component:** `resources/js/admin/components/content/Form.vue`

### Tabs

#### 1. Data

| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Titel | text input | `content.title.de` | Yes |
| Text | TinyMCE editor | `content.text.de` | Yes |

#### 2. Media (conditional)
Only shown when `content.has_media` is true.

- Single image upload (jpg/png, max 8MB)
- Images stored in `content.images[]` array
- Each image has: `id`, `name`, `caption`, `order`, `publish`
