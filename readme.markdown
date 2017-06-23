# UCF.edu Theme - [The Main Website for the University of Central Florida in Orlando, FL](http://www.ucf.edu)

A responsive WordPress theme for ucf.edu, built off of the [Athena Framework](https://github.com/UCF/Athena-Framework).


## Installation Requirements

This theme is developed and tested against WordPress 4.7.3+ and PHP 5.3.x+.

### Required Plugins
* Advanced Custom Fields PRO
* Athena Shortcodes
* Gravity Forms
* UCF Alert Plugin
* UCF College Custom Taxonomy
* UCF Degree Custom Post Type
* UCF Degree Search Plugin
* UCF Events
* UCF Footer
* UCF News
* UCF Rest Menus
* UCF Section
* UCF Spotlight
* UCF Tuition and Fees
* UCF Weather Shortcode
* WordPress Social Stream

### Recommended Plugins
* Page Links To
* UCF Content Scheduler
* UCF Page Assets
* Varnish Dependency Purger
* WP-Mail-SMTP
* WP Allowed Hosts
* WP Shortcode Interface
* Yoast SEO


## Configuration
* Ensure that menus have been created and assigned to the Header Menu and Footer Menu locations.  Other sites on your environment that depend on the main site header navigation and/or the UCF Footer plugin should be configured to reference these menus' REST API endpoints.
* Import field groups (`dev/acf-fields.json`) using the ACF importer under Custom Fields > Tools.
* Ensure that webfonts have been properly configured to a [Cloud.Typography](https://www.typography.com/cloud/welcome/) CSS Key that [allows access to your environment](https://dashboard.typography.com/user-guide/managing-domains).
* Create and set a static front page under Settings > Reading.


## Development

Note that compiled, minified css and js files are included within the repo.  Changes to these files should be tracked via git (so that users installing the theme using traditional installation methods will have a working theme out-of-the-box.)

[Enabling debug mode](https://codex.wordpress.org/Debugging_in_WordPress) in your `wp-config.php` file is recommended during development to help catch warnings and bugs.

### Requirements
* node
* gulp

### Instructions
1. Clone the Main-Site-Theme repo into your development environment, within your WordPress installation's `themes/` directory: `git clone https://github.com/UCF/Main-Site-Theme.git`
2. `cd` into the Main-Site-Theme directory, and run `npm install` to install required packages for development into `node_modules/` within the repo
3. Copy `gulp-config.template.json`, make any desired changes, and save as `gulp-config.json`.
3. Run `gulp default` to process front-end assets.
4. If you haven't already done so, create a new WordPress site on your development environment, install the required plugins listed above, and set the Main Site Theme as the active theme.
5. Make sure you've done all the steps listed under "Configuration" above.
6. Run `gulp watch` to continuously watch changes to scss and js files.  If you enabled BrowserSync in `gulp-config.json`, it will also reload your browser when scss or js files change.
