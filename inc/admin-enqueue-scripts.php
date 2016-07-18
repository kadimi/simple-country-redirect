<?php

add_action( 'admin_enqueue_scripts', function( $hook ) {

	global $simple_country_redirect ;

	// Exit if not in this plugin settings page.
	$settings_page_hook = 'settings_page_' . $simple_country_redirect->plugin_slug; 
	if ( $settings_page_hook != $hook ) {
		return;
	}

	// Enqueue Chosen
	$assets_dir_url = $simple_country_redirect->plugin_dir_url . 'public/';
	wp_enqueue_script( 'chosen', $assets_dir_url . 'js/chosen.jquery.min.js', [ 'jquery' ] , '1.6.1', true );
	wp_enqueue_style( 'chosen', $assets_dir_url . 'css/chosen.min.css', null, '1.6.1' );

	// Add JS to footer
	add_action( 'admin_footer', function() {
		?>
		<script>
			jQuery( document ).ready( function( $ ) {
				$( '.tf-select select' ).chosen();
			} );
		</script>
		<?php
	} );
} );