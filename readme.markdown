# Base Wordpress Theme for UCF Marketing

Simple theme which includes some of the most common theme elements found in most
of the wordpress sites we do.  Includes mechanisms to easily add styles and
scripts through the built-in wordpress functions.

Important files/folders:

* functions.php - Includes base code, custom post types, and shortcodes.  This
should also be where Config::$links, Config::$scripts, Config::$styles, and
Config::$metas should be defined.  See base theme's functions.php for examples.
* functions-base.php - Where functions and classes used throughout the theme are
defined.
* shortcodes.php - Where wordpress shortcodes can be defined.  See example
shortcode for more information.
* custom-post-types.php - Where the abstract custom post type and all its
descendants live.
* static - where, aside from style.css in the root, all static content such as
javascript, images, and css should live.

Since this theme wasn't really built to function like a separate library to use
in future themes, and more of a starting point for those themes, the best usage
of this repo might be to add it as a remote to new wordpress projects.  Then
you can merge from that remote as you wish to keep the current theme up to date.

So when setting up a new project, create an empty repo, setup the remote to this
repo, and merge it into the new repo creating the base theme.  Then make your
edits from there.

## Notes

* None

## Custom Post Types

* None

## Short Codes

* Slideshow - All top level elements contained within will be displayed as a slideshow.  Arguments controlling transition timing and animations are available.