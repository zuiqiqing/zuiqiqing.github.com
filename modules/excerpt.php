<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <h2 class="title"><a class="slow" href="<?php the_permalink() ?>" title="详细阅读 <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<ul class="text">
		<p><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a></p>
		<?php if (has_excerpt()){ 
			the_excerpt();
			}else{
			the_content();
			}
		?>
        </ul>
    <div class="textfoot">
	<p style="float:left;"><?php the_category(', ');?></p>
	<a><time datetime="<?php the_time('Y/m/d') ?>"><?php the_time('Y/m/d') ?></time></a>
	<a>围观：<?php echo guimeng_get_post_views(get_the_ID()); ?>人</a>
    <a href="<?php the_permalink() ?>" title="详细阅读 <?php the_title(); ?>">阅读全文</a>
	<a href="<?php the_permalink() ?>#comment">评论<?php comments_number('', '1人', '%人' );?></a>
    </div>
</article>