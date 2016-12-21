# UCF.edu Theme - [The Main Website for the University of Central Florida in Orlando, FL](http://www.ucf.edu)

Theme built off of Generic Bootstrap to convert UCF.edu into a responsive WordPress site.


## Required Plugins
* Gravity Forms
* Varnish Dependency Purger
* UCF News Plugin

## Recommended Plugins
* WordPress SEO


## Installation Requirements

WordPress 4.2 is required (primarly for access to wp-a11y accessibility script).

* Make sure that all two- and three-column pages are correctly assigned sidebar menu widgets when content is imported. Menus, when imported, should maintain a common naming schema ('More Information - Page Name', 'Secondary Nav - Page Name', etc.)
* Add cron job for jobs/feedback-mailer.php to run weekly for feedback emails. The job should use wget to request the file, and the URL should have a 'secret' param with a value that is identical to the value set for the 'Weekly Feedback Email Key' Theme Options setting.
* Make sure that the 'Weekly Feedback Email Key' Theme Options setting is set and that Email Recipients have been specified.
* Make sure that the 'Enable Edge Side Includes (ESI)' Theme Options setting is set to 'On'.
* In Theme Options > News, 'News Max Items' should be set to '3'.
* In Theme Options > Search, 'Enable Google Search' should be set to 'Off'.
* Make sure that the 'Feed URL' and 'More Information URL' Theme Options are set.
* In Appearance > Widgets, remove any existing widgets from 'Left Sidebar' (or 'Right Sidebar', if there are any.)


## Deployment

This theme relies on Twitter's Bootstrap framework. UCF's fork of the Bootstrap project (http://github.com/UCF/bootstrap/) is added as submodule in static/bootstrap. Bootstrap must be initialized as a submodule with every new clone of this theme repository.

#### Initializing Bootstrap with a new clone:
1. Pull/Clone the theme repo
2. From the theme's root directory, run `git submodule update --init static/bootstrap`
3. From the static/bootstrap directory, run `git checkout main-site`. Make sure a branch has been checked out for submodules as they will default to 'no branch' when cloned.

#### Alternative method using Git v1.6.5+:
1. Run `git clone` using the `--recursive` parameter to clone the repo with all of its submodules; e.g. `git clone --recursive https://github.com/UCF/Main-Site-Theme.git`
2. From the static/bootstrap directory, run `git checkout main-site`. Make sure a branch has been checked out for submodules as they will default to 'no branch' when cloned.


## Development

This theme relies on Twitter's Bootstrap framework. UCF's fork of the Bootstrap project (http://github.com/UCF/bootstrap/) is added as submodule in static/bootstrap. To compile bootstrap:

1. If this is a brand new clone, run `git submodule update --init static/bootstrap`
2. If they are not already installed, install the dependencies in the Developers section of the Boostrap README
3. Checkout the latest tag of Bootstrap
4. Run `make bootstrap` from the static/bootstrap directory to compile the files into static/bootstrap/bootstrap.


## Notes

* The function _save_meta_data() in functions/base.php (line 1572) has been modified to properly handle Slider content.
* Slider "slide" meta fields are not duplicate meta boxes, but are actually dynamically-generated duplicate field groups, whose field values are saved into a serialized array for the given field.
* static/js/admin.js includes multiple required scripts for the Slider editor to save/load field values properly.
* This theme comes with pre-built SEO options, such as page title generation and OpenGraph settings.  However, if WordPress SEO is enabled, the built-in theme options will no longer be used (WordPress SEO should be used exclusively to handle these settings.)


This theme utilizes Twitter Bootstrap as its front-end framework.  Bootstrap
styles and javascript libraries can be utilized in theme templates and page/post
content.  For more information, visit http://twitter.github.com/bootstrap/

Note that this theme may not always be running the most up-to-date version of
Bootstrap.  For the most accurate documentation on the theme's current
Bootstrap version, visit http://bootstrapdocs.com/ and select the version number
found at the top of static/bootstrap/build/css/bootstrap.css


## Custom Post Types

* Video
* Document
* Publication
* Person
* Slider (home page centerpieces)
* Spotlight
* Subheader
* AZIndexLink
* Announcement
* Degree


## Custom Taxonomies

* OrganizationalGroups (for 'Person' post type)
* Keywords (for 'Announcement' post type)
* AudienceRoles (for 'Announcement' post type)
* ProgramTypes (for 'Degree' post type)
* Colleges (for 'Degree' post type)
* Departments (for 'Degree' post type)


## Shortcodes

* [slideshow] - All top level elements contained within will be displayed as a slideshow.  Arguments controlling transition timing and animations are available.
* [search_form] - Displays a generic search form
* [person-picture-list] - Outputs a list of People with thumbnails
* [centerpiece] - Generates the home page centerpiece
* [events-widget] - Outputs Upcoming Events
* [post-type-search] - Generates a list of searchable posts
* [phonebook-search] - Generates the Phonebook Search page's contents
* [gravity-with-ldap] - Displays LDAP authentication unless already authenicated, which displays the gravity form (for Create Announcement form).
* [azindexlinks-webadmins] - Output a list of A-Z Index Links with their Web Administrator information.
* [google-remarketing] - Outputs Google Remarketing javascript code.
* [undergraduate-catalog-url] - Outputs the Undergraduate catalog URL in Theme Options.
* [graduate-catalog-url] - Outputs the Graduate catalog URL in Theme Options.


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
