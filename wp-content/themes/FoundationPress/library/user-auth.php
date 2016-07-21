<?php
/// Functions for checking if user is authoriued to view specific company or locale based on p2p connection
//// $user_id (int) - ID of user you want to check
//// $object_id (int) ID of object you want to check against, should be either locale or company object
////
//// return $auth_code (string) string, either 'master', 'user' or 'none'

function alb_user_auth($user_id, $object_id) {

    $auth_code = 'none';

    $locale_connection = p2p_type( 'locale_users' )->get_p2p_id( $user_id, $object_id );
    $company_connection = p2p_type( 'company_master' )->get_p2p_id( $user_id, $object_id );

    if($company_connection):
        $auth_code = 'master';
        return $auth_code;
    endif;

    if(get_post_type($object_id) == 'locale'):

        $locale_company_q = new WP_Query( array(
          'connected_type' => 'company_locales',
          'connected_items' => $object_id,
          'nopaging' => true,
        ) );

        if($locale_company_q->have_posts()):

            $locale_company_id = $locale_company_q->post->ID;
            $locale_master_connection =  p2p_type( 'company_master' )->get_p2p_id( $user_id, $locale_company_id );

            if($locale_master_connection):
                $auth_code = 'master';
                return $auth_code;
            endif;


        endif;

        if($locale_connection):
            $auth_code = 'user';
            return $auth_code;
        endif;

    endif;

    return $auth_code;
}
?>
