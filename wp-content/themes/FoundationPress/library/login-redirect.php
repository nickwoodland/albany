<?php
//// redirect users if not logged in
function locking_template_redirect(){

    global $post;

    $current_post = $post->ID;

    if( !is_front_page() && !is_user_logged_in() ):

        wp_redirect( home_url() );
        exit();

    endif;

}
add_action( 'template_redirect', 'locking_template_redirect' );

function login_template_redirect($redirect_to, $request, $user){

    $current_user_id = $user->ID;
    error_log($current_user_id,0);

    $landing_page = get_user_landing_page($current_user_id);

    error_log($landing_page,0);

    if(false != $landing_page):
        return $landing_page;
    else:
        return $redirect_to;
    endif;
}
add_filter( 'login_redirect', 'login_template_redirect', 10, 3 );
?>
