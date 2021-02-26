<?php
/**
 * Template Name: Statements
 * Template Post Type: page
 */
?>

<?php get_header(); the_post(); ?>

<?php
$statements_view     = apply_filters( 'mainsite_statements_view', null );
$statement_details   = $statements_view->get_statements_details( get_the_content() ) ?? get_the_content();
$statements          = $statements_view->get_statements_list() ?? '<p>No statements available.</p>';
$filters             = $statements_view->get_statement_filters() ?? '';
$pagination          = $statements_view->get_statement_pagination() ?? '';
?>

<div class="container mt-4 mt-md-5 pb-4 pb-md-5">
	<div class="row">
		<?php if ( $filters ) : ?>
		<div class="col-lg-4 mb-4 mb-lg-0">
			<?php echo $filters; ?>
		</div>
		<div class="col-auto hidden-md-down pr-lg-4">
			<hr class="hr-vertical" role="presentation">
		</div>
		<?php endif; ?>

		<div class="col">
			<?php echo $statement_details; ?>
			<?php echo $statements; ?>
			<?php echo $pagination; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
