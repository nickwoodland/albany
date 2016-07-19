<?php
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
add_action( 'p2p_init', 'p2p_locale_connections', 10);
