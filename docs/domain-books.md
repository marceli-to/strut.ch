# Domain: Books

Books/publications collection with descriptions and external links.

---

## Model

### Book
**Table:** `books`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| title | string | — | Book title (not translatable) |
| description | text | DE/EN | Description text |
| info | text | DE/EN | Rich text additional info |
| url | string | — | External link or email |
| media | string | — | Cover image filename |
| order | integer | — | Sort order |
| publish | boolean | — | Publishing flag |

**Scopes:**
- `published()` — where publish = 1

---

## Backend Controller

### BookController
**Namespace:** `App\Http\Controllers\Backend\Book`

| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/books` | `get` | All books ordered by order ASC |
| POST `/api/book/create` | `store` | Create book |
| GET `/api/book/edit/{id}` | `edit` | Load for editing |
| POST `/api/book/update/{id}` | `update` | Update book |
| POST `/api/book/clone/{id}` | `clone` | Duplicate with "(Kopie)" |
| DELETE `/api/book/{id}` | `destroy` | Delete book + media |
| POST `/api/book/status/{id}` | `status` | Toggle publish |
| POST `/api/books/order` | `order` | Bulk update sort order |
| DELETE `/api/book/delete/file/{filename}` | `unlink` | Remove cover image |

---

## Admin Form

**Component:** `resources/js/admin/components/books/Form.vue`

### Tabs

#### 1. Data

| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Titel | text input | `book.title` | Yes |
| Beschreibung | textarea | `book.description.de` | Yes |
| Info | TinyMCE editor | `book.info.de` | — |
| Link/E-Mail | text input | `book.url` | — |

**Link field:** Auto-detects email addresses (adds `mailto:`) or URLs (adds `http://` if no scheme).

#### 2. Media
- Single image upload (jpg/png, max 8MB)
- Binds to: `book.media`
