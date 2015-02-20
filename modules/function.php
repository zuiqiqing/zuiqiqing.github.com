<?php
/**
 * post views
 *
 * 浏览量统计
 *
 * @since gm_record 1.0.0
 *
 * @return views.
 */

function guimeng_set_post_views($postID) {
    $the_ID = "arc".$postID;
    if(isset($_SESSION[$the_ID]) || $_SESSION[$the_ID] == 1)
    return;
    $_SESSION[$the_ID] = 1;
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
    }else{
        //administrator的浏览量不统计
        if(!current_user_can("administrator")){
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
}
function guimeng_get_post_views($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

//评论可见
function reply($content){  
    if (preg_match_all('/<!--reply start-->([\s\S]*?)<!--reply end-->/i', $content, $hide_words)){  
    $stats = 'hide';  
    global $current_user;  
    get_currentuserinfo();  
 
    if ($current_user->ID) {  
        $email = $current_user->user_email;  
    } else if (isset($_COOKIE['comment_author_email_'.COOKIEHASH])) {  
        $email = $_COOKIE['comment_author_email_'.COOKIEHASH];  
    }  
 
    $ereg = "^[_\.a-z0-9]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,5}$";  
    if (eregi($ereg, $email)) {  
        global $wpdb;  
        global $id;  
        $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_author_email = '".$email."' and comment_post_id='".$id."'and comment_approved = '1'");  
        if ($comments) {  
            $stats = 'show';  
        }  
    }  
 
    $admin_email = ""; //博主Email,博主直接查看  
    if ($email == $admin_email) {  
        $stats = 'show';  
        }  
 
        $hide_notice = '<div style="text-align:center;border:1px dashed #FF9A9A;padding:8px;margin:10px auto;color:#FF6666;">温馨提示：此处内容需要<a href="'. get_permalink().'#respond" title="评论本文">评论本文</a>后，<a href="javascript:window.location.reload();" title="刷新">刷新本页</a>才能查看。</div>';  
        if( $stats == 'show' ){  
            $content = str_replace($hide_words[0], $hide_words[1], $content);  
        }else{  
            $content = str_replace($hide_words[0], $hide_notice, $content);  
        }  
    }  
    return $content;  
}  
add_filter('the_content', 'reply'); 

//音乐播放器短代码
function mp3player($atts, $content=null){   
extract(shortcode_atts(array("auto"=>'0'),$atts));  //改为1设置默认自动播放,0不自动播放   
return '<div id="jp_container" class="jp-audio"><span rel="'.$content.'" class="play-switch play" title="play"></span><span class="play-switch stop" title="stop"></span><span rel=" '.$auto.' " class="auto"></span><div class="seek-bar"><div class="play-bar"></div></div><span class="current-time">00:00</span></div>';   
}   
add_shortcode('mp3','mp3player');  //mp3可以改成你想设置的其他短代码,只要不冲突即可  

function myplayer($atts, $content=null){   
extract(shortcode_atts(array("auto"=>'0'),$atts));  //改为1设置默认自动播放,0不自动播放   
return '<div id="jp_container" class="jp-audio"><span rel="'.$content.'" class="play-switch play" title="play"></span><span class="play-switch stop" title="stop"></span><span rel=" '.$auto.' " class="auto"></span><div class="seek-bar"><div class="play-bar"></div></div><span class="current-time">00:00</span></div>';   
}   
add_shortcode('music','myplayer');

//下载按钮
function download($atts, $content=null) {
	extract(shortcode_atts(array("title" => ''), $atts));
	$output = '<div class="download"><button class="anniu"><i class="xiazai"></i>'.$content.'</button></div>'; 
	return $output;
}
add_shortcode('d','download');

//按钮
function anniu($atts, $content=null) {
	extract(shortcode_atts(array("title" => ''), $atts));
	$output = '<div class="banniu"><button class="anniu">'.$content.'</button></div>'; 
	return $output;
}
add_shortcode('an','anniu');
function appthemes_add_quicktags() {
?>
<script type="text/javascript"> 
//快捷输入一个hr横线，点一下即可 QTags.addButton( 'h3', 'h3', '\n<h3>', '</h3>\n' ); //快捷输入h3标签 QTags.addButton( '[php]', '[php]', '\n[php]', '[/php]\n' ); //快捷输入[php]标签 
QTags.addButton('音乐播放器','音乐播放器','[mp3][/mp3]','','');
QTags.addButton('下载按钮','下载按钮','[d][/d]','','');
QTags.addButton('普通按钮','普通按钮','[an][/an]','','');
QTags.addButton('回复可见','回复可见','<!--reply start--><!--reply end-->','','');
</script>
<?php
}
add_action('admin_print_footer_scripts', 'appthemes_add_quicktags' ); 
?>
<?php
if ( !function_exists('wp_new_user_notification') ) {
    function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
        $user = new WP_User($user_id);
        //获取用户名和邮箱
        $user_login = stripslashes($user->user_login);
        $user_email = stripslashes($user->user_email);
        //获取管理员邮箱和博客名称
        $admin_email = stripslashes(get_option('admin_email'));
        $blog_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        //自定义管理员邮件
        $headers = 'From: '.$blog_name.' <'.$admin_email.'>';
        $headers .= 'MIME-Version: 1.0';
        $headers .= 'Content-type: text/html; charset=uft-8';
        $headers .= 'Content-Transfer-Encoding: 8bit';
 
        $message = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body><div>';
        $message .= '<p>'.sprintf(__('你的网站[%s] 有新用户注册:'), $blog_name ) . '</p>';
        $message .= '<p>'.sprintf(__('Username: %s'), $user_login) . '</p>';
        $message .= '<p>'.sprintf(__('E-mail: %s'), $user_email) . '</p></div></body></html>';
 
        @wp_mail($admin_email, sprintf(__('[%s] New User Registration'), $blog_name), $message, $headers);
        //判断新用户密码是否为空
        if ( empty($plaintext_pass) )
            return;
        //自定义新用户欢迎邮件
        $headers = 'From: '.$blog_name.' <'.$admin_email.'>';
        $headers .= 'MIME-Version: 1.0';
        $headers .= 'Content-type: text/html; charset=uft-8';
        $headers .= 'Content-Transfer-Encoding: 8bit';
 
        $message = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body><div>';
        $message .= '<p>'.__('亲爱的：') .$user_login. '</p>';
        $message .= '<p>恭喜您今天正式成为教室的一员，我们已经展开热情的怀抱欢迎你。</p>';
        $message .= '<p>您的账号信息如下：</p>';
        $message .= '<p>'.sprintf(__('Username: %s'), $user_login) . '</p>';
        $message .= '<p>'.sprintf(__('Password: %s'), $plaintext_pass) . '</p>';
        $message .= '<p>请妥善保存好自己的账户信息，如果您忘记密码，可以通过登录窗口的密码找回功能找回密码。</p>';
        $message .= '</div></body></html>';
 
        @wp_mail($user_email, sprintf(__('[%s] Your username and password'), $blog_name), $message , $headers);
 
    }
    //让邮件支持html
    add_filter( 'wp_mail_content_type', 'wpdx_set_html_content_type' );
    function wpdx_set_html_content_type() {
        return 'text/html';
    }
}
?>