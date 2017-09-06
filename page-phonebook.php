<?php get_header();
/**
 * The page template for the phonebook
 **/
$query = $_GET['query'];
$results = get_phonebook_results( $query );

?>
<div class="container">
	<form id="phonebook-search">
		<div class="input-group">
			<input type="text" id="phonebook-search-query" name="query" class="search-query form-control" value="<?php echo stripslashes( htmlentities( $query ) ); ?>" placeholder="Organization, Department, or Person(Name, Email, Phone)">
			<span class="input-group-btn">
				<button class="btn btn-primary" type="submit"><span class="fa fa-search"></span> Search
			</span>
		</div>
	</form>
	<?php if ( is_array( $results ) ) : ?>
	<div class="phonebook-results my-5">
		<?php if ( count( $results ) === 0 ) : ?>
			<p class="text-bold">No results were found.</p>
		<?php else :
			foreach( $results as $result ) {
				echo format_phonebook_result( $result );
			}
			endif; ?>
	</div>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
