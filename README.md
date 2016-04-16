# NOUVEAU Starter Theme #
**Contributors:** Veraxus  
**Donate link:** http://nouveauframework.org/  
**Author URI:** http://nouveauframework.org/  
**Tags:** framework, php5.3  
**Version:** 0.11.4  
**Foundation version:** 6.2.1  
**Requires at least:** 4.4  
**Tested up to:** 4.6  
**Stable tag:** 0.11.4  
**Text Domain:** nvLangScope  
**License:** MIT & GPL2+  

NOUVEAU is an open-source, rapid-development theme & plugin framework for WordPress, built on Zurb Foundation 6 and PHP 5.3+. Work fast. Be awesome.

## Description ##

**NOUVEAU is NOT a ready-made theme and should only be used by developers.**

NOUVEAU is a rapid-development framework for WordPress. Unlike other "theme frameworks" NOUVEAU doesn't try to cram everything into a single, monolithic, Frankenstein's monster theme - instead, the theme is dedicated to presentation work, keeping things clean and easy.

If you want even more features, don't clutter your theme with them... there are plugins for that! Download NOUVEAU's starter plugins for any features you really need, and customize them quickly and easily. Everything is standardized, simple, clean, and well commented - so you can work FAST.

## Features ##

* **Built for WordPress**
NOUVEAU isn’t a theme or a plugin, it’s a framework. Anything you need to quickly get started on a new theme or plugin is already there, letting you get right to the meat of your WordPress project.

* **Modular**
Everything is available a-la-carte. By keeping the theme and features separate, you can easily use or customize only what you need (as plugins), and none of what you don’t.

* **PHP 5.3+**
**PHP 5.3 provides numerous benefits:** namespaces, closures, anonymous functions... and NOUVEAU takes advantage of that.  

* **Zurb Foundation**
NOUVEAUs theme framework component is built on the latest version of Zurb Foundation, an open-source front-end framework that blows Bootstrap out of the water. Create responsive websites with incredible speed and flexibility.

* **Clean Code. No Assumptions**
No child themes, no file soup, no styles, no assumptions. Just clean, tidy, well-documented code and clean, tidy file structures.

* **Free. Open Source. Always. Forever.**
No purchases, no memberships, no freemiums, no strings. NOUVEAU is free as in speech, and it’s going to stay that way. Forever.

