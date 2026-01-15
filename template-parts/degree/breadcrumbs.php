<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$program_type          = get_degree_program_type( $post );
	$colleges              = wp_get_post_terms( $post->ID, 'colleges' );
	$college               = is_array( $colleges ) ? $colleges[0] : null;

	$program_type_url_part = $program_type ? $program_type->slug . '/' : '';
	$college_url_part      = $college ? 'college/' . $college->slug . '/' : '';

	$degree_search_results = get_posts( array(
		'post_title'             => 'Degree Search',
		'post_type'              => 'page',
		'numberposts'            => 1,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
		'orderby'                => 'date ID',
		'order'                  => 'ASC',
	) );

	$degree_search_url     = ! empty( $degree_search_results ) ? get_permalink( $degree_search_results[0] ) : false;
	$college_url           = $degree_search_url . $college_url_part;
	$program_type_url      = $degree_search_url . $program_type_url_part . $college_url_part;
?>
<div class="container mt-4 mb-4 mb-sm-5 pb-md-3">
	<hr class="mt-5 mb-4">
	<nav class="breadcrumb" aria-label="Breadcrumb">
		<a class="breadcrumb-item" href="<?php echo $degree_search_url; ?>">Degree Search</a>

		<?php if ( $college ): ?>
		<a class="breadcrumb-item" href="<?php echo $college_url; ?>">
			<?php echo $college->name; ?>
			<span class="sr-only">programs</span>
		</a>
		<?php endif; ?>

		<?php if ( $program_type ) : ?>
		<a class="breadcrumb-item" href="<?php echo $program_type_url; ?>">
			<?php echo $program_type->name; ?>s
		</a>
		<?php endif; ?>

		<span class="breadcrumb-item active" aria-current="page"><?php echo $post->post_title; ?></span>
	</nav>
</div>
<?php endif; ?>
