<div id="back-to-top" class="red" data-scroll="body" style="display: block;">
<svg id="point-up" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32">
	<path d="M23.588 17.637c-0.359-0.643-0.34-1.056-2.507-3.057 0.012-7.232-4.851-12.247-5.152-12.55 0-0.010 0-0.015 0-0.015s-0.003 0.003-0.007 0.007l-0.007-0.007c0 0 0 0.005 0 0.015-0.299 0.305-5.141 5.342-5.097 12.575-2.158 2.010-2.138 2.423-2.493 3.068-0.65 1.178-0.481 5.888 0.132 6.957 0.613 1.069 1.629 0.293 1.977-0.004 0.348-0.298 1.885-2.264 2.263-2.176 0 0 0.465-0.090 0.989 0.414 0.518 0.498 1.462 0.966 2.27 1.033 0 0.001 0 0.002-0 0.003 0.005-0.001 0.010-0.001 0.015-0.002 0.005 0 0.010 0.001 0.015 0.001 0-0.001-0-0.002 0-0.003 0.808-0.070 1.749-0.543 2.265-1.043 0.522-0.507 0.988-0.419 0.988-0.419 0.378-0.090 1.923 1.869 2.272 2.165 0.35 0.296 1.369 1.067 1.977-0.005 0.608-1.072 0.756-5.783 0.101-6.958v0 0zM15.95 14.86c-1.349 0.003-2.445-1.112-2.448-2.492-0.003-1.38 1.088-2.5 2.437-2.503 1.349-0.003 2.445 1.112 2.448 2.492 0.003 1.379-1.088 2.5-2.437 2.503v0 0zM17.76 24.876c-0.615 0.474-1.236 0.633-1.801 0.626-0.566 0.009-1.187-0.147-1.804-0.617-0.553-0.403-1.047-0.348-1.308 0.003-0.261 0.351-0.169 2.481 0.152 2.939 0.321 0.458 0.697-0.298 1.249-0.327 0.552-0.028 1.011 1.103 1.221 1.75 0.107 0.331 0.274 0.633 0.5 0.654 0.226-0.023 0.392-0.326 0.497-0.657 0.207-0.648 0.661-1.781 1.213-1.756 0.553 0.026 0.932 0.78 1.251 0.321 0.319-0.459 0.401-2.59 0.139-2.94-0.262-0.35-0.757-0.403-1.308 0.003v0 0z" fill="#CCCCCC" />
</svg>
</div>
<?php $options=get_option('f_options'); ?>
 <footer>
   <div class="footavatar">
     <img src="<?php bloginfo('template_directory'); ?>/images/logo.jpg" class="footphoto">
     <ul class="footinfo">
       <p class="fname"><a><?php bloginfo('name');?></a></p>
       <p class="finfo"><?php bloginfo('description'); ?></p>
       <ul>
   </div>
   <section class="visitor">
     <h2>最近访客</h2>
      <ul class="ds-recent-visitors" data-avatar-size="50" data-num-items="13"></ul>
   </section>
   <div class="Copyright">
     <p><?php echo $options['footer']; ?><span style="display:none"><script type="text/javascript">var _bdhmProtocol=(("https:"==document.location.protocol)?" https://":" http://");document.write(unescape("%3Cscript src='"+_bdhmProtocol+"hm.baidu.com/h.js%3Ff018e5369428321fa1e0e506f5cbd384' type='text/javascript'%3E%3C/script%3E"));</script>
</span></p>
   </div>
 </footer>
<div class="m-footer">
   <div class="Copyright">
     <p><?php echo $options['footer']; ?></p>
   </div>
 </div>
 <div id="jquery_jplayer" class="jp-jplayer"></div>
<?php wp_footer(); ?>
<!--[if lt IE 9]>
	<script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
	<script src="http://libs.useso.com/js/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
<?php if($options['phzoom']) : ?>
<script src="<?php bloginfo('template_url'); ?>/js/phzoom.js"></script>
<link rel="stylesheet" type="text/css" href="<?php bloginfo("template_url"); ?>/js/phzoom.css" />
<script>
	$(document).ready(function () {
		$('.newpic a').phzoom({});//phzoom
	})
</script>
<?php echo''; ?>
<?php endif ;?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/ajax/comments-ajax.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/alljp.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.js"></script>
<script type="text/javascript">
var duoshuoQuery = {short_name:"<?php echo $options['duoshuofk']; ?>"};
(function() {
var ds = document.createElement('script');
ds.type = 'text/javascript';ds.async = true;
ds.src = 'http://static.duoshuo.com/embed.js';
ds.charset = 'UTF-8';
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ds);
})();
</script>
</body>
</html>