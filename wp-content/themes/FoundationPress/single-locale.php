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


//get additional data if company master
if($auth == 'master'):
    $company_link = get_permalink($connected_company->post->ID);
endif;

//// set up loop data for loop grid
$post_count = count($connected_reports->posts);
$i = 0;
?>
<div id="single-post" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>

<?php if($auth != 'none'): ?>
    <h2>Welcome, <?php echo ($company_link ? '<a href="'.$company_link.'">'.$connected_company->post->post_title.'</a>' : $connected_company->post->post_title ); ?></h2>
    <h3>Please find reports for your property at <?php the_title(); ?> below.</h3>

    <?php if($connected_reports->have_posts()):?>
        <div class="row">
            <?php while ( $connected_reports->have_posts() ) : $connected_reports->the_post(); ?>
                <?php $i++; ?>
                <div class="small-6 medium-3 columns <?php echo ($i == $post_count ? 'end' : ''); ?>">
                    <article class="report__listing" id="post-<?php the_ID(); ?>">

                        <?php $report_prefix = '_reports_'; ?>
                        <?php $pdf_link = get_post_meta($post->ID, $report_prefix . 'pdf_id', true); ?>
                        <?php $submission_id = get_post_meta($post->ID, $report_prefix . 'sub_id', true); ?>

                        <a href="<?php echo $pdf_link; ?>"><img class="report__icon--download" alt="pdf download" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/pdficon.png"/></a>
                        <header class="report__header--listing">
                            <h4>Date: <?php the_time('d-m-Y'); ?></h4>
                            <h5>ID: <?php echo $submission_id; ?></h5>
                        </header>
                    </article>
                </div>

            <?php endwhile;?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <h1> ERROR NOT ALLOWED</h1>
<?php endif; ?>

<?php do_action( 'foundationpress_after_content' ); ?>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
