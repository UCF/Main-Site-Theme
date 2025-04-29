<?php
/**
 * Template Name: Phonebook
 * Template Post Type: page
 */
?>

<?php get_header(); the_post(); ?>

<?php
$query = isset( $_GET['query'] ) ? $_GET['query'] : '';
$results = get_phonebook_results( $query );
$phonebook_ctas = get_field( 'phonebook_ctas' );

?>


		<div class="container">
				<script async src="https://cse.google.com/cse.js?cx=c41924672054e4f57">
				</script>
				<div class="gcse-searchbox"></div>
		</div>
		<div class="container">
			<div class="gcse-searchresults"></div>
		</div>


<?php get_footer(); ?>
