<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$catalog_desc_full = trim( get_field( 'degree_description_full', $post ) );

	if ( $catalog_desc_full ) :
?>
	<div class="modal fade" id="catalogModal" tabindex="-1" role="dialog" aria-label="Full Program Description" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header px-4 pt-4">
					<button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mb-2 px-4 px-sm-5 pb-4">
					<div class="degree-catalog-description">
						<?php echo $catalog_desc_full; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	endif;
endif;
