<?php

/**
 * Overrides the template for the degree search typeahead form.
 *
 * @since 3.0.0
 * @author Jim Barnes
 * @param string $output Existing typeahead markup
 * @param array $args Extra arguments passed in from `UCF_Degree_Search_Common::display_degree_search()`
 * @return string
 */
function main_site_degree_search_display( $output, $args ) {
	ob_start();
?>
	<form action="<?php echo get_permalink( get_page_by_path( 'degree-search' ) );?>" method="GET" class="degree-search">
		<div class="input-group degree-search">
			<input type="text" name="search" class="form-control degree-search-typeahead" aria-label="Search degree programs" placeholder="<?php echo $args['placeholder']; ?>">
			<span class="input-group-btn">
				<button type="submit" class="btn btn-degree-search btn-primary" aria-label="Search"><span class="fa fa-search" aria-hidden="true"></span></button>
			</span>
		</div>
	</form>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_degree_search_input', 'main_site_degree_search_display', 11, 2 );


/**
 * Overrides the template for degree search typeahead suggestions.
 *
 * @since 3.0.0
 * @author Jim Barnes
 * @return string
 */
function main_site_degree_search_suggestion() {
	ob_start();
?>
	<p class="ucf-degree-search-suggestion tt-suggestion">
		{{ title.rendered }} <em class="suggestion-match-type text-capitalize">{{ matchString }}</em>
	</p>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_degree_search_suggestion', 'main_site_degree_search_suggestion', 11, 0 );


/**
 * Modifies the list of filterable program types used
 * in the Angular degree search.
 *
 * @since 3.0.8
 * @author Jim Barnes
 * @return string
 */
function main_site_degree_search_program_types() {
	ob_start();
?>
	<div class="degree-search-types" ng-controller="ProgramController as programCtl" ng-init="programCtl.init()">
		<a class="text-decoration-none hover-text-underline" href ng-class="{'active': mainCtl.selectedProgramType === 'all'}" ng-click="programCtl.onClear()">View All</a>
		<ul class="degree-search-program-types list-unstyled">
			<li class="degree-search-type" ng-repeat="(key, type) in programCtl.programTypes">
				<a class="text-decoration-none hover-text-underline" href ng-class="{'active': mainCtl.selectedProgramType === type.slug}" ng-click="programCtl.onSelected(type.slug)">{{ type.name }}</a>
				<ul class="degree-search-type-children list-unstyled ml-3" ng-if="type.children && mainCtl.selectedParentProgramType == type.slug">
					<li class="degree-search-child-type" ng-repeat="(subkey, subtype) in type.children">
						<a class="text-decoration-none hover-text-underline" href ng-class="{'active': mainCtl.selectedProgramType === subtype.slug}" ng-click="programCtl.onSelected(subtype.slug)">{{ subtype.name }}</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
<?php
	return ob_get_clean();
}

add_filter( 'udsa_program_types_template', 'main_site_degree_search_program_types', 10, 0 );


/**
 * Modifies the list of filterable colleges used
 * in the Angular degree search.
 *
 * @since 3.0.8
 * @author Jim Barnes
 * @return string
 */
function main_site_degree_search_colleges() {
	ob_start();
?>
	<div class="degree-search-colleges" ng-controller="CollegeController as collegeCtl" ng-init="collegeCtl.init()">
		<a class="text-decoration-none hover-text-underline" href ng-class="{'active': mainCtl.selectedCollege == 'all'}" ng-click="collegeCtl.onClear()">View All</a>
		<ul class="degree-search-colleges list-unstyled">
			<li class="degree-search-college" ng-repeat="(key, college) in collegeCtl.colleges">
				<a class="text-decoration-none hover-text-underline" href ng-class="{'active': mainCtl.selectedCollege == college.slug}" ng-click="collegeCtl.onSelected(college.slug)">{{ college.name }}</a>
			</li>
		</ul>
	</div>
<?php
	return ob_get_clean();
}

add_filter( 'udsa_colleges_template', 'main_site_degree_search_colleges', 10, 0 );


/**
 * Modifies the result count markup on the Angular degree search.
 *
 * @since 3.0.8
 * @author Jim Barnes
 * @return string
 */
function main_site_degree_search_result_count() {
	ob_start();
?>
	<p class="text-muted my-3" ng-if="mainCtl.totalResults > 0" aria-live="polite">
		{{ mainCtl.resultMessage }}
	</p>
<?php
	return ob_get_clean();
}

add_filter( 'udsa_result_count_template', 'main_site_degree_search_result_count', 10, 0 );
