# UCF.edu Theme - [The Main Website for the University of Central Florida in Orlando, FL](http://www.ucf.edu)

A responsive WordPress theme for ucf.edu, built off of the [Athena Framework](https://github.com/UCF/Athena-Framework).

-----

## Installation Requirements

This theme is developed and tested against WordPress 4.7.3+ and PHP 5.3.x+.

### Required Plugins
These plugins *must* be activated for the theme to function properly, and/or to satisfy core feature requirements for ucf.edu.
* Advanced Custom Fields PRO
* Athena Gravity Forms
* Gravity Forms
* Redirection
* UCF Alert Plugin
* UCF College Custom Taxonomy
* UCF Degree Custom Post Type
* UCF Degree Search Plugin
* UCF Departments Taxonomy
* UCF Resource Search
* UCF Rest Menus
* UCF Section
* UCF Spotlight
* UCF Tuition and Fees

### Supported Plugins
These plugins provide features that are extended or modified by the theme; they are generally expected to be activated with the theme but are not technically required.
* Advanced Custom Fields: Read only
* UCF Academic Calendar Plugin
* UCF Charts Plugin
* UCF Events
* UCF Footer
* UCF News
* UCF Pegasus List Shortcode
* UCF Post List Shortcode
* UCF Social Plugin
* UCF Weather Shortcode
* Yoast SEO

### Other Recommended Plugins
These plugins add desirable features, some of which are environment-specific for ucf.edu, but are not technically required to use this theme.
* Athena Shortcodes
* Automatic Section Menu Shortcode
* Page Links To
* UCF Content Scheduler
* UCF Page Assets
* Varnish Dependency Purger or Varnish as a Service
* WP-Mail-SMTP
* WP Apple Touch Icons
* WP Allowed Hosts
* WP Shortcode Interface

-----

## Configuration
* Ensure that menus have been created and assigned to the Header Menu and Footer Menu locations.  Other sites on your environment that depend on the main site header navigation and/or the UCF Footer plugin should be configured to reference these menus' REST API endpoints.
* Import field groups (`dev/acf-fields.json`) using the ACF importer under Custom Fields > Tools.
* Ensure that webfonts have been properly configured to a [Cloud.Typography](https://www.typography.com/cloud/welcome/) CSS Key that [allows access to your environment](https://dashboard.typography.com/user-guide/managing-domains).
* Create and set a static front page under Settings > Reading.
* Create a redirect group with at least 1 redirect rule in the Redirection plugin for the Main Site/Alert Switchover.

-----

## Development

Note that compiled, minified css and js files are included within the repo.  Changes to these files should be tracked via git (so that users installing the theme using traditional installation methods will have a working theme out-of-the-box.)

[Enabling debug mode](https://codex.wordpress.org/Debugging_in_WordPress) in your `wp-config.php` file is recommended during development to help catch warnings and bugs.

### Requirements
* node
* gulp-cli

### Instructions
1. Clone the Main-Site-Theme repo into your local development environment, within your WordPress installation's `themes/` directory: `git clone https://github.com/UCF/Main-Site-Theme.git`
2. `cd` into the new Main-Site-Theme directory, and run `npm install` to install required packages for development into `node_modules/` within the repo
3. Optional: If you'd like to enable [BrowserSync](https://browsersync.io) for local development, or make other changes to this project's default gulp configuration, copy `gulp-config.template.json`, make any desired changes, and save as `gulp-config.json`.

    To enable BrowserSync, set `sync` to `true` and assign `syncTarget` the base URL of a site on your local WordPress instance that will use this theme, such as `http://localhost/wordpress/my-site/`.  Your `syncTarget` value will vary depending on your local host setup.

    The full list of modifiable config values can be viewed in `gulpfile.js` (see `config` variable).
3. Run `gulp default` to process front-end assets.
4. If you haven't already done so, create a new WordPress site on your development environment, and [install and activate theme dependencies](https://github.com/UCF/Main-Site-Theme/wiki/Installation#installation-requirements).
5. Set Main Site Theme as the active theme.
6. Make sure you've completed [all theme configuration steps](https://github.com/UCF/Main-Site-Theme/wiki/Installation#theme-configuration).
7. Run `gulp watch` to continuously watch changes to scss and js files.  If you enabled BrowserSync in `gulp-config.json`, it will also reload your browser when scss or js files change.
