<?php

include('admin/forget.php');
include("modules/function.php");
include('modules/wid-comment.php');

$dname = 'forget';
add_action( 'after_setup_theme', 'f_setup' );
function f_setup(){
  
	//去除头部冗余代码
	remove_action( 'wp_head',   'feed_links_extra', 3 ); 
	remove_action( 'wp_head',   'rsd_link' ); 
	remove_action( 'wp_head',   'wlwmanifest_link' ); 
	remove_action( 'wp_head',   'index_rel_link' ); 
	remove_action( 'wp_head',   'start_post_rel_link', 10, 0 ); 
	remove_action( 'wp_head',   'wp_generator' ); 

	//评论回复邮件通知
	add_action('comment_post','comment_mail_notify'); 	

	//去除自带js
	wp_deregister_script( 'l10n' ); 

	add_filter('wp_mail_from', 'f_res_from_email');
	add_filter('wp_mail_from_name', 'f_res_from_name');
	
	//缩略图设置
	add_theme_support('post-thumbnails');

	//定义菜单
	if (function_exists('register_nav_menus')){
		register_nav_menus( array(
			'nav' => __('网站导航'),
			'pagemenu' => __('页面导航')
		));
	}

}
/* short code [] 短代码 1边栏，2评论，3摘要 */
add_filter('widget_text','do_shortcode');
add_filter('comment_text','do_shortcode');
add_filter('the_excerpt','do_shortcode');

if (function_exists('register_sidebar')){
	register_sidebar(array(
		'name'          => '全站侧栏',
		'id'            => 'widget_sitesidebar',
		'before_widget' => '<section class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget_tit">',
		'after_title'   => '</h2>'
	));
	register_sidebar(array(
		'name'          => '首页侧栏',
		'id'            => 'widget_sidebar',
		'before_widget' => '<section class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget_tit">',
		'after_title'   => '</h2>'
	));
	register_sidebar(array(
		'name'          => '分类/标签/搜索页侧栏',
		'id'            => 'widget_othersidebar',
		'before_widget' => '<section class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget_tit">',
		'after_title'   => '</h2>'
	));
	register_sidebar(array(
		'name'          => '文章页侧栏',
		'id'            => 'widget_postsidebar',
		'before_widget' => '<section class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget_tit">',
		'after_title'   => '</h2>'
	));
	register_sidebar(array(
		'name'          => '页面侧栏',
		'id'            => 'widget_pagesidebar',
		'before_widget' => '<section class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget_tit">',
		'after_title'   => '</h2>'
	));
}

//修改默认发信地址
function f_res_from_email($email) {
$wp_from_email = get_option('admin_email');
return $wp_from_email;
}
function f_res_from_name($email){
$wp_from_name = get_option('blogname');
return $wp_from_name;
}


// 取消原有jQuery
function footerScript() {
    if ( !is_admin() ) {
        wp_deregister_script( 'jquery' );
 	wp_register_script( 'jquery','//libs.baidu.com/jquery/1.8.3/jquery.min.js', false,'1.0');
	wp_enqueue_script( 'jquery' );
        wp_register_script( 'default', get_template_directory_uri() . '/js/jquery.js', false, '1.0', dopt('d_jquerybom_b') ? true : false );   
        wp_enqueue_script( 'default' );   
	wp_register_style( 'style', get_template_directory_uri() . '/style.css',false,'1.0' );
	wp_enqueue_style( 'style' ); 
    }  
}  
add_action( 'wp_enqueue_scripts', 'footerScript' );

