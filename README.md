# NOUVEAU Starter Theme
**Contributors:** Veraxus  
**Donate link:** http://nouveauframework.org/  
**Author URI:** http://nouveauframework.org/  
**Tags:** framework, php7.2  
**Version:** 1.0  
**Foundation version:** 6.5  
**Requires at least:** 4.9  
**Tested up to:** 4.9  
**Stable tag:** 1.0  
**Text Domain:** nvLangScope  
**License:** GPL2+ & MIT  

NOUVEAU is an open-source, rapid-development theme & plugin framework for WordPress, built on Zurb Foundation 6 and PHP 7.1+. Work fast. Be awesome.

## Description

**NOUVEAU is NOT a ready-made theme; it is meant as a starting point for developers.**

NOUVEAU is a rapid-development framework for WordPress. Unlike other "theme frameworks" NOUVEAU doesn't try to cram everything into a single, overreaching, monolithic theme - instead, the theme is dedicated to presentation work, keeping things clean and easy.

If you want even more features, don't clutter your theme with them... that's what plugins are for! Download NOUVEAU's starter plugins for any features you really need in your project, and customize them quickly and easily. Everything is standardized, simple, clean, and well commented - so you can work fast.

## Features

* **Built for WordPress**
NOUVEAU isn’t a theme or a plugin, it’s a framework. Anything you need to quickly get started on a new theme or plugin is already there, letting you get right to the meat of your WordPress project.

* **Modular**
Everything is available a-la-carte. By keeping the theme and features separate, you can easily use or customize only what you need (as plugins), and none of what you don’t.

* **PHP 7.1+**
**Newer versions of PHP provides numerous benefits:** namespaces, closures, anonymous functions... and NOUVEAU takes advantage of that.

* **Zurb Foundation**
NOUVEAUs theme framework component is built on the latest version of Zurb Foundation, an open-source front-end framework that blows Bootstrap out of the water. Create responsive websites with incredible speed and flexibility.

* **Clean Code. No Assumptions**
No child themes, no file soup, no styles, no assumptions. Just clean, tidy, well-documented code and clean, tidy file structures.

* **Free. Open Source. Always. Forever.**
No purchases, no memberships, no freemiums, no strings. NOUVEAU is free as in speech, and it’s going to stay that way. Forever.

In addition to having very well documented code, you can find a complete **Getting Started** tutorial at [NouveauFramework.org](http://nouveauframework.org/documentation/getting-started/)

## Installation Instructions

**NOTE:** NOUVEAU is NOT a ready-made theme and should only be used by developers. it is specifically built to facilitate rapid development and easy maintenance. The code is clean, simple, and very well commented and documented.  

### Prerequisites for SASS developers
**If you want to use the SASS workflow, ensure that you have all of Foundations prerequisites met first.** Note that NOUVEAU uses the non-Compass version of Foundation, and is therefore compatible with compilers like libsass.

For full prerequisites, see: http://foundation.zurb.com/docs/sass.html).

To get started, make sure you have npm installed, switch to your NOUVEAU theme directory and run...

1. `npm install` to install all dependencies
1. `npm start` or `gulp` to begin watching and compiling sass & js

That's all there is to it!

### General Installation
To install, simply the copy the NOUVEAU theme folder to your `wp-content\themes` directory. Before activating, be sure you rename the theme folder and perform a global find-replace for the strings (case sensitive) `NOUVEAU`, `Nouveau`, and `nouveau`, as well as the language scope (`nvLangScope`).

You can find detailed documentation for NOUVEAU at [NOUVEAUFramework.org](http://nouveauframework.org/documentation/getting-started/), and documentation for Zurb Foundation at [foundation.zurb.com](http://foundation.zurb.com/docs/sass.html)

Also remember that you can test your own NOUVEAU derivatives by using the WordPress [Theme Unit Test]( http://codex.wordpress.org/Theme_Unit_Test ).

# File Structure

NOUVEAU has an file structure that encourages better organization of your theme.

General page templates (`index.php`, `archive.php`, `page.php`, `single.php`, etc) as well as critical files like `functions.php` still go in the theme's root folder. This allows WordPress's core template system to continue working as-is. As a rule, you should keep your PAGE templates here, and organize any fragment/part templates under the parts directory. This keeps the root clean and helps encourage use of clean, organized, reusable template parts.

You find a complete (yet concise) overview of file and folder structure at [NOUVEAUFramework.org](http://nouveauframework.org/documentation/getting-started/)

# Using Without SASS

If you don't want to use SASS, then everything is already compiled for you. Just write your plain CSS in the main `style.css` file (in the theme root) as you would normally do. Note that you will still need to run `npm install` to get all the Foundation packages, however.

# Companion Plugins

WordPress themes (and theme frameworks) should never be monolithic monstrosities. As a result, all the added functionality you could ever want are available separately as neatly packaged "starter" plugins.

Browse NOUUVEAU starter plugins at [NOUVEAUFramework.org](https://nouveauframework.org/download-nouveau/#plugin-downloads)

# Internationalization (I18n)

NOUVEAU comes with all text strings properly scoped for internationalization. To set a custom scope string, you can quickly run a project-wide search and replace for the string `nvLangScope` and you'll be up and running in no time.
