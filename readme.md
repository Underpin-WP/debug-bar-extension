# Unerpin Debug Extension

This extension uses Underpin's `logger` class with commonly-used WordPress debugger utilities,
such as [debug bar](wordpress.org/plugins/debug-bar/) and [query monitor](wordpress.org/plugins/query-monitor).

This extension requires [Underpin](github.com/underpin-WP/underpin) to function.

## Installation

### Using Composer

`composer require underpin/debug-bar-extension`

### Manually

This plugin uses a built-in autoloader, so as long as it is required _before_
Underpin, it should work as-expected.

`require_once(__DIR__ . '/underpin-debug-bar-extension/debug-bar.php');`

## Setup

This plugin will automatically log any logger events. Simply installing the extension and activating your debugger of
choice is sufficient.

1. Install Underpin. See [Underpin Docs](https://www.github.com/underpin-wp/underpin)
1. Install any of the supported plugins mentioned below.

## Supported Plugins

1. [query monitor](wordpress.org/plugins/query-monitor)
1. [debug bar](wordpress.org/plugins/debug-bar/)

If you use a plugin, and think it should be integrated, [submit an issue](https://github.com/Underpin-WP/debug-bar-extension/issues/new).
