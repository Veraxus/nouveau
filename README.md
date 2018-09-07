# NOUVEAU Starter Theme
**Contributors:** Matt van Andel  
**Donate link:** http://nouveauframework.org/  
**Author URI:** http://nouveauframework.org/  
**Tags:** framework, php7.1  
**Version:** 1.0  
**Foundation version:** 6.5  
**Requires at least:** 4.9  
**Tested up to:** 5.0  
**Stable tag:** 1.0  
**Text Domain:** nv_lang_scope  
**License:** GPL2+ & MIT  

NOUVEAU is an open-source, rapid-development theme & plugin framework for WordPress, built on Zurb Foundation and PHP 7.1+. Work fast. Be awesome.

## Description

**NOUVEAU is NOT a ready-made theme - it is a convenient starting point for theme development.**

NOUVEAU is a rapid-development framework for WordPress. Unlike other "theme frameworks" NOUVEAU doesn't try to cram everything into a single, overreaching, monolithic theme - instead, NOUVEAU's starter theme is dedicated to presentation work, keeping things clean and easy.

If you want even more features, don't clutter your theme with them; that's what plugins are for! For any features you really need in your project there's a separate collection of starter and example plugins for you to quickly customize. 

From the theme to the plugins, everything is consistent, simple, clean, and well commented - so you can work fast.

### A Really, Really, Important Notice:
NOUVEAU is NOT a ready-made theme and should only be used by developers. It is specifically built to facilitate rapid development and easy maintenance. NOUVEAU is all about the code: which is clean, simple, and fully commented and documented.

## Features

* **Built for WordPress**  
NOUVEAU isn’t just a theme or a plugin, it’s a _framework_. Whether you are working on a theme OR plugin, anything you need to quickly get started is readily available, so you can get right to the meat of your project.

* **Modular**  
Everything is available a-la-carte. By keeping the theme and features separate, you can easily use or customize only what you need, where you need it, and none of what you don’t.

* **PHP 7**  
**Newer versions of PHP provides numerous benefits:** namespaces, closures, anonymous functions... and NOUVEAU takes advantage of that.

* **Zurb Foundation**  
NOUVEAUs theme framework comes prepackaged with the latest version of Zurb Foundation, an open-source front-end framework that blows Bootstrap out of the water. Create responsive websites with incredible speed and flexibility. Don't want to use Foundation? No problem, replacing it is easy.

* **Gutenberg Support**
Want to get a head start on WordPress's awesome new modular editor, Gutenberg? NOUVEAU has built-in Gutenberg support, so you can quickly and easily create your own blocks using ESNext.

* **Clean Code. No Assumptions**  
No child themes, no file soup, no styles, no additional templating systems, and no strong opinions. Just clean, tidy, well-documented code.

* **Free. Open Source. Always. Forever.**  
No purchases, no memberships, no freemiums, no strings. NOUVEAU is free as in speech, and it’s going to stay that way. Forever.

In addition to having very well documented code, you can find a complete **Getting Started** tutorial at [NouveauFramework.org](http://nouveauframework.org/documentation/getting-started/)

## Setup

### Prerequisites
Sure you could just start writing CSS in style.css but... what is this, 2007? NOUVEAU is really meant to be used with SASS. As such, you'll need a few things installed on your computer to start building projects:

* node > = 10.0.0
* npm
* composer

### First Steps
NOUVEAU includes a bunch of namespaced strings and whatnot. Chances are you'll  want to make those your own, so your first steps should be: 

1. Rename the theme folder
1. Using your IDE of choice, run a case-sensitive find-replace for the following strings:
  * `nouveau-` & `nouveau_`  
    _Used in strings, css class names, functions, etc_ 
  * `nv_lang_scope`  
    _Theme i18n translation scope._

You can also find detailed documentation for NOUVEAU at [NOUVEAUFramework.org](https://nouveauframework.org/documentation/getting-started/), and documentation for Zurb Foundation at [foundation.zurb.com](https://foundation.zurb.com/sites/docs/)

### Installing & Building
To install all the various dependencies, just switch to your NOUVEAU theme directory and run the following commands...

1. `npm install` to install node dependencies (needed for Foundation and the build pipeline)
1. `composer install` to install PHP packages like Monolog and Codeception
1. `npm start` or `gulp` to begin watching and compiling assets

That's all there is to it!

### Installing Tests
NOUVEAU now uses and encourages Codeception for testing of your themes. After you've installed the Composer dependencies, you can begin configuring your testing suite with:

`codecept init wpbrowser`

You can find more detailed directions at [codeception.com/for/wordpress](https://codeception.com/for/wordpress#Install)

You can also test design and use-case coverage by using the WordPress [Theme Unit Test]( http://codex.wordpress.org/Theme_Unit_Test ).

### Generating Documentation
To generate documentation using PhpDocumentor, simply run the following command (after you've installed Composer dependencies, that is):

`php vendor/bin/phpdoc`

This will create a docs/ directory within your theme containing all the theme's PhpDoc documentation.

# Got Plugins?

WordPress themes (or theme frameworks) should never be monolithic monstrosities. As such, all the added functionality you could ever want is available as separate, neatly packaged "starter" plugins.

Browse NOUVEAU starter plugins at [NOUVEAUFramework.org](https://nouveauframework.org/download-nouveau/#plugin-downloads)

# Internationalization (I18n)

NOUVEAU comes with all text strings properly scoped for internationalization. Once you've updated your language scope string, you can run the CLI command `gulp build:pot` to update your `theme.pot` language file. It's that easy.
