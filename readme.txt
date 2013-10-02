=== NOUVEAU ===
Contributors: Veraxus
Donate link: http://www.nouveauframework.com/
Author URI: http://mattvanandel.com/
Tags: framework, php5.3
Description: A rapid-development theme framework built specifically for WordPress and PHP 5.3+ (Developers Only)
Version: 0.0.1
Requires at least: 3.6
Tested up to: 3.6
Stable tag: 0.0.1
License: GNU General Public License
License URI: GNU-LICENSE.txt

A rapid-development WordPress theme framework built on Zurb Foundation 4 and PHP 5.3+

== Description ==

NOUVEAU is NOT a ready-to-use theme, it is a bare-bones theme framework targeted squarely at developers.

Built on the SASS version of Zurb Foundation 4, and making full use of PHP 5.3's namespaces and closures,
NOUVEAU allows developers to create complex WordPress sites with unprecedented speed and organization.

= Features = 
* Built on Zurb Foundation 4.2.3 (including SASS)
* PHP 5.3+ native with a fully namespaced code library.
* Better organization. Say goodbye to file soup in your theme's root directory.
* Simply comment or uncomment features you want.
* Highly documented code base for rapid familiarization.

== Installation Instructions == 

NOUVEAU is NOT a finished theme and should not be used by non-developers; it is specifically built to facilitate rapid
development and easy maintenance by developers. The code is clean, simple, and very well commented.

Also remember that you should test your own NOUVEAU derivatives by using the WordPress Theme Unit Test (
http://codex.wordpress.org/Theme_Unit_Test ).

=== File Structure ===

NOUVEAU has an file structure that encourages better organization of your theme. It includes the following folders...

* _compass - Contains all the original Zurb Foundation files. Uncompiled SASS, JavaScript, etc.
* assets - Contains non-php assets like javascript, css, images, and language files.
* layout - Contains the theme's global header and footer files, leaving the theme root for page templates.
* nv - Contains all the NOUVEAU core classes.
* overrides - Contains special admin-selectable page templates.
* parts - Any template fragments that do not make up a complete page. Articles and other fragments go here.

General page templates still go in the template's root folder. This allows WordPress's core template system to continue
working as-is. As a rule, you should keep your PAGE templates here, and organize any fragment/part templates under the
parts directory. This keeps the root clean and helps encourage use of clean, organized, reusable template parts.

=== Foundation Notes ===

Foundation has been adapted to work as part of a WordPress theme. These updates needed to ensure this compatibility
are rather minor. One important thing to note is that config.rb (i.e. the Compass configuration file) is located in
the theme's root directory while the uncompiled Zurb files are located in the _compass directory. This allows you to
set your compiler (e.g. Compass or CodeKit) to watch the theme folder, and everything is just put in the right places
for you automatically (again, config.rb is already set up for this).

If you don't want to use SASS, then everything is already compiled for you. Just write your plain CSS in the main
style.css file (in the theme root) as you would normally do.

=== Companion Plugins ===

There's only so much you should be doing in a WordPress theme, so to encourage keeping things tidy, flexible, and
semantic, we've split a LOT of NOUVEAU's functionality into a wide array of "starter plugins". Like this theme, each
plugin should serve as a framework/starting point for your own purposes. These were created by developers, for developers,
to make your life as a developer much, much easier.

Also remember that you can use www.generatewp.com to quickly generate drop-in code for your custom web projects. This
includes custom post types, taxonomies, shortcodes, menus, etc. It's a fantastic FREE resource.

=== Internationalization (I18n) ===

NOUVEAU comes with all strings properly scoped for internationalization. To set a custom scope string, you can quickly
to a global search and replace for the string 'nvLangScope'.

== Changelog ==

= 0.0.1 =
* First commit. Lots and lots of cleanup left before official release.