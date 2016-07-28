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
<div id="page-full-width" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>

<?php if($auth != 'none'): ?>

    <div class="landmark--large">
        <h3 class="company__title">Welcome, <?php the_title(); ?></h2>
        <h4 class="">Please find your company locations below.</h3>
    </div>

    <?php if($connected_locales->have_posts()):?>
        <div class="row">
            <?php while ( $connected_locales->have_posts() ) : $connected_locales->the_post(); ?>
                <?php $i++; ?>
                <div class="small-6 medium-3 columns <?php echo ($i == $post_count ? 'end' : ''); ?>">
                    <article class="locale__listing" id="post-<?php the_ID(); ?>">

                        <a href="<?php echo the_permalink(); ?>"><img class="locale__icon--view" alt="view locale" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/localeicon.png"/></a>
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
