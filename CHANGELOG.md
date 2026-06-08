# Changelog

All notable changes to the Extension are documented in this file.

## Unreleased

### Joomla 5/6 compliance
- Refactor: implement `SubscriberInterface` for explicit event registration (Joomla 5/6 standard)
- Refactor: inject `DatabaseInterface` via `DatabaseAwareTrait`; remove implicit `$db` property
- Refactor: `script.php` implements `InstallerScriptInterface` with typed method signatures
- Add: PHP type declarations on event handler and `loadArticle()`

### Fixes
- Fix: stylesheet was loaded at class-load time; moved inside event handler after context checks
- Fix: all HTML attribute and text output in templates now escaped with `htmlspecialchars()`
- Fix: `loadArticle()` now queries by article `id` instead of matching introtext content; adds `LIMIT 1`
- Fix: `HTTP_USER_AGENT` now read via Joomla input layer instead of `$_SERVER` superglobal

### Cleanup
- Remove: dead `onContentPrepare` method and accompanying static flag

## 3.2.2
- Changed: Update Mastodon sharing URL
- Fix: Avoid PHP warning by handling null category descriptions

## TODO
- Addition: help buttons now link to the Joomill documentation page
- Addition: Support Plugin lazy loading for PHP >= 8.4: Added a possibility to load plugin class on demand (lazy loading) when the event dispatched. For servers with PHP version >= 8.4.
- Check other updates in the past: https://github.com/joomla/Manual/tree/main/updates
- Check bc for Joomla 7 release: https://github.com/joomla/Manual/blob/main/updates/64-70/removed-backward-incompatibility.md