//邮件回复
function comment_mail_notify($comment_id) {
	$admin_notify = '1';
	$admin_email = get_bloginfo ('admin_email');
	$comment = get_comment($comment_id);
	$comment_author_email = trim($comment->comment_author_email);
	$parent_id = $comment->comment_parent ? $comment->comment_parent : '';
	global $wpdb;
	if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
		$wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
	if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
		$wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
	$notify = $parent_id ? '1' : '0';
	$spam_confirmed = $comment->comment_approved;
	if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
		$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
		$to = trim(get_comment($parent_id)->comment_author_email);
		$subject = '你在' . get_option("blogname") . '被关注啦~';
		$message = '
		<div id="mailtou">
			<style type="text/css">
				#mailtou{width:502px;height:auto;margin-bottom:50px;margin-left:auto;margin-right:auto;font-size:13px;line-height:14px;}
				#mailtou a{color:#299982;text-decoration:none;outline:none;}
				#mailtou .mail_head{width:502px;margin-top:10px;}
					#mailtou .mail_logo{font-size:16px;color:#373737;text-align:center;}
					#mailtou .mail_title{font-size:15px;color:#f0f7eb;padding:9px;margin-top:20px;overflow:hidden;background:#299982;padding-left:30px;padding-right:40px;}
				#mailtou .mail_main{width:420px;margin-top:30px;padding:0 40px 20px;border-left:1px dashed #299982;border-right:1px dashed #299982;color:rgba(0,0,0,0.7);background:#f9f9f9;overflow:hidden;}
					.one a{display:none}
			</style>
			<div class="mail_head">
				<div class="mail_logo">'.get_bloginfo("name").'</div>
				<div class="mail_title">你在&#8968; '. get_the_title($comment->comment_post_ID) .' &#8971;的评论有了回复：</div>
			</div>
			<div class="mail_main">
				<div class="one origin" style="border:1px solid #EEE;overflow:auto;padding:10px;margin:1em 0;"><span style="color:#299982;">'. trim(get_comment($parent_id)->comment_author) .'</span>:'. trim(get_comment($parent_id)->comment_content) .'</div>
				<div class="one reply" style="border:1px solid #EEE;overflow:auto;padding:10px;margin:1em 0 1em 60px;"><span style="color:#299982;">'. trim($comment->comment_author) .'</span>:'. trim($comment->comment_content) .'</div>
				<p style="margin-bottom:10px">点击<a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看完整内容</a></p>
				<p style="margin-bottom:10px">(此邮件由系统发出,无需回复.)</p>
			</div>
		</div>';
		$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
		$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
		wp_mail( $to, $subject, $message, $headers );
	}
}
add_action('comment_post', 'comment_mail_notify');

//分页
if ( !function_exists('pagenavi') ) { 
    function pagenavi( $p = 2 ) { // 取当前页前后各 2 页 
        if ( is_singular() ) return; // 文章与插页不用 
        global $wp_query, $paged; 
        $max_page = $wp_query->max_num_pages; 
        if ( $max_page == 1 ) return; // 只有一页不用 
        if ( empty( $paged ) ) $paged = 1; 
		echo '<span class="page-numbers page-count">' . $paged . '/' . $max_page . ' </span> '; // 显示页数
        if ( $paged > $p + 1 ) p_link( 1, '最前页', '«'); 
		if ( $paged > 1 ) p_link( $paged - 1, '上一页', '‹' );/* 如果当前页大于1就显示上一页链接 */ 
        if ( $paged > $p + 2 ) echo '... '; 
        for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { // 中间页 
            if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='page-numbers current'>{$i}</span> " : p_link( $i ); 
        } 
        if ( $paged < $max_page - $p - 1 ) echo '<span class="page-numbers">...</span>'; 
        if ( $paged < $max_page ) p_link( $paged + 1,'下一页', '›' );/* 如果当前页不是最后一页显示下一页链接 */ 
        if ( $paged < $max_page - $p ) p_link( $max_page, '最后页', '»' ); 
		} 
    function p_link( $i, $title = '', $linktype = '' ) { 
        if ( $title == '' ) $title = "第 {$i} 页"; 
        if ( $linktype == '' ) { $linktext = $i; } else { $linktext = $linktype; } 
        echo "<a class='page-numbers' href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$linktext}</a> "; 
    } 
}

//时间显示方式'xx以前'
function timeago( $ptime ) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if ($etime < 1) return '刚刚';
    $interval = array (
        12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y-m-d', $ptime).')',
        30 * 24 * 60 * 60       =>  '个月前 ('.date('m-d', $ptime).')',
        7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',
        24 * 60 * 60            =>  '天前',
        60 * 60                 =>  '小时前',
        60                      =>  '分钟前',
        1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

add_action('wp_ajax_nopriv_bigfa_like', 'bigfa_like');
add_action('wp_ajax_bigfa_like', 'bigfa_like');
function bigfa_like(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ( $action == 'ding'){
    $bigfa_raters = get_post_meta($id,'bigfa_ding',true);
    $expire = time() + 99999999;
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
    setcookie('bigfa_ding_'.$id,$id,$expire,'/',$domain,false);
    if (!$bigfa_raters || !is_numeric($bigfa_raters)) {
        update_post_meta($id, 'bigfa_ding', 1);
    } 
    else {
            update_post_meta($id, 'bigfa_ding', ($bigfa_raters + 1));
        }
   
    echo get_post_meta($id,'bigfa_ding',true);
    
    } 
    
    die;
}
//禁用Googlefont
class Disable_Google_Fonts {
        public function __construct() {
                add_filter( 'gettext_with_context', array( $this, 'disable_open_sans'             ), 888, 4 );
        }
        public function disable_open_sans( $translations, $text, $context, $domain ) {
                if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
                        $translations = 'off';
                }
                return $translations;
        }
}
$disable_google_fonts = new Disable_Google_Fonts;