In addition to having very well documented code, you can find a complete **Getting Started** tutorial at [NouveauFramework.com](http://nouveauframework.org/documentation/getting-started/)

## Installation Instructions ##

**NOTE:** NOUVEAU is NOT a ready-made theme and should only be used by developers. it is specifically built to facilitate rapid development and easy maintenance. The code is clean, simple, and very well commented and documented.  

### Prerequisites for SASS developers ###
**If you want to use the SASS workflow, ensure that you have all of Foundations prerequisites met first.** Note that NOUVEAU uses the non-Compass version of Foundation, and is therefore compatible with compilers like libsass.

For full prerequisites, see: http://foundation.zurb.com/docs/sass.html).  

### General Installation ###
To install, simply the copy the NOUVEAU theme folder to your `wp-content\themes` directory. Before activating, be sure you rename the theme folder and perform a global find-replace for the strings (case sensitive) `NOUVEAU`, `Nouveau`, and `nouveau`, as well as the language scope (`nvLangScope`).

You can find exhaustive documentation for NOUVEAU at [NOUVEAUFramework.com](http://nouveauframework.org/documentation/getting-started/), and documentation for Zurb Foundation at [foundation.zurb.com](http://foundation.zurb.com/docs/sass.html)

Also remember that you can test your own NOUVEAU derivatives by using the WordPress [Theme Unit Test]( http://codex.wordpress.org/Theme_Unit_Test ).

# File Structure #

NOUVEAU has an file structure that encourages better organization of your theme. It includes the following folders...

* **assets** - Contains non-php assets like javascript, css, images, and language files.
* **bower_components** - Foundation's basic dependencies - sass & javascript libraries, etc.
* **layout** - Contains the theme's global header and footer files, leaving the theme root free for page templates.
* **nv** - Contains the NOUVEAU core classes: hooks, helpers, etc.
* **overrides** - Contains template files that are used solely as admin-selectable page templates.
* **parts** - Contains any template chunks/fragments/parts that *do not* make up a page-level template. Articles, comments, etc.

General page templates (`index.php`, `archive.php`, `page.php`, `single.php`, etc) as well as critical files like `functions.php` still go in the theme's root folder. This allows WordPress's core template system to continue working as-is. As a rule, you should keep your PAGE templates here, and organize any fragment/part templates under the parts directory. This keeps the root clean and helps encourage use of clean, organized, reusable template parts.

You find a complete (yet concise) overview of file and folder structure at [NOUVEAUFramework.com](http://nouveauframework.org/documentation/getting-started/)

# Zurb Foundation Notes #

Foundation has been tweaked slightly to work as part of a WordPress theme, however the tweaks needed to ensure this compatibility are rather minor and covered in detail on [NOUVEAUFramework.com](http://nouveauframework.com)

If you don't want to use SASS, then everything is already compiled for you. Just write your plain CSS in the main `style.css` file (in the theme root) as you would normally do.

# Companion Plugins #

WordPress themes (and theme frameworks) should never be all-encompassing monstrosities. As a result, all the cool features you want are available as neatly packaged "starter" plugins. They are "starter" because these plugins are meant to be quickly and easily modified by developers like you, to do anything you need. They are literally just a starting point for your own development needs. Use what you want, and none of what you don't.

These plugins were created by developers, for developers. We hope they make your life as a developer much, much easier.

# Internationalization (I18n) #

NOUVEAU comes with all text strings properly scoped for internationalization. To set a custom scope string, you can quickly to a global search and replace for the string `nvLangScope` and you'll be up and running in no time.

# Changelog #

## 0.11.4 (2016-04-16) ##
* Added Gulp support (although if you're not using CodeKit, you really are doing it wrong). To use Gulp with NOUVEAU, switch to the theme directory and run `npm install`, then `npm start`

## 0.11.3 (2016-04-13) ##
* Updated Foundation for Sites to 6.2.1

## 0.11.2 (2016-03-15) ##
* Fixed a default callback

## 0.11.1 (2016-02-28) ##
* Adjusted method names for a consistent coding standard: classes are CamelCase with no underscores, methods are lowercase with underscores encouraged.
* Tweaks & improvements to MarkupGenerator
* Added some unit tests for MarkupGenerator
* Added phpdocs for the core NOUVEAU library; located in the theme's `_docs` folder.

## 0.11.0 (2016-02-27) ##
* Updated NOUVEAU to use Foundation for Sites 6.2!
* NOUVEAU now uses PSR-4 class autoloading. No more manual requires!
* The main NV class is now accessed through a singleton: `NV::i()`
* Global constants were removed and replaced with properties. E.g. `NV::i()->paths-theme` or `NV::i()->get_path('theme')`
* Applied WordPress coding standards to core NOUVEAU library.
* Created placeholder unit test scaffolding (more to come).
* Note: Some Foundation-oriented theme functions like `Theme::archive_nav()` still need to be re-implemented.

## 0.10.0 (2016-01-22) ##
* Updated NOUVEAU to use Foundation 6
* Tweaked some class names

## 0.9.22 (2015-05-20) ##
* Improved Foundation integration with WordPress's TinyMCE editor

## 0.9.21 (2015-04-01) ##
* Updated Foundation to 5.5.2

## 0.9.20 (2015-01-05) ##
* Updated Foundation to 5.5.1

## 0.9.19 (2014-12-19) ##
* Updated Foundation to 5.5
* Changed file structure: merged _foundation folder with theme root to improve compatibility with compilers, watchers, and other tools
* Foundation's humans.txt and robots.txt are no longer included in NOUVEAU Theme Framework

## 0.9.18 (2014-11-5) ##
* Updated Foundation to 5.4.7 (further improved libsass support)

## 0.9.17 (2014-10-20) ##
* Updated Foundation to 5.4.6 (improved libsass support)

## 0.9.16 (2014-10-06) ##
* Updated Foundation to 5.4.5
* Removed Compass support
* NOUVEAU now uses the compiler-agnostic version of Foundation, which means compiling with libsass is now an option
* For more info on why Compass was removed, see <http://www.nouveauframework.com/foundation-5-4-5-sass-compatibility-alert/>

## 0.9.15 (2014-08-30) ##
* Updated Foundation to 5.4.3

## 0.9.14 (2014-08-24) ##
* Updated Foundation to 5.4!

## 0.9.13 (2014-08-03) ##
* Updated Foundation to 5.3.3
* Fixed incorrect admin JS constant in \NV\Config::enqueue_admin_assets()

## 0.9.12 (2014-07-23) ##
* Updated Foundation to 5.3.1
* Removed Chrome Frame as it is no longer supported by Google

## 0.9.11 (2014-06-29) ##
* Updated Foundation to 5.3
* Foundation's jQuery (2.1.1) is now automatically used instead of WordPress's built-in 1.x version

## 0.9.10 (2014-06-08) ##
* Updated Foundation to 5.2.3
* Cleaned up JS files (now uses pre-minified bower files when appropriate)
* Now uses Foundation version of jQuery by default (instead of WordPress's safe-mode version)
* New constant: NV_BOWER (for Foundation's "bower_components" folder)

## 0.9.9 (2014-04-18) ##
* Updated Foundation to 5.2.2
* Renamed the single-comment template file to /parts/comments/single.php

## 0.9.8 (2014-03-23) ##
* Updated Foundation to 5.2.1
* Additional improvements to comment system

## 0.9.7 (2014-03-06) ##
* Updated Foundation to 5.2

## 0.9.6 (2014-02-17) ##
* Additional Foundation tweaks

### 0.9.5 (2014-02-11) ###
* Updated Foundation to 5.1.1 (Compass version)
* NOTE: Currently looking into doing a libsass version of Foundation 5 as well. Should be simple. *knock on wood*

### 0.9.4 (2014-01-15) ###
* Additional improvements to built-in comment system - still more left to do

### 0.9.3 (2014-01-09) ###
* Started implementing new comment handling system
* Various other minor updates

### 0.9.2 (2013-12-11) ###
* Updated Foundation to 5.0.2

### 0.9.1 (2013-12-11) ###
* New versioning (since the framework is pretty close to solid at this point)
* Added a \NV\WordPress::the_permalink() function, which allows the_permalink() style output by specifying post id
* Fixed the SCSS/CSS for the '.snappable' class when the admin bar is visible
* Henceforth, only the bare minimum Foundation Javascripts are loaded by default. Uncomment the specific features you want in \NV\Config::enqueue_assets()
* Related: A preliminary version of NouveauFramework.com is now live (but still needs so, so much work)

### 0.0.4 (2013-11-22) ###
* Renamed \NV\Hooks\Theme class to NV\Hooks\Config (which is a more accurate name)
* Updated Zurb Foundation to version 5, including...
* Reconfigured Foundation's ".sticky" class to ".snappable" instead, so it wont interfere with WordPress
* Setup Compass config.rb file for theme compatibility
* Updated the Foundation example override template

### 0.0.3 (2013-11-14) ###
* Added \NV\Theme::custom_loop() for simplifying the loops of custom queries.

### 0.0.2 (2013-10-21) ###
* Significant cleanup on code base. Lots of features moved into plugins.
* Rudimentary (very early) support for comments. A lot left to do on this.
* Small fixes to SASS/CSS using newest WP unit tests.

### 0.0.1 ###
* First commit. Lots and lots of cleanup left before official release.
