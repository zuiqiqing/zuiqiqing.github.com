<?php get_header(); ?>

<div class="mainContent">

<?php get_sidebar(); ?>

<div class=" jsc-sidebar-content jsc-sidebar-pulled">
<div class="m-header">
		<a class="m-menu jsc-sidebar-trigger"></a>
		<a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
		<a href="<?php echo wp_login_url(); ?>" class="m-admin"></a>
</div>
	<div class="blogitem">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="content">
<article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>
    <h2 class="title"><a class="slow" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a><span class="edit"><?php edit_post_link();?></span></h2>
        <ul class="text">
		<p class="attachment">
		<a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></a>
		</p>
		
		<?php the_content(); ?>
		
		<p class="previous-image"><?php previous_image_link( false, __( '« 上一张', 'forget' ) ); ?></p>
		<p class="next-image"><?php next_image_link( false, __( '下一张 »', 'forget' ) ); ?></p>
		</ul>
    <div class="textfoot">
    </div>
</article>
</div>

<?php endwhile; else: ?>
<?php endif; ?>

	</div>
	<?php comments_template('', true); ?>
</div>
</div>
 
<?php get_footer(); ?>