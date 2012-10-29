BOOTSTRAP = ./docs/assets/css/bootstrap.css
BOOTSTRAP_LESS = ./less/bootstrap.less
BOOTSTRAP_RESPONSIVE = ./docs/assets/css/bootstrap-responsive.css
BOOTSTRAP_RESPONSIVE_LESS = ./less/responsive.less
LESS_COMPRESSOR ?= `which lessc`
WATCHR ?= `which watchr`

#
# BUILD DOCS
#

docs: bootstrap
	rm docs/assets/bootstrap.zip
	zip -r docs/assets/bootstrap.zip bootstrap
	rm -r bootstrap
	lessc ${BOOTSTRAP_LESS} > ${BOOTSTRAP}
	lessc ${BOOTSTRAP_RESPONSIVE_LESS} > ${BOOTSTRAP_RESPONSIVE}
	node docs/build
	cp img/* docs/assets/img/
	cp js/*.js docs/assets/js/
	cp js/tests/vendor/jquery.js docs/assets/js/
	cp js/tests/vendor/jquery.js docs/assets/js/

#
# BUILD SIMPLE BOOTSTRAP DIRECTORY
# lessc & uglifyjs are required
#

bootstrap:
	mkdir -p build/img
	mkdir -p build/css
	mkdir -p build/js
	cp img/* build/img/
	lessc ${BOOTSTRAP_LESS} > build/css/bootstrap.css
	lessc --compress ${BOOTSTRAP_LESS} > build/css/bootstrap.min.css
	lessc ${BOOTSTRAP_RESPONSIVE_LESS} > build/css/bootstrap-responsive.css
	lessc --compress ${BOOTSTRAP_RESPONSIVE_LESS} > build/css/bootstrap-responsive.min.css
	cat js/bootstrap-transition.js js/bootstrap-alert.js js/bootstrap-button.js js/bootstrap-carousel.js js/bootstrap-collapse.js js/bootstrap-dropdown.js js/bootstrap-modal.js js/bootstrap-tooltip.js js/bootstrap-popover.js js/bootstrap-scrollspy.js js/bootstrap-tab.js js/bootstrap-typeahead.js > build/js/bootstrap.js
	uglifyjs -nc build/js/bootstrap.js > build/js/bootstrap.min.js

#
# MAKE FOR GH-PAGES 4 FAT & MDO ONLY (O_O  )
#

gh-pages: docs
	rm -f ../bootstrap-gh-pages/assets/bootstrap.zip
	node docs/build production
	cp -r docs/* ../bootstrap-gh-pages

#
# WATCH LESS FILES
#

watch:
	echo "Watching less files..."; \
	watchr -e "watch('less/.*\.less') { system 'make' }"


.PHONY: bootstrap docs watch gh-pages