<?php
/**
 * Template Name: Phonebook
 * Template Post Type: page
 */
?>

<?php get_header(); ?>

<?php
$query = isset( $_GET['query'] ) ? $_GET['query'] : '';
$results = get_phonebook_results( $query );
$phonebook_ctas = get_field( 'phonebook_ctas' );
?>

<div class="container mt-md-4 mb-4 mb-sm-5 pb-md-5">
	<form id="phonebook-search">
		<div class="input-group">
			<label for="phonebook-search-query" class="sr-only">Search Organizations, Departments, and People at UCF</label>
			<input type="text" id="phonebook-search-query" name="query" class="search-query form-control" value="<?php echo stripslashes( htmlentities( $query ) ); ?>" placeholder="Organization, Department, or Person (Name, Email, Phone)">
			<span class="input-group-btn">
				<button class="btn btn-primary" type="submit"><span class="fa fa-search" aria-labelledby="search-btn-text"></span><span class="hidden-sm-down" id="search-btn-text"> Search</span></button>
			</span>
		</div>
	</form>

	<?php if ( $query ): ?>
	<div class="phonebook-results my-4 my-md-5">

		<?php if ( count( $results ) === 0 ) : ?>
			<div class="alert alert-warning">
				<p class="mb-0">No results were found.</p>
			</div>
		<?php else: ?>
			<?php
			foreach( $results as $result ) {
				echo format_phonebook_result( $result );
			}
			?>
		<?php endif; ?>

	</div>
	<?php
	else :
		if( isset( $phonebook_ctas ) ) {
			echo $phonebook_ctas;
		}
	endif;
	?>
</div>

<?php get_footer(); ?>
