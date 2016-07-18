<?php

add_action( 'wp', function() {

    // Are we on the frontend?
    $is_frontend = ! is_admin() && ! in_array( $GLOBALS[ 'pagenow' ], array( 'wp-login.php', 'wp-register.php' ) );

    // Redirect only if in frontend.
    if (  $is_frontend ) {

        $country = strtoupper( do_shortcode( '[geoip_detect2 property="country.isoCode"]' ) );
        if ( 2 !== strlen( $country ) ) {
            $country = 'XX';
        }

        $titan = TitanFramework::getInstance( 'simple_country_redirect' );
        $redirected_countries = $titan->getOption( 'redirected_countries' );
        $redirect_to = $titan->getOption( 'redirect_to' );

        // Should we redirect?
        $must_redirect = is_array( $redirected_countries ) && in_array( $country, $redirected_countries );

        // Redirect when applicable
        if ( $must_redirect ) {
            wp_redirect( $redirect_to );
        }
    }
} ) ;
