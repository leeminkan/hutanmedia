<?php 
if( !function_exists('MalinaGetPostViews')){
	function MalinaGetPostViews($postID){
	    $count_key = 'post_views_count';
	    $count = get_post_meta($postID, $count_key, true);
	    if($count==''){
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	        return "0 ".esc_html__('View', 'malina-elements');
	    } elseif($count == '1'){
	    	return "1 ".esc_html__('View', 'malina-elements');
	    } else {
	    	return $count.' '.esc_html__('Views', 'malina-elements');
	    }
	}
}
function malina_get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
if( !function_exists('MalinaSetPostViews')){
	function MalinaSetPostViews($postID) {
	    $count_key = 'post_views_count';

	    $ip = malina_get_client_ip();

		$meta_IP = array();
		$viewed_IP = '';
		$meta_IP = get_post_meta($postID, "viewed_IP");
		
		if(isset($meta_IP[0])) {
			$viewed_IP = $meta_IP[0];
		}
		if(!is_array($viewed_IP)){
			$viewed_IP = array();
		}

	    $count = get_post_meta($postID, $count_key, true);
	    if(!MalinaHasAlreadyView($postID) || !$count){
	    	$viewed_IP[$ip] = time();
			update_post_meta($postID, "viewed_IP", $viewed_IP);
	    	if($count==''){
		        $count = 1;
		        delete_post_meta($postID, $count_key);
		        add_post_meta($postID, $count_key, '1');
		    } else {
		        $count++;
		        update_post_meta($postID, $count_key, $count);
		    }
		}
	}
}
function MalinaHasAlreadyView($postID)
{	
	$ip = malina_get_client_ip();
	if( $ip == 'UNKNOWN' ){
    	return false;
    }
	$meta_IP = array();
	$meta_IP = get_post_meta($postID, "viewed_IP");

	if(isset($meta_IP[0])) {
		$viewed_IP = $meta_IP[0];
	} else {
		$viewed_IP = '';
	}

	if(!is_array($viewed_IP)){
		$viewed_IP = array();
		$time = time();
	} else {
		if(isset($viewed_IP[$ip]) ){
			$time = $viewed_IP[$ip];
		} else {
			$time = time();
		}
	}		

	$time_diff = time() - $time;
	$crt_time = 86400;

	if(array_key_exists($ip, $viewed_IP) && $time_diff <= $crt_time ){
		return true;
	}
	return false;
} 
// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
?>