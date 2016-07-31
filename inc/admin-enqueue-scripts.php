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

				var $multichecks = $('.tf-multicheck-posts');

				$multichecks.each( function() {

					var $this = $( this );
					var $fieldset = $this.children( 'fieldset' );
					var $labels = $fieldset.children( 'label' );
					var name = $( 'input:eq(0)', $this ).prop( 'name' );
					var checkboxes = [];
					var $select = $( '<select name="' + name + '" multiple></select>' );

					for ( var i = 0; i < $labels.length; i++ ) {
						checkboxes.push( {
							text: $( 'label', $this ).eq(i).text(),
							value: $( 'label', $this ).eq(i).find( 'input' ).val(),
							checked: $( 'label', $this ).eq(i).find( 'input' ).is( ':checked' )
						} );
					}

					$.each( checkboxes, function( i, v ) {
						$select.append(
							'<option value="{{value}}" {{selected}}>{{text}}</option>'
								.replace( '{{value}}', v.value )
								.replace( '{{text}}', v.text )
								.replace( '{{selected}}', v.checked ? 'selected' : '' )
						);
					} );

					$labels.remove();
					$fieldset.find( 'br' ).remove();
					$fieldset.append( $select );

				} );

				$( '.tf-select, .tf-multicheck-posts' ).find( 'select' ).css( 'width', '100%' ).chosen();
			} );
		</script>
		<?php
	} );
} );