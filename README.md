# Acorn WPML Livewire Fix

Fixes broken Livewire asset and update URLs when using [WPML](https://wpml.org/) (or TranslatePress) with [Acorn](https://roots.io/acorn/) v5.1+.

## The problem

Acorn calls `URL::forceRootUrl(home_url())` to set the Laravel root URL. WPML filters `home_url()` to append the current language prefix (e.g. `/fr`), causing:

- `livewire.js` to 404
- `/livewire/update` to contain the language segment repeated 3× (e.g. `https://example.com/fr/fr/fr/livewire/update`)

## Installation

**1. Require the package:**

```bash
composer require tombroucke/acorn-wpml-livewire-fix
```

**2. Patch Acorn** (until [roots/acorn#570](https://github.com/roots/acorn/pull/570) is merged):

Add to `composer.json`:

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

Then apply:

```bash
composer reinstall roots/acorn
```
