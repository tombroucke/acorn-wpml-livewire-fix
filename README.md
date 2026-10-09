# Acorn WPML Livewire Fix

Fixes broken Livewire asset and update URLs when using [WPML](https://wpml.org/) (or TranslatePress) with [Acorn](https://roots.io/acorn/) v6.

**Issue:** [roots/acorn#567](https://github.com/roots/acorn/issues/567)
**Patch PR:** [roots/acorn#570](https://github.com/roots/acorn/pull/570)

## The problem

Acorn calls `URL::forceRootUrl(home_url())` to set the Laravel root URL. WPML filters `home_url()` to append the current language prefix (e.g. `/fr`), so on a translated page the root URL gets baked in as `https://example.com/fr`. This causes:

- `livewire.js` to 404 (URL contains the language path)
- `/livewire/update` to contain the language segment repeated 3× (e.g. `https://example.com/fr/fr/fr/livewire/update`)

## The fix

This mu-plugin hooks into `acorn/before_force_root_url` and `acorn/after_force_root_url` to temporarily suppress the WPML and TranslatePress `home_url()` filters while Acorn sets the root URL.

These hooks require [roots/acorn#570](https://github.com/roots/acorn/pull/570) to be applied to `roots/acorn`. Until the PR is merged, apply it via `cweagans/composer-patches`.

## Applying the patch

**1. Add to `composer.json`:**

```json
"require": {
    "cweagans/composer-patches": "^2.0"
},
"config": {
    "allow-plugins": {
        "cweagans/composer-patches": true
    }
},
"extra": {
    "patches": {
        "roots/acorn": [
            {
                "description": "Add do_action hooks around URL::forceRootUrl for WPML compatibility",
                "url": "https://patch-diff.githubusercontent.com/raw/roots/acorn/pull/570.patch"
            }
        ]
    }
}
```

**2. Apply:**

```bash
composer reinstall roots/acorn
```

Once [roots/acorn#570](https://github.com/roots/acorn/pull/570) is merged and released, the patch and `cweagans/composer-patches` dependency can be removed.
