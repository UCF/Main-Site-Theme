<?php
$post = isset( $post ) ? $post : get_queried_object();

// If/when we start supporting undergraduate RFIs, this block
// (and the rest of this template part) will have to be adjusted:
if ( degree_show_rfi( $post ) ) :
	$guid         = get_field( 'graduate_slate_id', $post );
	$form_div_id  = 'form_bad6c39a-5c60-4895-9128-5785ce014085';
	$rfi_form_src = get_degree_request_info_url_graduate( array(
		'sys:field:pros_program1' => $guid,
		'output' => 'embed',
		'div' => $form_div_id
	) );

	if ( $rfi_form_src ):
?>
	<div class="modal fade" id="requestInfoModal" tabindex="-1" role="dialog" aria-labelledby="requestInfoModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header px-4 pt-4">
					<h2 class="h5 modal-title d-flex align-items-center" id="requestInfoModalLabel">
						<span class="fa fa-info-circle fa-2x mr-3" aria-hidden="true"></span>
						Request Information
					</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mb-2 px-4 pb-4">
					<p class="mb-4">
						Enter your information below to receive more information about the <strong><?php echo wptexturize( $post->post_title ); ?></strong> program offered at UCF.
					</p>
					<div id="<?php echo $form_div_id; ?>">Loading...</div>
					<script>
					/*<![CDATA[*/
					var script = document.createElement('script');
					script.async = 1;
					script.src = '<?php echo $rfi_form_src; ?>' + ((location.search.length > 1) ? '&' + location.search.substring(1) : '');
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(script, s);
					/*]]>*/
					</script>
				</div>
			</div>
		</div>
	</div>
<?php
	endif;
endif;
