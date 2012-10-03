# UCF.edu Theme

Theme built off of Generic Bootstrap to convert UCF.edu into a responsive WordPress site.

## Required Plugins

* Gravity Forms
* Gravity Forms + Custom Post Types
* WordPress Editorial Calendar

## Installation Requirements

* Add cron job for feedback_mailer.php to run weekly for feedback emails.

## Notes

* The function _save_meta_data() in functions/base.php (line 1572) has been modified to properly handle Slider content.
* Slider "slide" meta fields are not duplicate meta boxes, but are actually dynamically-generated duplicate field groups, whose field values are saved into a serialized array for the given field.
* static/js/admin.js includes multiple required scripts for the Slider editor to save/load field values properly.

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

## Custom Taxonomies

* OrganizationalGroups (for 'Person' post type)
* Keywords (for 'Announcement' post type)
* AudienceRoles (for 'Announcement' post type)

## Shortcodes

* [slideshow] - All top level elements contained within will be displayed as a slideshow.  Arguments controlling transition timing and animations are available.
* [search_form] - Displays a generic search form
* [person-picture-list] - Outputs a list of People with thumbnails
* [centerpiece] - Generates the home page centerpiece
* [events-widget] - Outputs Upcoming Events
* [post-type-search] - Generates a list of searchable posts