<?php
function form_post_handle() {

    $data = json_decode(file_get_contents('php://input'), true);
    if($data){

        //// LOGGING, REMOVE ON PRODUCTION
        error_log(print_r($data, true), 0);
        ////

        //make sure it's coming from valid account
        if($data['accountId'] == 31664):

            //init vars

            //required
            $submission_id = false;
            $locale_id = false;

            //not required
            $locale_address = '';
            $locale_postcode = '';
            $client_name = '';

            //get current admin user
            $admin_user_id = get_user_by('slug', 'albadmin')->ID;

            //get info from our submitted json
            $date = date('d-m-y-H-i');
            $submission_id = $data['submissionId'];
            $locale_id =  $data['locale_id'];
            $locale_address = $data['locale_address'];
            $locale_postcode = $data['locale_postcode'];
            $client_name =  $data['client_name'][0];

            if($submission_id && $locale_id):

                //build title string
                $title_string = $client_name.' '.$locale_address.' '.$date;

                $post_args = array(
                    'ID' => 0,
                    'post_author' => $admin_user_id,
                    'post_type' => 'report',
                    'post_title' => $title_string,
                    'post_content' => '',
                    'post_status' => 'publish',
                );

                $new_post_id = wp_insert_post($post_args, false);

                if(0 != $new_post_id):

                    $report_prefix = '_reports_';
                    $locale_prefix = '_locales_';

                    //custom meta update
                    update_post_meta($new_post_id, $report_prefix . 'sub_id', $submission_id);

                    //custom meta query to grab the connected locale by ID
                    $connected_locale_args = array(
                            'post_type' => 'locale',
                            'meta_key' => $locale_prefix . 'id',
                            'meta_value' => $locale_id,
                            'posts_per_page' => 1
                    );

                    $connected_locale_array = array();
                    $connected_locale_array = get_posts($connected_locale_args);

                    if(!empty($connected_locale_array)):
                        $connected_locale_post = $connected_locale_array[0];

                        //create a p2p connection

                        error_log(print_r($connected_locale_post->ID,true), 0);
                        error_log(print_r($new_post_id,true), 0);

                        $connect_post_locale = p2p_type( 'locale_reports' )->connect( $connected_locale_post->ID, $new_post_id, array(
                            'date' => current_time('mysql')
                        ) );


                    else:
                        /// locale creation code here?
                    endif;


                    //handle the FTP file
                    $pdf_folder = WP_CONTENT_DIR . '/uploads/fastform/';

                    $glob_pdf = glob($pdf_folder . $submission_id .'.pdf');

                    $attachment_array = array(
                        'post_title' => $title_string,
                        'post_content' => '',
                        'post_status' => 'publish',
                        'post_mime_type' => 'pdf',
                    );


                    $pdf_attach_id = wp_insert_attachment($attachment_array, $glob_pdf[0]);
                    error_log(print_r($pdf_attach_id,true), 0);


                    if($pdf_attach_id != 0):

                        $pdf_attach_url = wp_get_attachment_url($pdf_attach_id);
                        error_log(print_r($pdf_attach_url,true), 0);

                        update_post_meta($new_post_id, $report_prefix . 'pdf_id', $pdf_attach_url);
                        update_post_meta($new_post_id, $report_prefix . 'pdf_id_id', $pdf_attach_id);

                    else:

                        error_log('unable to create attachment from submission '.$submission_id, 0);

                    endif;

                else:

                    error_log('unable to create report post '.$submission_id, 0);

                endif;

            else:

                error_log('POST JSON did not have required information', 0);

            endif;

        endif;
    }
}
add_action( 'init', 'form_post_handle', 2 );
