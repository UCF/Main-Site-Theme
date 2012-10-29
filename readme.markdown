# Generic Wordpress Theme for UCF Marketing

Simple theme which includes some of the most common theme elements found in most
of the wordpress sites we do.  Includes mechanisms to easily add styles and
scripts through the built-in wordpress functions.


## Installation Requirements:
* n/a


## Important files/folders:

### functions/base.php
Where functions and classes used throughout the theme are defined.

### functions/config.php
Where Config::$links, Config::$scripts, Config::$styles, and
Config::$metas should be defined.  Custom post types and custom taxonomies should
be set here via Config::$custom_post_types and Config::$custom_taxonomies.
Custom thumbnail sizes, menus, and sidebars should also be defined here.

### functions.php
Theme-specific functions only should be defined here.  (Other required
function files are also included at the top of this file.)

### shortcodes.php
Where Wordpress shortcodes can be defined.  See example shortcodes for more 
information.

### custom-post-types.php
Where the abstract custom post type and all its descendants live.

### static/
Where, aside from style.css in the root, all static content such as
javascript, images, and css should live.
Bootstrap resources should also be located here.


## Notes

This theme utilizes Twitter Bootstrap as its front-end framework.  Bootstrap
styles and javascript libraries can be utilized in theme templates and page/post
content.  For more information, visit http://twitter.github.com/bootstrap/

Note that this theme may not always be running the most up-to-date version of
Bootstrap.  For the most accurate documentation on the theme's current
Bootstrap version, visit http://bootstrapdocs.com/ and select the version number
found at the top of static/bootstrap/build/css/bootstrap.css


Since this theme wasn't really built to function like a separate library to use
in future themes, and more of a starting point for those themes, the best usage
of this repo might be to add it as a remote to new wordpress projects.  Then
you can merge from that remote as you wish to keep the current theme up to date.

So when setting up a new project, create an empty repo, setup the remote to this
repo, and merge it into the new repo creating the base theme.  Then make your
edits from there.


## Custom Post Types

### Document
* Basic post type for PDFs, Word docs, Excel sheets, etc.
* Specify external URL or upload a file.  External URL takes precedence over
uploaded file.
* Outputs mimetype css class for optional list item styling.

### Video
* Post type for associating a Youtube video, its description, and its thumbnail
within Wordpress.  Allows for easy video embed output via shortcode.

### Publication
* Defines an Issuu pub by its URL at http://publications.ucf.edu

### Person
* Defines a staff member.
* Can be organized via Organizational Group custom taxonomy.


## Custom Taxonomies

### Organizational Group (hierarchical)
* Defines a set of People.


## Shortcodes

### [slideshow]
* All top level elements contained within will be displayed as a slideshow.  
Arguments controlling transition timing and animations are available.
* Note: this does NOT output a Bootstrap carousel!  To include Bootstrap 
carousels, use the Wordpress HTML editor and insert your content using the
required Bootstrap classes.

### [posttype-list]
* Custom post types that have defined $use_shortcode as True can automatically
utilize this shortcode for displaying a list of posts created under the given
post type; e.g., [document-list] will output a list of all published Documents.
Additional parameters can be used to further narrow down the shortcode's results;
see the Theme Help section on shortcodes for an available list of filters.

### [search_form]
* Outputs the site search form.  The search form output can be modified via
searchform.php

### [publication]
* Include the defined Publication, referenced by its title.
* e.g., [publication name="Where are the robots Magazine"]

### [person-picture-list]
* Similar to [person-list], but also outputs thumbnails for each Person.

### [post-type-search]
* Outputs a list of People with thumbnails, person names, and job titles.
* If a person's description is available, a link to the person's profile will be outputted. If a thumbnail for the person does not exist, a default 'No Photo Available' thumbnail will display.
* An optional row_size parameter is available to customize the number of rows that will display, in addition to the other filter parameters available to the person-list shortcode.