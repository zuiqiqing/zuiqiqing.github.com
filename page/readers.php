<?php 
/*
 * Template Name: 读者墙
*/
get_header();
?>

<div class="mainContent">

<div class=" jsc-sidebar-content jsc-sidebar-pulled">
<div class="m-header">
		<a class="m-menu jsc-sidebar-trigger"></a>
		<a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
		<a href="<?php echo wp_login_url(); ?>" class="m-admin"></a>
</div>
	<div class="blogitem" style="margin-left: 0;float: none;">
<div class="content">
<article <?php post_class(); ?> style="margin-left: 0px;" id="post-<?php the_ID(); ?>">
    <h2 class="title" style="text-align: center;"><a class="slow" title="<?php the_title_attribute(); ?>">半年内读者排行</a></h2>
        <ul class="text">
<?php 
function readers_wall( $outer='1',$timer='6',$limit='159' ){
	global $wpdb;
	$counts = $wpdb->get_results("select count(comment_author) as cnt, comment_author, comment_author_url, comment_author_email from (select * from $wpdb->comments left outer join $wpdb->posts on ($wpdb->posts.id=$wpdb->comments.comment_post_id) where comment_date > date_sub( CURDATE(), INTERVAL $timer MONTH ) and user_id='0' and comment_author != '".$outer."' and post_password='' and comment_approved='1' and comment_type='') as tempcmt group by comment_author order by cnt desc limit $limit");
	foreach ($counts as $count) {
		$c_url = $count->comment_author_url;
		if (!$c_url) $c_url = '';
		$type .= '<a class="duzhe" target="_blank" href="'. $c_url . '" title="['.$count->comment_author.']近期评论'. $count->cnt . '次">'.get_avatar($count->comment_author_email, 32).''.$count->comment_author.'</a>';
	}
		echo $type;
};
?>
<?php 
function readers_walld( $outer='1',$timer='12',$limit='1' ){
	global $wpdb;
	$counts = $wpdb->get_results("select count(comment_author) as cnt, comment_author, comment_author_url, comment_author_email from (select * from $wpdb->comments left outer join $wpdb->posts on ($wpdb->posts.id=$wpdb->comments.comment_post_id) where comment_date > date_sub( CURDATE(), INTERVAL $timer MONTH ) and user_id='0' and comment_author != '".$outer."' and post_password='' and comment_approved='1' and comment_type='') as tempcmt group by comment_author order by cnt desc limit $limit");
	foreach ($counts as $count) {
		$c_url = $count->comment_author_url;
		if (!$c_url) $c_url = '';
		$type .= '<a class="duzhe item-top item-1" target="_blank" href="'. $c_url . '" title="['.$count->comment_author.']近期评论'. $count->cnt . '次"><h4>【金牌读者】<small>评论：'. $count->cnt . '</small></h4>'.get_avatar($count->comment_author_email, 32).'<strong>'.$count->comment_author.'</strong>'. $c_url . '</a>';
	}
		echo $type;
};
?>
<?php 
function readers_walla( $outer='1',$timer='12',$limit='2' ){
	global $wpdb;
	$counts = $wpdb->get_results("select count(comment_author) as cnt, comment_author, comment_author_url, comment_author_email from (select * from $wpdb->comments left outer join $wpdb->posts on ($wpdb->posts.id=$wpdb->comments.comment_post_id) where comment_date > date_sub( CURDATE(), INTERVAL $timer MONTH ) and user_id='0' and comment_author != '".$outer."' and post_password='' and comment_approved='1' and comment_type='') as tempcmt group by comment_author order by cnt desc limit $limit");
	foreach ($counts as $count) {
		$c_url = $count->comment_author_url;
		if (!$c_url) $c_url = '';
		$type .= '<a class="duzhe item-top item-2" target="_blank" href="'. $c_url . '" title="['.$count->comment_author.']近期评论'. $count->cnt . '次"><h4>【银牌读者】<small>评论：'. $count->cnt . '</small></h4>'.get_avatar($count->comment_author_email, 32).'<strong>'.$count->comment_author.'</strong>'. $c_url . '</a>';
	}
		echo $type;
};
?>
<?php 
function readers_wallb( $outer='1',$timer='12',$limit='3' ){
	global $wpdb;
	$counts = $wpdb->get_results("select count(comment_author) as cnt, comment_author, comment_author_url, comment_author_email from (select * from $wpdb->comments left outer join $wpdb->posts on ($wpdb->posts.id=$wpdb->comments.comment_post_id) where comment_date > date_sub( CURDATE(), INTERVAL $timer MONTH ) and user_id='0' and comment_author != '".$outer."' and post_password='' and comment_approved='1' and comment_type='') as tempcmt group by comment_author order by cnt desc limit $limit");
	foreach ($counts as $count) {
		$c_url = $count->comment_author_url;
		if (!$c_url) $c_url = '';
		$type .= '<a class="duzhe item-top item-3" target="_blank" href="'. $c_url . '" title="['.$count->comment_author.']近期评论'. $count->cnt . '次"><h4>【铜牌读者】<small>评论：'. $count->cnt . '</small></h4>'.get_avatar($count->comment_author_email, 32).'<strong>'.$count->comment_author.'</strong>'. $c_url . '</a>';
	}
		echo $type;
};
?>
<div class="readers">
<?php readers_walld(); ?>
<?php readers_walla(); ?>
<?php readers_wallb(); ?>
<?php readers_wall(); ?>
</div>
	
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
</article>
</div>
	</div>
</div>
</div>
 
<?php get_footer(); ?>
