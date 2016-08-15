<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/favicon.ico" type="image/x-icon">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/apple-touch-icon-144x144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/apple-touch-icon-114x114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/apple-touch-icon-72x72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/apple-touch-icon-precomposed.png">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
        <?php
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
    ?>
	<?php do_action( 'foundationpress_after_body' ); ?>
	<?php if ( get_theme_mod( 'wpt_mobile_menu_layout' ) == 'offcanvas' ) : ?>
	<div class="off-canvas-wrapper">
		<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
		<?php get_template_part( 'parts/mobile-off-canvas' ); ?>
	<?php endif; ?>

	<?php do_action( 'foundationpress_layout_start' ); ?>
	<header id="masthead" class="site-header" role="banner">

		<div class="top-bar">

			<div class="row top-bar__inner" data-equalizer>

				<div class="show-for-large leftcol" data-equalizer-watch>
					<h3>Pest Control / Prevention &
					Management For London & UK
					Established 1999</h3>
				</div>

				<div class="columns large-4" data-equalizer-watch>
					<div class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<img src="<?php echo get_stylesheet_directory_uri().'/assets/images/site-logo.png'; ?>" alt="Albany Pest Control Site Logo" />
						</a>
					</div>
				</div>

				<div class="show-for-large rightcol" data-equalizer-watch>
					<h3>24 Hour Same Day
					Response Guaranteed</h3>
				</div>

				<div class="header__cta">
					<a class="quote">Get A Quotation</a>
					<a class="phone">0207 287 8845</a>
				</div>

			</div>

		</div>

		<nav class="main-navigation row">
			<?php foundationpress_primary_menu(); ?>
		</nav>

		<?php get_template_part( 'parts/mobile-nav' ); ?>

	</header>

	<section class="container">
		<?php do_action( 'foundationpress_after_header' ); ?>
