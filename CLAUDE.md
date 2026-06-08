# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

**Joomill Social Share** is a Joomla 4/5 content plugin (`plg_content_socialshare`) that injects social sharing buttons into articles. It is a commercial extension sold via joomill-extensions.com, versioned and deployed via PhpStorm.

- Plugin type: `content` / group: `content`
- Namespace: `Joomill\Plugin\Content\Socialshare`
- Current version: 3.2.2
- Minimum Joomla: 4.0

## Architecture

### Entry points

- `services/provider.php` - Joomla 4+ DI service provider; bootstraps the plugin class into the container
- `src/Extension/Socialshare.php` - main plugin class (`CMSPlugin`), implements two event listeners:
  - `onContentAfterTitle` - injects share buttons into article text (top/bottom/both), handles article, category, featured, and archive views
  - `onContentPrepare` - category-level processing; uses a static flag `$hasProcessedCategory` to prevent double-firing
- `script.php` - installer script; auto-enables plugin on install, checks minimum PHP/Joomla versions

### Templates (layouts)

- `tmpl/default.php` - Bootstrap-compatible layout; uses custom CSS from `media/css/socialshare.css`; displays inline SVG icons and optional platform name text
- `tmpl/yootheme.php` - UIkit/YOOtheme Pro layout; uses `uk-icon` attributes; custom SVG icons for Flipboard and Trello are registered via `UIkit.icon.add()`

### Platform definitions

All platforms are defined as a single `$socialPlatforms` array in `Socialshare.php::onContentAfterTitle`. Each entry has: `enabled`, `url`, `iconPath` (SVG path data), `iconViewbox`, `text`, and `order`. WhatsApp uses user-agent detection to switch between mobile (`whatsapp://`) and desktop (`https://web.whatsapp.com/`) URLs.

### Language files

Five languages: `en-GB`, `nl-NL`, `de-DE`, `fr-FR`, `es-ES`, `it-IT`. Each language has two files:
- `plg_content_socialshare.ini` - all UI strings
- `plg_content_socialshare.sys.ini` - plugin name shown in the plugin manager

The extension name string (`PLG_CONTENT_SOCIALSHARE`) is never translated; it is identical in all language files.

### Config parameters (defined in `socialshare.xml`)

Three fieldsets under `<fields name="params">`:
- `basic` - category filter, display position, view toggles (article/category/featured/archive), link target
- `layout` - layout selector, icon/text visibility classes (Bootstrap + UIkit responsive classes), YOOtheme-specific styling options, sticky mobile toggle
- `platforms` - individual yes/no toggle per platform

## Adding a new social platform

1. `src/Extension/Socialshare.php` - add entry to `$socialPlatforms` array with all six keys
2. `media/css/socialshare.css` - add `.socialshare-[platform] a` background color and `:hover` rule
3. `socialshare.xml` - add `<field>` in the `platforms` fieldset (radio yes/no, default `0`)
4. All six `language/*/plg_content_socialshare.ini` files - add `LABEL` and `DESC` strings

## Deployment

No build step. Deploy directly from PhpStorm to the configured deploy server. Install on Joomla by zipping the repository root and uploading via Joomla's extension manager.

## Manifest standard

Apply the manifest element-order and section-comment convention from the Obsidian vault snippet `30-snippets/joomla-extension-manifest.md` whenever `socialshare.xml` is modified.
