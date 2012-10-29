# Base Wordpress Theme for UCF Marketing

Simple theme which includes some of the most common theme elements found in most of the WordPress sites we do.  Includes mechanisms to easily add styles and scripts through the built-in wordpress functions.

## Deployment

This theme relies on Twitter's Bootstrap framework. The Boostrap project (http://github.com/twitter/bootstrap) is added as submodule in static/bootstrap. To compile bootstrap:
1. Install the depenencies in the Developers section of the Boostrap README
2. Checkout the latest tag of Bootstrap
3. Run `make bootstrap` from the static/bootstrap directory