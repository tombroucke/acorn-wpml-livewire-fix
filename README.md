# Acorn WPML Livewire Fix

Fixes broken Livewire asset and update URLs when using [WPML](https://wpml.org/) (or TranslatePress) with [Acorn](https://roots.io/acorn/) v5.1+.

## The problem

Acorn calls `URL::forceRootUrl(home_url())` to set the Laravel root URL. WPML filters `home_url()` to append the current language prefix (e.g. `/fr`), causing:

- `livewire.js` to 404
- `/livewire/update` to contain the language segment repeated 3× (e.g. `https://example.com/fr/fr/fr/livewire/update`)

## Installation

```bash
composer require tombroucke/acorn-wpml-livewire-fix
```
