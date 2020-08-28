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

$groups_with_results = 0;
if ( is_array( $results ) ) {
	foreach ( $results as $key => $grouped_results ) {
		if ( $key !== 'total_results' && count( $grouped_results ) > 0 ) {
			$groups_with_results++;
		}
	}
}

?>

<div class="container mt-md-4 pb-4 pb-md-5">
	<form id="phonebook-search" action="<?php echo get_permalink( $post->ID ); ?>">
		<div class="input-group">
			<label for="phonebook-search-query" class="sr-only">Search Organizations, Departments, and People at UCF</label>
			<input type="text" id="phonebook-search-query" name="query" class="search-query form-control" value="<?php echo stripslashes( htmlentities( $query ) ); ?>" placeholder="Organization, Department, or Person (Name, Email, Phone)">
			<span class="input-group-btn">
				<button class="btn btn-primary" type="submit"><span class="fa fa-search" aria-labelledby="search-btn-text"></span><span class="hidden-sm-down" id="search-btn-text"> Search</span></button>
			</span>
		</div>
	</form>
</div>

<?php if ( $query ): ?>
<hr role="presentation" class="my-0">

<div class="jumbotron bg-faded mb-0 px-0">
	<div class="container">
		<div class="phonebook-results">

			<?php if ( ! $results || ( $results && $results['total_results'] === 0 ) ) : ?>
			<div class="alert alert-warning">
				<p class="mb-0">No results were found.</p>
			</div>
			<?php else: ?>
				<p class="lead"><?php echo $results['total_results']; ?> phonebook results found for &ldquo;<?php echo stripslashes( htmlentities( $query ) ); ?>&rdquo;</p>

				<?php if ( $groups_with_results > 1 ) : ?>
				<nav class="d-sm-flex flex-sm-row align-items-sm-center" aria-label="Phonebook search result navigation">
					<span class="d-inline-block mr-4 pr-2">Jump to results for:</span>
					<ul class="nav px-2 px-sm-0">
						<?php if ( count( $results['organizations'] ) ) : ?>
						<li class="nav-item">
							<a class="nav-link px-2" href="#phonebook-organizations">Organizations</a>
						</li>
						<?php endif; ?>
						<?php if ( count( $results['departments'] ) ) : ?>
						<li class="nav-item">
							<a class="nav-link px-2" href="#phonebook-departments">Departments</a>
						</li>
						<?php endif; ?>
						<?php if ( count( $results['staff'] ) ) : ?>
						<li class="nav-item">
							<a class="nav-link px-2" href="#phonebook-staff">Staff</a>
						</li>
						<?php endif; ?>
					</ul>
				</nav>
				<?php endif; ?>

				<div class="mt-4 mt-sm-5 pt-2 pt-sm-0">
					<?php if ( count( $results['organizations'] ) ) : ?>
					<h2 id="phonebook-organizations" class="h3 sticky-top pt-3 pb-4 bg-faded">
						Organizations
						<span class="small d-inline-block ml-1">(<?php echo count( $results['organizations'] ); ?> results)</span>
					</h2>
					<ul class="card list-unstyled mb-5">
						<?php
						foreach ( $results['organizations'] as $org ) {
							echo format_phonebook_result( $org );
						}
						?>
					</ul>
					<?php endif; ?>

					<?php if ( count( $results['departments'] ) ) : ?>
					<h2 id="phonebook-departments" class="h3 sticky-top pt-3 pb-4 bg-faded">
						Departments
						<span class="small d-inline-block ml-1">(<?php echo count( $results['departments'] ); ?> results)</span>
					</h2>
					<ul class="card list-unstyled mb-5">
						<?php
						foreach ( $results['departments'] as $dept ) {
							echo format_phonebook_result( $dept );
						}
						?>
					</ul>
					<?php endif; ?>

					<?php if ( count( $results['staff'] ) ) : ?>
					<h2 id="phonebook-staff" class="h3 sticky-top pt-3 pb-4 bg-faded">
						Staff
						<span class="small d-inline-block ml-1">(<?php echo count( $results['staff'] ); ?> results)</span>
					</h2>
					<ul class="card list-unstyled mb-5">
						<?php
						foreach ( $results['staff'] as $staff ) {
							echo format_phonebook_result( $staff );
						}
						?>
					</ul>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>

<hr role="presentation" class="my-0">
<?php endif; ?>

<?php if ( isset( $phonebook_ctas ) ) : ?>
<div class="container mb-4 mb-sm-5">
	<?php echo $phonebook_ctas; ?>
</div>
<?php endif; ?>

<?php get_footer(); ?>
