<?php
//$post_id : int, id of post to attach pdf to
//$submission_id : string, unique identifier of form submission to match to pdf filename
function report_pdf_handle($post_id, $submission_id){

    error_log('post id:' . $post_id, 0);
    error_log('submission id:' . $submission_id, 0);


    $report_prefix = '_reports_';
    $pdf_folder = WP_CONTENT_DIR . '/uploads/fastform/';
    $glob_pdf = glob($pdf_folder . $submission_id .'.pdf');

//    error_log($pdf_folder . $submission_id .'.pdf', 0);

    if(!empty($glob_pdf) && FALSE != $glob_pdf):

        $attachment_array = array(
            'post_title' => $submission_id,
            'post_content' => '',
            'post_status' => 'publish',
            'post_mime_type' => 'pdf',
        );


        $pdf_attach_id = wp_insert_attachment($attachment_array, $glob_pdf[0]);
        error_log(print_r($pdf_attach_id,true), 0);


        if($pdf_attach_id != 0):

            $pdf_attach_url = wp_get_attachment_url($pdf_attach_id);
            error_log(print_r($pdf_attach_url,true), 0);

            update_post_meta($post_id, $report_prefix . 'pdf_id', $pdf_attach_url);
            update_post_meta($post_id, $report_prefix . 'pdf_id_id', $pdf_attach_id);
            error_log('just to be clear, we should be good right here. ');
            //return true;

        else:

            error_log('unable to create attachment from submission '.$submission_id, 0);
            //return false;

        endif;

    else:

        error_log('unable to find pdf with filename '.$submission_id, 0);

    endif;
}
//handle the FTP file
?>
