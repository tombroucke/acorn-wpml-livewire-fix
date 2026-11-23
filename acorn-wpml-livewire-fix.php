<?php

/**
 * Plugin Name: Acorn WPML Livewire Fix
 * Description: Prevents WPML from appending the language path to home_url() when Acorn sets the Laravel root URL, fixing broken Livewire asset and update URLs on translated pages.
 * Version:           2.0.0
 * Author: Tom Broucke
 *
 * @see https://github.com/roots/acorn/issues/567
 */

namespace Otomaties\WpmlLivewireFix;

/**
 * Return the original (non-language-prefixed) URL.
 *
 * @param string $homeUrl   The filtered (language-prefixed) URL.
 * @param string $url       The original URL before WPML transformation.
 * @return string
 */
function returnOriginalUrl(string $homeUrl, string $url): string
{
    return $url;
}

add_filter('acorn/root_url', function($url) {
    add_filter('wpml_get_home_url', __NAMESPACE__ . '\returnOriginalUrl', 99, 2);
    add_filter('trp_home_url', __NAMESPACE__ . '\returnOriginalUrl', 99, 2);
    $url = home_url();
    remove_filter('wpml_get_home_url', __NAMESPACE__ . '\returnOriginalUrl', 99);
    remove_filter('trp_home_url', __NAMESPACE__ . '\returnOriginalUrl', 99);

    return $url;
});
