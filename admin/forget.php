<?php

add_action('admin_menu','theme_setting');

function theme_setting(){
	add_theme_page(__('主题设置'),__('主题设置'),'edit_themes',basename(__FILE__),'setting');
	add_action('admin_init', 'register_theme_setting');
}

function register_theme_setting(){
	register_setting('settings_group','f_options');
}

function setting(){

?>

<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/admin/admin.css"/>
<h2>forget主题设置</h2>
	<div class="wrap">
		
		<?php
			if(isset($_REQUEST['save'])){
				echo '<div id="message" class="updated fade"><p><strong> settings saved.</strong></p></div>';
			}
			if( 'reset' == isset($_REQUEST['reset']) ) {
				delete_option('f_options');
				echo '<div id="message" class="updated fade"><p><strong> settings reset.</strong></p></div>';
			}
		?>
		<form method="post" action="options.php">
			<?php settings_fields('settings_group'); ?>
			<?php $options=get_option('f_options'); ?>
			<div class="choice">
				<input type="radio" name="f_options[logo]" value="1" <?php checked('1',$options['logo']); ?> />使用音乐logo
				<input type="radio" name="f_options[logo]" value="" <?php checked('',$options['logo']); ?> />使用图片logo
				<div><span class="span2">音乐地址：</span><input type="text" name="f_options[logo1]" value="<?php echo $options['logo1']; ?>" /></div>
				<div><span class="span2">图片地址：</span><input type="text" name="f_options[logo2]" value="<?php echo $options['logo2']; ?>" /></div>
			</div>
			<div class="choice">
				<div><span class="span2">头部名称：</span><input type="text" name="f_options[logo3]" value="<?php echo $options['logo3']; ?>" placeholder="例：一百个梦里九十九个你"/></div>
				<div><span class="span2">头部描述：</span><input type="text" name="f_options[logo4]" value="<?php echo $options['logo4']; ?>" placeholder="例：分享音乐，分享心情，分享感动！"/></div>
			</div>
			<div class="choice">
				<div><span class="span2">座右铭称：</span><input type="text" name="f_options[motto]" value="<?php echo $options['motto']; ?>" placeholder="例：善良的人永远是受苦的"/></div>
				<div><span class="span2">座右铭述：</span><input type="text" name="f_options[motto-tell]" value="<?php echo $options['motto-tell']; ?>" placeholder="例：然而，宝剑锋从磨砺出，梅花香苦自苦寒来..."/></div>
			</div>
			<div class="choice">
				<div><span class="span2">公告：</span><textarea type="textarea" id="f_options[announcement]" name="f_options[announcement]" placeholder="例：hi，欢迎来到我的博客"><?php echo $options['announcement']; ?></textarea></div>
			</div>
			<hr>
			<div class="choice">
				<span class="span1">侧边栏相册：</span>
				<div class="choice_radio">
					<input type="checkbox" name="f_options[photo]" class="bg_radio" value="1" <?php if(checked($options['photo'])) echo 'checked="checked"' ?> />使用
					<span class="span3">（支持最多7张相册图片。地址不填则不显示图片）</span>
				</div>
				<div class="photo_text"  style="clear:both;margin-top:20px;">
					<div><span class="span2">图片一：</span><input type="text" name="f_options[photo_img_1]" value="<?php echo $options['photo_img_1']; ?>" /></div>
					<div><span class="span2">图片二：</span><input type="text" name="f_options[photo_img_2]" value="<?php echo $options['photo_img_2']; ?>" /></div>
					<div><span class="span2">图片三：</span><input type="text" name="f_options[photo_img_3]" value="<?php echo $options['photo_img_3']; ?>" /></div>
					<div><span class="span2">图片四：</span><input type="text" name="f_options[photo_img_4]" value="<?php echo $options['photo_img_4']; ?>" /></div>
					<div><span class="span2">图片五：</span><input type="text" name="f_options[photo_img_5]" value="<?php echo $options['photo_img_5']; ?>" /></div>
					<div><span class="span2">图片六：</span><input type="text" name="f_options[photo_img_6]" value="<?php echo $options['photo_img_6']; ?>" /></div>
					<div><span class="span2">图片七：</span><input type="text" name="f_options[photo_img_7]" value="<?php echo $options['photo_img_7']; ?>" /></div>
			</div>
			<div class="choice">
				<span class="span1">相册图片放大：</span>
				<div class="choice_radio">
					<input type="checkbox" name="f_options[phzoom]" value="1" <?php if(checked($options['phzoom'])) echo 'checked="checked"' ?> />使用
				</div>
			</div>
			<div class="choice">
				<div><span class="span2">多说最近访客：</span><input type="text" name="f_options[duoshuofk]" value="<?php echo $options['duoshuofk']; ?>" placeholder="你的多说二级域名名称"/></div></div>
			</div>
			<div class="choice">
				<div><span class="span2">页脚显示文字：</span><textarea type="textarea" id="f_options[footer]" name="f_options[footer]"><?php echo $options['footer']; ?></textarea></div>
			</div>
			<div class="submit">
				<input type="submit" name="Submit" value="保存设置"/>
			</div>
		</form>
		<form method="post">
			<div class="submit">
				<input type="submit" name="reset" value="重置"/>
				<input type="hidden" name="reset" value="reset" />
			</div>
		</form>
		<div style="padding:10px 0;color:rgba(0,0,0,0.4);">
			<p>感谢使用正版，发现问题可以到我<a href="http://azfashao.com">博客</a>留言或给我邮件azfashao@qq.com</p>
		</div>
		<div class="clear"></div>
	</div>
<?php } ?>