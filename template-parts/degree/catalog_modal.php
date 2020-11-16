<?php
$post = isset( $post ) ? $post : get_queried_object();

// If/when we start supporting undergraduate RFIs, this block
// (and the rest of this template part) will have to be adjusted:
if ( $post->post_type === 'degree' ) :
	$catalog_desc = trim( get_field( 'degree_description', $post ) );
	$curated_desc = trim( get_field( 'modern_description_copy', $post ) );
	$catalog_url  = get_field( 'degree_pdf', $post );

	if ( ! $curated_desc && ( $catalog_desc && $catalog_url ) ) :
?>
	<div class="modal fade" id="catalogModal" tabindex="-1" role="dialog" aria-labelledby="catalogModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header px-4 pt-4">
					<h2 class="h5 modal-title d-flex align-items-center" id="catalogModalLabel">
						<span class="fa fa-info-circle fa-2x mr-3" aria-hidden="true"></span>
						TODO
					</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mb-2 px-4 pb-4">
					<iframe src=""></iframe>
				</div>
			</div>
		</div>
	</div>
<?php
	endif;
endif;
