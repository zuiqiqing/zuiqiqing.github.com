<?php
 
/**
 * 继承WP_Widget_Recent_Comments
 * 这样就只需要重写widget方法就可以了
 */
class My_Widget_Recent_Comments extends WP_Widget_Recent_Comments {
 
    /**
     * 构造方法，主要是定义小工具的名称，介绍
     */
    function My_Widget_Recent_Comments() {
        $widget_ops = array('classname' => 'f_comment', 'description' => __('显示网友最新评论（头像+名称+评论）'));
        $this->WP_Widget('my-recent-comments', __('f-最新评论', 'f-最新评论'), $widget_ops);
    }
 
    /**
     * 小工具的渲染方法，这里就是输出评论
     */
    function widget($args, $instance) {
        global $wpdb, $comments, $comment;
 
        $cache = wp_cache_get('f_comment', 'widget');
 
        if (!is_array($cache))
            $cache = array();
 
        if (!isset($args['widget_id']))
            $args['widget_id'] = $this->id;
 
        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }
 
        extract($args, EXTR_SKIP);
        $output = '';
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Comments') : $instance['title'], $instance, $this->id_base);
        if (empty($instance['number']) || !$number = absint($instance['number']))
            $number = 5;
        //获取评论，过滤掉管理员自己
        $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE user_id !=1 and comment_approved = '1' and comment_type not in ('pingback','trackback') ORDER BY comment_date_gmt DESC LIMIT $number");
        $output .= $before_widget;
        if ($title)
            $output .= $before_title . $title . $after_title;
 
        $output .= '<div class="all-comments">';
        if ($comments) {
            // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
            $post_ids = array_unique(wp_list_pluck($comments, 'comment_post_ID'));
            _prime_post_caches($post_ids, strpos(get_option('permalink_structure'), '%category%'), false);
 
            foreach ((array) $comments as $comment) {
			  if ($comment->comment_author_email != $my_email) {
                //头像
                $avatar = get_avatar($comment, 36);
                //作者名称
                $author = get_comment_author();
                //评论内容
                $content = apply_filters('get_comment_text', $comment->comment_content);
                $content = mb_strimwidth(strip_tags($content), 0, '65', '...', 'UTF-8');
                $content = convert_smilies($content);
                //评论的文章
                $post = '<a href="' . esc_url(get_comment_link($comment->comment_ID)) . '">'  . $avatar . $author .'<span class="muted">'.timeago( $comment->comment_date_gmt ).':<br>' . $content . '</span></a>';
 
                //这里就是输出的html，可以根据需要自行修改
                $output .= $post;
			  }
            }
        }
        $output .= '</div>';
        $output .= $after_widget;
 
        echo $output;
        $cache[$args['widget_id']] = $output;
        wp_cache_set('my_widget_recent_comments', $cache, 'widget');
    }
 
}
 
//注册小工具
register_widget('My_Widget_Recent_Comments');