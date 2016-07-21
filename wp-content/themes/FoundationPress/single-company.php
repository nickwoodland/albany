<?php
/**
 * Company Single Template
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>
<?php
$auth = alb_user_auth(get_current_user_id(), get_queried_object()->ID);

$connected_locales = new WP_Query( array(
  'connected_type' => 'company_locales',
  'connected_items' => get_queried_object(),
  'nopaging' => true,
) );
$post_count = count($connected_locales->posts);
$i = 0;
?>
<div id="single-post" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>

<?php if($auth != 'none'): ?>

    <h2>Welcome, <?php the_title(); ?></h2>

    <?php if($connected_locales->have_posts()):?>
        <div class="row">
            <?php while ( $connected_locales->have_posts() ) : $connected_locales->the_post(); ?>
                <?php $i++; ?>
                <div class="small-6 medium-4 columns <?php echo ($i == $post_count ? 'end' : ''); ?>">
                    <article class="locale__listing" id="post-<?php the_ID(); ?>">

                        <a href="<?php echo the_permalink(); ?>"><img class="locale__icon--download" alt="pdf download" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/pdficon.png"/></a>
                        <header class="locale__header--listing">
                            <h4><?php the_title(); ?></h4>
                        </header>
                    </article>
                </div>

            <?php endwhile;?>
        </div>
    <?php endif; ?>

<?php else: ?>
    <h1> NO DICE </h1>
<?php endif; ?>

<?php do_action( 'foundationpress_after_content' ); ?>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
