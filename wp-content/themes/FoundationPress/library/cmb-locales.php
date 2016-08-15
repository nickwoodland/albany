<?php
/**
 * Define the metabox and field configurations.
 */
function alb_locale_metaboxes() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_locales_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
        'id'            => $prefix . 'meta_metabox',
        'title'         => __( 'Locale Meta', 'cmb2' ),
        'object_types'  => array( 'locale', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    // Regular text field
    $cmb->add_field( array(
        'name'       => __( 'Locale ID', 'cmb2' ),
//        'desc'       => __( 'field description (optional)', 'cmb2' ),
        'id'         => $prefix . 'id',
        'type'       => 'text',
    //    'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );

    $cmb->add_field( array(
        'name'       => __( 'Locale Postcode', 'cmb2' ),
//        'desc'       => __( 'field description (optional)', 'cmb2' ),
        'id'         => $prefix . 'postcode',
        'type'       => 'text',
    //    'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );

    // Add other metaboxes as needed

}
add_action( 'cmb2_admin_init', 'alb_locale_metaboxes' );
?>
