# Changelog

All notable changes to the Extension are documented in this file.

## Unreleased

- Refactor: implement `SubscriberInterface` for explicit event registration (Joomla 5/6 standard)
- Refactor: inject `DatabaseInterface` via `DatabaseAwareTrait`; remove implicit `$db` property
- Refactor: `script.php` implements `InstallerScriptInterface` with typed method signatures
- Add: PHP type declarations on event handler and `loadArticle()`
- Add: lazy plugin loading with `method_exists($container, 'lazy')` guard; activates on Joomla 6.1+ / PHP 8.4+
- Fix: stylesheet was loaded at class-load time; moved inside event handler after context checks
- Fix: all HTML attribute and text output in templates now escaped with `htmlspecialchars()`
- Fix: `loadArticle()` now queries by article `id` instead of matching introtext content; adds `LIMIT 1`
- Fix: `HTTP_USER_AGENT` now read via Joomla input layer instead of `$_SERVER` superglobal
- Remove: dead `onContentPrepare` method and accompanying static flag
- Changed: minimum Joomla version bumped from 4.0 to 5.0
- Changed: Update Mastodon sharing URL
- Fix: Avoid PHP warning by handling null category descriptions

## TODO
- Addition: help buttons now link to the Joomill documentation page
- Check bc for Joomla 7 release: https://github.com/joomla/Manual/blob/main/updates/64-70/removed-backward-incompatibility.md

## 3.2.2
- Changed: Update Mastodon sharing URL
- Fix: Avoid PHP warning by handling null category descriptions
