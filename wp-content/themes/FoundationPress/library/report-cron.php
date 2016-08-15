<?php
///// WIP
function alb_report_cron_activation() {
	if ( !wp_next_scheduled( 'alb_report_check_event' ) ) {
		wp_schedule_event( current_time( 'timestamp' ), 'hourly', 'alb_report_check_event');
	}
}

function alb_report_check() {

 error_log("doing cron!", 0);

    $prefix = '_reports_';

    $post_args = array(
        'post_type' => 'report',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => $prefix . 'pdf_id',
                'value' => false,
                'type' => 'BOOLEAN'
            ),
           array(
                'key' => $prefix . 'pdf_id',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key' => $prefix . 'pdf_id',
                'value' => ''
            ),
        ),
        'posts_per_page' => 5
    );

    $empty_pdf_q = get_posts($post_args);

    error_log(print_r($empty_pdf_q, true),0);

    foreach($empty_pdf_q as $empty_pdf_post):

        error_log('post obj: ' . print_r($empty_pdf_post, true),0);

        error_log("cron post id: " . $empty_pdf_post->ID, 0);

        $submission_id = get_post_meta($empty_pdf_post->ID,  $prefix . 'sub_id', true);
        error_log("cron submission id: " .$submission_id, 0);


        if($submission_id && "" != $submission_id):

            error_log("cron calling pdf handle func", 0);
            report_pdf_handle($empty_pdf_post->ID, $submission_id);

        else:
            error_log("cron report ". $empty_pdf_post->Id . "has no submission ID!", 0);
        endif;

        error_log("------------------------------------------------------", 0);

    endforeach;

    /*if($empty_pdf_q->have_posts()):

        error_log("cron found some posts to work with");

        while ( $empty_pdf_q->have_posts() ) : $empty_pdf_q->the_post();

            error_log('post obj: ' . print_r($post, true),0);

            error_log("cron post id: " . $post->ID, 0);

            $submission_id = get_post_meta($post->ID,  $prefix . 'sub_id', true);
            error_log("cron submission id: " .$submission_id, 0);


            if($submission_id && "" != $submission_id):

                error_log("cron calling pdf handle func", 0);
                report_pdf_handle($post->ID, $submission_id);

            else:
                error_log("cron report ". $post->Id . "has no submission ID!", 0);
            endif;

            error_log("------------------------------------------------------", 0);

        endwhile;
    endif;*/

}

add_action('wp', 'alb_report_cron_activation');
add_action('alb_report_check_event', 'alb_report_check');