//密码保护提示
function password_hint( $c ){
global $post, $user_ID, $user_identity;
if ( empty($post->post_password) )
return $c;
if ( isset($_COOKIE['wp-postpass_'.COOKIEHASH]) && stripslashes($_COOKIE['wp-postpass_'.COOKIEHASH]) == $post->post_password )
return $c;
if($hint = get_post_meta($post->ID, 'password_hint', true)){
$url = get_option('siteurl').'/wp-pass.php';
if($hint)
$hint = '密码提示：'.$hint;
else
$hint = "请输入您的密码";
if($user_ID)
$hint .= sprintf('欢迎进入，您的密码是：', $user_identity, $post->post_password);
$out = <<<END
<form method="post" action="$url">
<p>这篇文章是受保护的文章，请输入密码继续阅读：</p>
<div>
<label>$hint<br/>
<input type="password" name="post_password"/></label>
<input type="submit" value="输入密码" name="Submit"/>
</div>
</form>
END;
return $out;
}else{
return $c;
}
}
add_filter('the_content', 'password_hint');

//评论表情
add_filter('smilies_src','custom_smilies_src',1,10);
function custom_smilies_src ($img_src, $img, $siteurl){
    return get_bloginfo('template_directory').'/images/smilies/'.$img;
}
//冒充评论检验
function CheckEmailAndName(){
	global $wpdb;
	$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
	$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
	if(!$comment_author || !$comment_author_email){
		return;
	}
	$result_set = $wpdb->get_results("SELECT display_name, user_email FROM $wpdb->users WHERE display_name = '" . $comment_author . "' OR user_email = '" . $comment_author_email . "'");
	if ($result_set) {
		if ($result_set[0]->display_name == $comment_author){
			err(__('警告: 您不能使用博主的昵称！'));
		}else{
			err(__('警告: 您不能使用博主的邮箱！'));
		}
		fail($errorMessage);
	}
}

//评论列表
function commentlist($comment,$args,$depth){
	$GLOBALS['comment']=$comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment_body">
			<div class="author"><?php echo get_avatar($comment,'30'); ?></div>
			<div class="comment_data">
				<span class="name"><?php printf(__('%s'), get_comment_author_link()) ?></span>
				<span class="time"><?php echo timeago( $comment->comment_date_gmt ); ?></span>
				<div class="reply">
					<?php comment_reply_link(array_merge($args,array('reply_text' =>'回复','depth' =>$depth,'max_depth'=>$args['max_depth']))) ?>
				</div>
				<?php if($comment->comment_approved=='0'): ?>
					<em><span class="moderation"><?php _e('Your comment is awaiting moderation.') ?></span></em>
				<?php endif; ?>
				<div class="comment_text">
					<?php comment_text() ?>
				</div>
				
			</div>
		</div>
<?php 
}

function AjaxCommentsPage(){
	if( isset($_GET['action'])&& $_GET['action'] == 'AjaxCommentsPage'  ){
		global $post,$wp_query, $wp_rewrite;
		$postid = isset($_GET['post']) ? $_GET['post'] : null;
		$pageid = isset($_GET['page']) ? $_GET['page'] : null;
		if(!$postid || !$pageid){
			fail(__('Error post id or comment page id.'));
		}
		// get comments
		$comments = get_comments('post_id='.$postid);
		$post = get_post($postid);
		if(!$comments){
			fail(__('Error! can\'t find the comments'));
		}
		//if( 'desc' != get_option('comment_order') ){
		//	$comments = array_reverse($comments);
		//}
		$comments = array_reverse($comments);//?有点不明白
		// set as singular (is_single || is_page || is_attachment)
		$wp_query->is_singular = true;
		// base url of page links
		$baseLink = '';
		if ($wp_rewrite->using_permalinks()) {
			$baseLink = '&base=' . user_trailingslashit(get_permalink($postid) . 'comment-page-%#%', 'commentpaged');
		}
		// response 注意修改callback为你自己的，没有就去掉callback
		wp_list_comments('callback=commentlist&type=comment&page=' . $pageid . '&per_page=' . get_option('comments_per_page'), $comments);
		echo '<!--winysky-AJAX-COMMENT-PAGE-->';
		echo '<span id="cp_post_id" style="display:none;">
			'.$post->ID.'
		</span>';
		paginate_comments_links('current=' . $pageid . $baseLink);
		die;
	}
}
add_action('init', 'AjaxCommentsPage');
?>
