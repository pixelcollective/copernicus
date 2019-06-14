# [Clover](https://roots.io/clover/)

[![Packagist](https://img.shields.io/packagist/vpre/roots/clover.svg?style=flat-square)](https://packagist.org/packages/roots/clover)
[![Build Status](https://travis-ci.com/knowler/clover.svg?token=ZYkxfBKizFmyejvnu452&branch=master)](https://travis-ci.com/knowler/clover)

Clover is a WordPress plugin boilerplate with a modern
development workflow. ☘

**Warning: This project is pre-alpha.**

The initial goal of this project is to provide a modern starting
point for a WordPress plugin. Ideally, this will include:

* Frontend workflow for stylesheets and scripts.
* Testing for both PHP and JS.

## Plugin setup

**Important:** you want your plugin to have a unique name and
namespace so there are no conflicts. Change the plugin's name,
namespace, and textdomain. Until there is something to automate
this, here is where you need to change it:

* `composer.json` (in `autoload → psr-4` also `autoload-dev → psr-4`)
* `plugin-name.php` (plugin header meta, filename and namespace
  when Plugin class is instantiated + booted)
* `src/Plugin.php` (namespace)
* `phpcs.xml` (currently looks for `plugin-name.php`)

Make sure to run `composer dump-autoload` after making changes
to the namespace.

## Plugin installation

Run `composer install` to install the PHP dependencies.

## Plugin development

Unless you are writing a site-specific plugin, dev-prod
parity is not a concern when developing. Of course, you do need
to test your plugin in as many environments as you, but for the
sake of simplicity, we've included a basic Docker Compose setup.
Make sure to configure the WordPress version and the (slug) name
of your plugin in `.env` (copy `.env.sample` to get started).
This allows you to have a lightweight development setup that you
can change to test different versions of WordPress with your
plugin. To start the container, run:

```shell
# Add -d to run the container detached
$ docker-compose up
```

Navigate to `localhost:8080` to see the development site.

## Plugin distribution

If you are distributing your plugin, you may want to remove
`dist` and `/vendor/` from the `.gitignore`. To optmize the PHP
depdencies, you need to run:

```shell
$ composer install --no-ansi --no-dev --no-interaction --no-progress --optimize-autoloader --no-scripts
```

## Contributing

Contributions are welcome from everyone. We have [contributing guidelines](https://github.com/roots/guidelines/blob/master/CONTRIBUTING.md)
to help you get started.

## Community

Keep track of development and community news.

* Participate on the [Roots Discourse](https://discourse.roots.io/)
* Follow [@rootswp on Twitter](https://twitter.com/rootswp)
* Read and subscribe to the [Roots Blog](https://roots.io/blog/)
* Subscribe to the [Roots Newsletter](https://roots.io/subscribe/)
* Listen to the [Roots Radio podcast](https://roots.io/podcast/)
