<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$catalog_url = get_field( 'degree_pdf', $post );
	$subplans    = null; // TODO
?>
	<div class="col-lg-5 col-xl-4 pl-lg-5 mt-5 mt-lg-0">
		TODO catalog blurb + btn
		<br>
		TODO subplans list
	</div>
<?php
endif;
