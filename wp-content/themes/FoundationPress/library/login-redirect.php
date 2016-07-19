<?php
/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */
function file_manager_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $redirect_to;
		} else {
            
            $file_manager_page = get_page_by_path( 'user-file-page' );

            if($file_manager_page):
			    return get_permalink($file_manager_page->ID);
            else:
                return $redirect_to;
            endif;
		}
	} else {
		return $redirect_to;
	}
}

add_filter( 'login_redirect', 'file_manager_redirect', 10, 3 );
?>
