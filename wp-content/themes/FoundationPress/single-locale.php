<?php
/**
 * Locale Single Template
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */
get_header(); ?>
<?php
////check we're authorised to view this locale. If not, bail!
$auth = alb_user_auth(get_current_user_id(), get_queried_object()->ID);
$company_link = false;

if($auth == 'none'):
    //// decide how to handle lack of auth - redirect?
endif;

/// get our connected company and reports
$connected_reports = new WP_Query( array(
  'connected_type' => 'locale_reports',
  'connected_items' => get_queried_object(),
  'nopaging' => true,
) );

$connected_company = new WP_Query( array(
  'connected_type' => 'company_locales',
  'connected_items' => get_queried_object(),
  'nopaging' => true,
) );

$years_array = array();
$years_posts = $connected_reports->get_posts();

foreach($years_posts as $year):
    $flip_array = array_flip($years_array);
    $year = get_post_time('Y');

    if(!array_key_exists($year, $flip_array)):
        array_push($years_array, $year);
    endif;

    $flip_array = array();
    $year = false;
endforeach;


//get additional data if company master
if($auth == 'master'):
    $company_link = get_permalink($connected_company->post->ID);
endif;

//// set up loop data for loop grid
$post_count = count($connected_reports->posts);
$i = 0;
?>
<div id="page-full-width" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>

<?php if($auth != 'none'): ?>
    <div class="landmark--large">
        <h3 class="locale__title">Welcome, <?php echo ($company_link ? '<a href="'.$company_link.'">'.$connected_company->post->post_title.'</a>' : $connected_company->post->post_title ); ?>. Please find reports for your property at <?php the_title(); ?> below.</h3>
        <h4></h4>
        <div>
            <span>Skip to year:</span>
            <?php foreach($years_array as $year_link): ?>
                <a href="#year-<?php echo $year_link; ?>"><?php echo $year_link; ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if($connected_reports->have_posts()):?>
        <?php $current_year = false; ?>

        <div class="row collapse">
            <?php while ( $connected_reports->have_posts() ) : $connected_reports->the_post(); ?>

                <?php $post_year = get_post_time('Y'); ?>
                <?php if($current_year != $post_year): ?>
                    <div class="report__year-seperator"><span id="year-<?php echo $post_year; ?>"><?php echo $post_year; ?></span></div>
                    <?php $current_year = $post_year; ?>
                <?php endif; ?>

                <?php $i++; ?>
                <div class="columns medium-6">
                    <article class="report__listing row collapse" id="post-<?php the_ID(); ?>">

                        <?php $report_prefix = '_reports_'; ?>
                        <?php $pdf_link = get_post_meta($post->ID, $report_prefix . 'pdf_id', true); ?>
                        <?php $submission_id = get_post_meta($post->ID, $report_prefix . 'sub_id', true); ?>

                        <div class="columns medium-3">
                            <a class="report__download" href="<?php echo $pdf_link; ?>"><img class="report__icon--download" alt="pdf download" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/pdficon.png"/></a>
                        </div>
                        <div class="columns medium-9">
                            <header class="report__header--listing">
                                <h2><a href="<?php echo $pdf_link; ?>">Albany Treatment Report</a></h2>
                            </header>
                            <footer>
                                <time pubate="<?php echo the_time('d-m-Y'); ?>">Date: <?php the_time('d-m-Y'); ?></time>
                                <span>ID: <?php echo $submission_id; ?></span>
                            </footer>
                        </div>
                    </article>
                </div>

            <?php endwhile;?>
        </div>
    <?php else: ?>
        Sorry, no reports to display.
    <?php endif; ?>
<?php else: ?>
    Sorry, you are not authorised to view this.
<?php endif; ?>

<?php do_action( 'foundationpress_after_content' ); ?>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
