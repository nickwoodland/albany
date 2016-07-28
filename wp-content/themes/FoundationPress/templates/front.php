<?php
/*
Template Name: Front
*/
get_header(); ?>

<?php do_action( 'foundationpress_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div id="page-full-width" role="main">
    <div class="">
        <?php do_action( 'foundationpress_page_before_entry_content' ); ?>
        <div class="">
    	    <div class="entry-content">
        		<?php the_content(); ?>
                <div class="fp-login__wrapper login__wrapper">
                    <?php wp_login_form(); ?>
                </div>
    	    </div>
        </div>
		<footer>
			<?php wp_link_pages( array('before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'foundationpress' ), 'after' => '</p></nav>' ) ); ?>
			<p><?php the_tags(); ?></p>
		</footer>
		<?php do_action( 'foundationpress_page_before_comments' ); ?>
		<?php comments_template(); ?>
		<?php do_action( 'foundationpress_page_after_comments' ); ?>
	</div>
</div>
<?php endwhile;?>
<?php do_action( 'foundationpress_after_content' ); ?>

<div class="section-divider">
	<hr />
</div>

<?php get_footer(); ?>
