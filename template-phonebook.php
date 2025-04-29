<?php
/**
 * Template Name: Phonebook
 * Template Post Type: page
 */
?>

<?php get_header(); the_post(); ?>

	<div class="bg-faded py-4 py-sm5">
		<div class="container d-flex">
					<input class="form-control" type="text" id="gsc-input" placeholder="" />
					<button class="btn btn-primary d-flex align-items-center" id="gsc-search-button"><span class="fa-sharp fa-solid fa-magnifying-glass mr-2"></span><span>Search</span></button>
		</div>
	</div>
	<div class="container">
		<div class="gcse-searchresults-only" data-gname="ucf-phonebook" data-queryParameterName="q"></div>
	</div>

	<script async src="https://cse.google.com/cse.js?cx=c41924672054e4f57&gname=ucf-phonebook"></script>


<?php get_footer(); ?>
