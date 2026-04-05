# Dynamic CMS Architecture

This project now includes a dynamic CMS layer that allows admins to edit content inline from the frontend.

## Core Components

- `page_sections` table stores per-page, per-section editable content/style JSON.
- `App\Support\DynamicContent` service resolves dynamic values with fallback to config defaults and caches outputs.
- `dynamic_content('page.section.field')` helper allows Blade templates to resolve DB-backed content.
- Admin-only frontend editor (`public/js/cms-editor.js`) supports:
  - Preview mode (toggle outlines)
  - Inline text editing (ar/en + style options)
  - Inline image upload via Laravel Storage (+ browser crop preview & ratio lock)
  - Button customization (text/link/bg/text/border/hover)
  - Icon picker by class + color + size
  - Section drag & drop reorder + show/hide
  - Light/Dark style values (`light_value` / `dark_value`)
  - Save/discard draft workflow

## Routes (Admin + Auth + is_admin)

- `GET /admin/cms/page`
- `POST /admin/cms/save`
- `POST /admin/cms/upload-image`

## How to make any element editable

1. Wrap logical blocks with `data-cms-section="section-key"`.
2. For custom text/image nodes, add `data-cms-key="your.key"`.
3. Existing `data-i18n` text nodes are auto-detected by editor.

## Notes

- Storage uses Laravel disk (`public` disk via `Storage::url`), not direct `/public` writes.
- Cache is flushed automatically on section save.
- Non-admin users never see editing toolbar or tools.
