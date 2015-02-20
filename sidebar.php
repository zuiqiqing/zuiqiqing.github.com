<?php $options=get_option('f_options'); ?>
   <aside class="sidebar jsc-sidebar" id="jsi-nav">
     <div class="cbl-logo">
      <div class="a-avatar">
        <a href="<?php bloginfo('url'); ?>"><span><?php bloginfo('name');?></span></a>
      </div>
	 </div>
	  <div class="fm-nav">
	  <ul class="fm-menu">
		<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'nav', 'echo' => false)) )); ?>
	  </ul>
	  </div>
	 <div class="m-sidebar">
      <section class="topspaceinfo">
        <h1><?php echo $options['motto']; ?></h1>
        <p><?php echo $options['motto-tell']; ?></p>
      </section>
      <div class="userinfo"> 
        <p class="q-fans">
			公告：<?php echo $options['announcement']; ?>
		</p> 
      </div>
	  <?php if($options['photo']) : ?>
      <section class="newpic">
         <h2>最新照片</h2>
         <ul>
           <div><a href="<?php echo $options['photo_img_1']; ?>"><img src="<?php echo $options['photo_img_1']; ?>"></a></div>
           <div><a href="<?php echo $options['photo_img_2']; ?>"><img src="<?php echo $options['photo_img_2']; ?>"></a></div>
           <div><a href="<?php echo $options['photo_img_3']; ?>"><img src="<?php echo $options['photo_img_3']; ?>"></a></div>
           <div><a href="<?php echo $options['photo_img_4']; ?>"><img src="<?php echo $options['photo_img_4']; ?>"></a></div>
           <div><a href="<?php echo $options['photo_img_5']; ?>"><img src="<?php echo $options['photo_img_5']; ?>"></a></div>
		   <div><a href="<?php echo $options['photo_img_6']; ?>"><img src="<?php echo $options['photo_img_6']; ?>"></a></div>
		   <div><a href="<?php echo $options['photo_img_7']; ?>"><img src="<?php echo $options['photo_img_7']; ?>"></a></div>
         </ul>
      </section>
	  <?php echo''; ?>
	  <?php endif ;?>
	  <?php 
if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_sitesidebar')) : endif; 

if (is_single()){
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_postsidebar')) : endif; 
}
else if (is_page()){
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_pagesidebar')) : endif; 
}
else if (is_home()){
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_sidebar')) : endif; 
}
else {
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_othersidebar')) : endif; 
}
?>
     </div>
    </aside>