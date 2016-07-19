<?php /* TEMPLATE TO FETCH PDF META OF LOGGED IN USER AND DISPLAY */?>
<?php /* use update_user_meta to store */ ?>
<?php
/*
Template Name: File Area
*/

get_header();
$current_user = get_current_user_id();
?>

<div id="page-full-width" role="main">

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
      <?php if(is_user_logged_in()): ?>
          <header>
              <h1><?php echo $current_user; ?></h1>
              <h1 class="entry-title"><?php the_title(); ?></h1>
          </header>
          <?php do_action( 'foundationpress_page_before_entry_content' ); ?>
          <div class="entry-content">
              <?php the_content(); ?>
          </div>
          <footer>
              <?php wp_link_pages( array('before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'foundationpress' ), 'after' => '</p></nav>' ) ); ?>
              <p><?php the_tags(); ?></p>
          </footer>
      <?php else: ?>
          <h1>You must be logged in to view this page.</h1>
      <?php endif; ?>
      <?php do_action( 'foundationpress_page_before_comments' ); ?>
      <?php comments_template(); ?>
      <?php do_action( 'foundationpress_page_after_comments' ); ?>
  </article>
<?php endwhile;?>

<?php do_action( 'foundationpress_after_content' ); ?>

</div>

<?php get_footer(); ?>
