<?php
/// return URL(string) of locale or company connected to user
/// current_user_id(int) is the ID of the user object you want to retrieve the landing page for
function get_user_landing_page($current_user_id){

    error_log($current_user_id,0);

    $redirect_to = false;

    $connected_locales = new WP_Query( array(
      'connected_type' => 'locale_users',
      'connected_items' => $current_user_id,
      'nopaging' => true,
    ) );

    $connected_companies = new WP_Query( array(
      'connected_type' => 'company_master',
      'connected_items' => $current_user_id,
      'nopaging' => true,
    ) );

    if($connected_companies->have_posts()):
        $redirect_to =  get_permalink($connected_companies->post->ID);
    elseif($connected_locales->have_posts()):
        $redirect_to =  get_permalink($connected_locales->post->ID);
    endif;

    return $redirect_to;
}

//connections for company CPT. Powered by p2p plugin
function p2p_company_connections() {
    // Company to master user
    p2p_register_connection_type( array(
        'name' => 'company_master',
        'from' => 'company',
        'to' => 'user',
        'admin_box' => array(
            'show' => 'any',
            'context' => 'advanced'
        ),
        'title' => array(
            'from' => __( 'Company Master Users', 'my-textdomain' ),
        ),
        'cardinality' => 'one-to-many'
    ) );

    //comapny to many locales
    p2p_register_connection_type( array(
        'name' => 'company_locales',
        'from' => 'company',
        'to' => 'locale',
        'admin_box' => array(
            'show' => 'any',
            'context' => 'advanced'
        ),
        'title' => array(
            'from' => __( 'Company Locations', 'my-textdomain' ),
        ),
        'cardinality' => 'one-to-many'
    ) );
}
add_action( 'p2p_init', 'p2p_company_connections', 10);

function p2p_locale_connections() {
    // Company to master user
    p2p_register_connection_type( array(
        'name' => 'locale_users',
        'from' => 'locale',
        'to' => 'user',
        'admin_box' => array(
            'show' => 'any',
            'context' => 'advanced'
        ),
        'title' => array(
            'from' => __( 'Locale Users', 'my-textdomain' ),
        ),
        'cardinality' => 'one-to-many'
    ) );

    p2p_register_connection_type( array(
        'name' => 'locale_reports',
        'from' => 'locale',
        'to' => 'report',
        'admin_box' => array(
            'show' => 'any',
            'context' => 'advanced'
        ),
        'title' => array(
            'from' => __( 'Locale Reports', 'my-textdomain' ),
        ),
        'cardinality' => 'one-to-many'
    ) );
}
add_action( 'init', 'p2p_locale_connections', 1);
