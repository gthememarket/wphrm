<?php
/*
Plugin Name: WP HRM
Plugin URI: http://www.mobilewebs.net/mojoomla/extend/wordpress/wphrm/
Description: WP HRM System for wordpress plugin is ideal way to manage complete Human Resource operation. It has different user roles like HR manager, Employee, Accountant and Admin users. 
Version: 7.0
Author: Mojoomla
Author URI: http://codecanyon.net/user/dasinfomedia
Text Domain: hr_mgt
Domain Path: /languages/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Copyright 2015  Mojoomla  (email : sales@mojoomla.com)
*/
?>
<?php 

define( 'HRMS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'HRMS_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'HRMS_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );
define( 'HRMS_CONTENT_URL',  content_url( ));

require_once HRMS_PLUGIN_DIR . '/settings.php';
require_once HRMS_PLUGIN_DIR . '/api/hrmgt-api.php';

add_action( 'bl_cron_hook', 'bl_cron_exec');
if( !wp_next_scheduled( 'bl_cron_hook' ) ) {
   wp_schedule_event( time(), 'daily', 'bl_cron_hook' );
}

function bl_cron_exec() 
{
	return $users = get_users(array(
		'meta_key'     => 'birth_date',		 
		'meta_value'   =>date('m/d'),
		'meta_compare' => 'LIKE',
	));
}
 require_once  ABSPATH .'wp-load.php';
$userdata = bl_cron_exec();
if(!empty($userdata))
{	
	foreach($userdata as $user)
	{			
		$useremail= $user->user_email;				
		$subject = "Happy Birthday";
		$image = HRMS_PLUGIN_URL."/assets/images/birthday.gif";
		$username =$user->display_name;		
		$messege = "<p><img src='$image'> <br> Hello <strong>$username</strong>\r\n  Wishing  you the beauty of the perfect day.\r\n the laughter of a happy heart the joy of being with people you love\r\n\r\n
				</p><h1>Happy Bithday!</h1>";
		$headers="";
		$headers .= 'From: Hr Dasinfomedia <hr@dasinfomedia.com>' . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";		
	}
}
?>