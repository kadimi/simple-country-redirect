<?php

add_action( 'admin_enqueue_scripts', function($hook) {

	if ( 'settings_page_simple_country_redirect' != $hook ) {
		return;
	}

	wp_enqueue_script( 'chosen', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.1/chosen.jquery.min.js', array( 'jquery' ), null, true );
	wp_enqueue_style( 'chosen', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.1/chosen.min.css' );

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