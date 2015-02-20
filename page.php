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

<?php 
	if( have_posts() ){ 
		while ( have_posts() ){
			the_post(); 
			get_template_part( 'modules/template', get_post_format() );
		}
	}
?>
	<?php comments_template('', true); ?>
	</div>
</div>
</div>
 
<?php get_footer(); ?>