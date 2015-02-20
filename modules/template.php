<div class="content">
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <h2 class="title"><a class="slow" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a><span class="edit"><?php edit_post_link();?></span></h2>
        <ul class="text">

		<?php the_content(); ?>
		
		<p class="zhuanzai">转载请注明：<a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> &raquo; <a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
        <div class="post-like">
         <a href="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>" class="favorite<?php if(isset($_COOKIE['bigfa_ding_'.$post->ID])) echo ' done';?>">喜欢 <span class="count">
            <?php if( get_post_meta($post->ID,'bigfa_ding',true) ){            
                    echo get_post_meta($post->ID,'bigfa_ding',true);
                 } else {
                    echo '0';
                 }?></span>
        </a>
 </div>
		</ul>
    <div class="textfoot">
		<span><?php the_tags('标签: ', ', ', ''); ?></span>
    </div>
</article>
</div>