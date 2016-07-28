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

    $empty_pdf_q = new WP_Query($post_args);

    if($empty_pdf_q->have_posts()):

        error_log("cron found some posts to work with");

        while ( $empty_pdf_q->have_posts() ) : $empty_pdf_q->the_post();

            error_log("cron post id " . $post->ID, 0);

            $submission_id = get_post_meta($post->ID,  $prefix . 'sub_id', true);
            error_log("cron submission id " .$submission_id, 0);


            if($submission_id && "" != $submission_id):

                error_log("cron calling pdf handle func", 0);
                pdf_handle($post->ID, $submission_id);

            else:
                error_log("cron report ". $post->Id . "has no report ID!", 0);
            endif;

        endwhile;
    endif;

}

add_action('wp', 'alb_report_cron_activation');
add_action('alb_report_check_event', 'alb_report_check');
