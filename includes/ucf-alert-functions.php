<?php

if ( class_exists( 'UCF_Alert_Common' ) ) {

	/**
	 * Add custom alert layout for main site
	 **/

	function mainsite_alert_get_layouts( $layouts ) {
		$layouts = array_merge(
			$layouts,
			array(
				'faicon' => 'Icon Layout (req\'s FontAwesome and Athena Framework)'
			)
		);
		return $layouts;
	}

	add_filter( 'ucf_alert_get_layouts', 'mainsite_alert_get_layouts' );

	function mainsite_alert_display_faicon_before( $content, $args ) {
		$id = UCF_Alert_Common::get_alert_wrapper_id();
		ob_start();
	?>
		<div data-script-id="<?php echo $id; ?>" class="ucf-alert-wrapper"></div>
		<script type="text/html" id="<?php echo $id; ?>">
			<div class="alert ucf-alert ucf-alert-faicon" data-alert-id="" role="alert">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_alert_display_faicon_before', 'mainsite_alert_display_faicon_before', 10, 2 );

	function mainsite_alert_display_faicon( $content, $args ) {
		ob_start();
	?>
		<div class="container">
			<div class="row no-gutters">
				<div class="col col-lg-8 offset-lg-2">
					<a class="ucf-alert-content">
						<div class="row no-gutters">
							<div class="col-auto">
								<span class="ucf-alert-icon fa" aria-hidden="true"></span>
							</div>
							<div class="col">
								<strong class="ucf-alert-title h4"></strong>
								<div class="ucf-alert-body"></div>
								<div class="ucf-alert-cta"></div>
							</div>
						</div>
					</a>
				</div>
				<div class="col-auto">
					<button type="button" class="ucf-alert-close close" aria-label="Close alert">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_alert_display_faicon', 'mainsite_alert_display_faicon', 10, 2 );

	function mainsite_alert_display_faicon_after( $content, $args ) {
		ob_start();
	?>
			</div>
		</script>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_alert_display_faicon_after', 'mainsite_alert_display_faicon_after', 10, 2 );


	/**
	 * Set required settings changes for UCF-Alert-Plugin
	 **/
	update_option( 'ucf_alert_include_css', false ); // mainsite rolls its own alert layout/styles
	update_option( 'ucf_alert_include_js', true ); // mainsite uses vanilla UCF-Alert-Plugin js
	update_option( 'ucf_alert_include_js_deps', false ); // mainsite includes js-cookie; see below

	function mainsite_alert_js_deps() {
		// js-cookie is included in script.min.js; make sure
		// UCF-Alert-Plugin can use it:
		return array( 'jquery', 'script' );
	}
	add_filter( 'ucf_alert_script_deps', 'mainsite_alert_js_deps', 10, 0 );


	/**
	 * Hook into the header template to display the alert
	 **/
	function mainsite_display_alert() {
		echo UCF_Alert_Common::display_alert( 'faicon', array() );
	}
	add_filter( 'after_body_open', 'mainsite_display_alert', 1 );

}
