<?php

add_action( 'wp', function() {

    if ( ! is_feed() && is_frontend() && ! current_URL_is_excluded() && current_country_is_included() && redirect_to_URL_is_valid() ) {
        $titan  = TitanFramework::getInstance( 'simple_country_redirect' );
        $redirect_to = $titan->getOption( 'redirect_to' );
        wp_redirect( $redirect_to );
    }
} ) ;

function is_frontend() {

    return 1
        && ! is_admin()
        && ! in_array( $GLOBALS[ 'pagenow' ], array( 'wp-login.php', 'wp-register.php' ) )
    ;
}

function current_URL_is_excluded() {
    global $wp;
    $titan  = TitanFramework::getInstance( 'simple_country_redirect' );
    $current_URL = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
    $post_ID = url_to_postid( $current_URL );

    $public_post_types_objects  = get_post_types( [ 'public' => TRUE ], 'objects' );
    $public_post_types_names    = array_keys( $public_post_types_objects );
    $supported_post_types_names = apply_filters( 'simple_country_redirect_post_types_array', $public_post_types_names );

    foreach ($supported_post_types_names as $post_type ) {
        $excluded_posts = $titan->getOption( 'excluded_posts_' . $post_type );
        if ( is_array( $excluded_posts ) && in_array( $post_ID, $excluded_posts ) ) {
           return TRUE; 
        }
    }
    return FALSE;
}

function current_country_is_included() {

    $titan = TitanFramework::getInstance( 'simple_country_redirect' );
    $redirected_countries = $titan->getOption( 'redirected_countries' );
    $country = strtoupper( do_shortcode( '[geoip_detect2 property="country.isoCode"]' ) );

    if ( 2 !== strlen( $country ) ) {
        $country = 'XX';
    }

    return is_array( $redirected_countries ) && in_array( $country, $redirected_countries );
}

function redirect_to_URL_is_valid() {

    $titan  = TitanFramework::getInstance( 'simple_country_redirect' );
    $redirect_to = $titan->getOption( 'redirect_to' );
    return filter_var( $redirect_to, FILTER_VALIDATE_URL );
}
