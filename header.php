<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title>    
<?php if ( is_home() ) {bloginfo('name');}    
elseif ( is_category() ) {single_cat_title(); echo " 丨 "; bloginfo('name');}       
elseif (is_single() || is_page() ) {single_post_title(); echo " 丨 "; bloginfo('name');}      
elseif (is_search() ) {echo "搜索结果"; echo " 丨 "; bloginfo('name');}       
elseif (is_404() ) {echo '页面未找到!';}       
else {wp_title('',true);} ?> 
</title>
<?php $options=get_option('f_options'); ?>
<meta name="keywords" content="<?php if(is_single()){echo $keywords;}else bloginfo('name');?>" />
<meta name="description" content="<?php if(is_single()){echo $description;}else echo bloginfo('description'); ?>" />
<script type='text/javascript' src='<?php bloginfo("template_url"); ?>/js/jquery.min.js'></script>
<link rel="stylesheet" type="text/css" href="<?php bloginfo("template_url"); ?>/style.css" />
<link rel="shortcut icon" href="<?php bloginfo("template_url"); ?>/images/favicon.ico" type="image/x-icon" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="<?php echo get_bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="<?php bloginfo('comments_rss2_url'); ?>" />
<!--[if lt IE 9]>
<script src="js/modernizr.js"></script>
<![endif]-->
</head>
<body>
<header class="l-header">
<div class="hdbg"></div>
<div class="hdbg2"></div>
<div class="m-about">
    <div class="logo">

		<?php if($options['logo']){
				echo '<div class="player"><div id="pic" center="center;"></div><a href="javascript:void(0)" id="play" title="播放/暂停"><i class="flaticon-play43"></i></a></div><audio src="'.$options['logo1'].'" preload="auto"></audio>';
			}elseif ($options["logo2"]){
				echo '<a href="'.get_bloginfo("url").'" ><img src="'.$options["logo2"].'"></a>'; 
			}else{
				echo '<a href="'.get_bloginfo("url").'" ><img src="'.get_bloginfo('template_directory').'/images/logo.jpg"></a>'; 
			}	
		?>
		
	</div>
    	<h1 class="tit"><a href="<?php bloginfo('url'); ?>"><?php echo $options['logo3']; ?></a></h1>
        <div class="about"><?php echo $options['logo4']; ?></div>

</div>
<div class="m-nav">
	<ul class="nav">
		<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'nav', 'echo' => false)) )); ?>
	</ul>
</div>
</header>