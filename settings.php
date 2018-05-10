<?php 
require_once HRMS_PLUGIN_DIR. '/hrmgt-function.php';
require_once HRMS_PLUGIN_DIR. '/hrmgt-ajax-function.php';
require_once HRMS_PLUGIN_DIR. '/class/department.php';
require_once HRMS_PLUGIN_DIR. '/class/employee.php';
require_once HRMS_PLUGIN_DIR. '/class/attendance_details.php';
require_once HRMS_PLUGIN_DIR. '/class/attendance.php';
require_once HRMS_PLUGIN_DIR. '/class/leave.php';
require_once HRMS_PLUGIN_DIR. '/class/holiday.php';
require_once HRMS_PLUGIN_DIR. '/class/office-management.php';
require_once HRMS_PLUGIN_DIR. '/class/company-policy.php';
require_once HRMS_PLUGIN_DIR. '/class/training.php';
require_once HRMS_PLUGIN_DIR. '/class/parfomance-marks.php';
require_once HRMS_PLUGIN_DIR. '/class/file.php';
require_once HRMS_PLUGIN_DIR. '/class/travel.php';
require_once HRMS_PLUGIN_DIR. '/class/compansation.php';
require_once HRMS_PLUGIN_DIR. '/class/project.php';	
require_once HRMS_PLUGIN_DIR. '/class/requirements.php';	
require_once HRMS_PLUGIN_DIR. '/class/suggestion.php';	
require_once HRMS_PLUGIN_DIR. '/class/message.php';	
require_once HRMS_PLUGIN_DIR. '/class/payslip.php';
require_once HRMS_PLUGIN_DIR. '/class/skill_metrix.php';
require_once HRMS_PLUGIN_DIR. '/class/hrmgt_message.php';
require_once HRMS_PLUGIN_DIR. '/class/client_feedback.php';
require_once HRMS_PLUGIN_DIR. '/class/pl_management.php';

add_action( 'admin_head', 'amgt_admin_css' );

function amgt_admin_css(){
?>
<style>
a.toplevel_page_hrmgt-hr_system:hover,  a.toplevel_page_hrmgt-hr_system:focus,.toplevel_page_hrmgt-hr_system.opensub a.wp-has-submenu{
  background: url("<?php echo HRMS_PLUGIN_URL;?>/assets/images/hr-managemt-2.png") no-repeat scroll 8px 9px rgba(0, 0, 0, 0) !important;
  
}
.toplevel_page_hrmgt-hr_system:hover .wp-menu-image.dashicons-before img {
  display: none;
}
.toplevel_page_hrmgt-hr_system:hover .wp-menu-image.dashicons-before {
  min-width: 23px !important;
}
</style>
<?php
}

add_action('init', 'hrmgt_session_manager'); 
function hrmgt_session_manager()
{
	if (!session_id()) 
	{
		session_start();		
		if(!isset($_SESSION['hrmgt_verify']))
		{			
			$_SESSION['hrmgt_verify'] = '';
		}		
	}	
}

function hrmgt_logout()
{
	if(isset($_SESSION['hrmgt_verify']))
	{
		unset($_SESSION['hrmgt_verify']);
	}   
}

add_action('wp_logout','hrmgt_logout');
add_action('init','hrmgt_setup');

function hrmgt_setup()
{
	$is_hrmgt_pluginpage = hrmgt_is_cmgtpage();
	$is_verify	=	false;
	if(!isset($_SESSION['hrmgt_verify']))
		$_SESSION['hrmgt_verify'] 	= 	'';
	$server_name 	= 	$_SERVER['SERVER_NAME'];
	$is_localserver = hrmgt_chekserver($server_name);
	
	if($is_localserver)
	{		
		return true;
	}
	
	if($is_hrmgt_pluginpage)
	{	
		if($_SESSION['hrmgt_verify'] == '')
		{		
			if( get_option('licence_key') && get_option('hrmgt_setup_email'))
			{				
				$domain_name 	= 	$_SERVER['SERVER_NAME'];
				$licence_key 	= 	get_option('licence_key');
				$email 			= 	get_option('hrmgt_setup_email');
				$result 		= 	hrmgt_check_productkey($domain_name,$licence_key,$email);
				$is_server_running 	= 	hrmgt_check_ourserver();
				if($is_server_running)
					$_SESSION['hrmgt_verify'] 	=	$result;
				else
					$_SESSION['cmgt_verify'] 	= 	'0';
					$is_verify 	= 	hrmgt_check_verify_or_not($result);
			
			}
		}
	}
	$is_verify = hrmgt_check_verify_or_not($_SESSION['hrmgt_verify']);	
	if($is_hrmgt_pluginpage)
		if(!$is_verify)
		{
			$_SESSION['hrmgt_verify'] = '';
			if($_REQUEST['page'] != 'hrmgt-setup')
				wp_redirect(admin_url().'admin.php?page=hrmgt-setup');			
		}	
}
	
if ( is_admin() ){
	require_once HRMS_PLUGIN_DIR. '/admin/admin.php';
	function hrm_install()
	{
		add_role('manager', __( 'Manager' ,'hr_mgt'),array( 'read' => true, 'level_1' => true ));
		add_role('employee', __( 'Employee' ,'hr_mgt'),array( 'read' => true, 'level_0' => true ));
		add_role('accountant', __( 'Accountant' ,'hr_mgt'),array( 'read' => true, 'level_1' => true ));
		
		hrmgt_install_tables();			
	}
	register_activation_hook(HRMS_PLUGIN_BASENAME, 'hrm_install' );

	
	
	function hrmgt_option(){
		$options=array("hrmgt_system_name"=> __( 'WP HRM - Human Resource Management System' ,'hr_mgt'),
			"hrmgt_staring_year"=>"2016",
			"hrmgt_office_address"=>"Near cross road-5",
			"hrmgt_contact_number"=>"000-800-100-3777 ",
			"hrmgt_contry"=>"United States",
			"hrmgt_email"=>get_option('admin_email'),
			"hrmgt_system_logo"=>HRMS_PLUGIN_URL.'/assets/images/Thumbnail-img.png',
			"hrmgt_system_background_image"=>HRMS_PLUGIN_URL.'/assets/images/church-background.png',
			"hrmgt_user_thumb"=>HRMS_PLUGIN_URL.'/assets/images/Thumbnail-img.png',			
			'half_working_hour'=>'08:10',
			'full_working_hour'=>'08:40',				
			'add_leave_emails'=>'',				
			'leave_approveemails'=>'',				
			'earning'=>'',				
			//'profile_picture_exetesion'=>'png,jpg',				
			'deduction'=>'',				
			'event_emails'=>'',				
			'registration_emails'=>'',				
			'traning_emails'=>'',				
			"hrmgt_exprience_latter_heading"=>'Employee Experience Certificate',
			"hrmgt_exprience_latter_subject"=>"Experience for an employee",
			"hrmgt_exprience_latter_to"=>'This certificate Presented To <br> <br> {{employee_name}}',
			"hrmgt_exprience_latter_content"=>'For the experience he/she join our organization. As the head of department in {{system_name}}. I hereby testify that this employee has worked in our company from {{join_date}}  to {{leave_date}} and has joined experience in the {{department_name}} 
			It was great working with {{employee_name}} for his/her employment duration and he/she provided himself as one of the most important assets of the organization. we wish him/her a good life and better opportunities of the employment.',
			
			'add_leave_subject'=>'Request For Leave',
			'leave_approve_subject'=>'Your Leave Approved',					
			'event_subject'=>'Event Notification',
			'registration_subject'=>'Employee Registration Success',
			'traning_subject'=>'Subect for Training',					
			'addleave_email_template'=>'Hello,
			
			You have a new leave request from {{employee_name}}.Details are as below.
			
			Date : {{start_date}}  To  {{end_date}}

			Leave Type :{{leave_type}}

Leave Duration :{{leave_duration}}

Reason :{{reason}}

Thank you
{{employee_name}}',
							
			'leave_approve_email_template'=>'Hello,
			
Leave of {{user_name}} is successfully approved.

Date     :  {{date}}

Comment  : {{comment}} 

Thank you
{{system_name}}',

			'event_email_template'=>'Hello Team ,

Event Notification

Event Start Date : {{event_start_date}}

Event End Date : {{event_end_date}}

Event Place:{{event_place}}

Thank you
{{system_name}}.',

		'registration_email_template'=>'Hello,
		
Registration is completed

User Name :  {{username}}

Password  : {{password}}

Email     :  {{email}}

Thank you
{{system_name}}',

		'traning_email_template'=>'Hello ,
you have been assigned  to the  {{training_subject}}  training course  

Training type:            {{training_type}}

Trainer Name :         {{traininer_name}}, 

Training Location  :   {{training_location}}, 

Training Start date  : {{traininig_start_date}}

Description :          {{description}}

the target date for you to  complete this training  is  {{traininig_end_date}}

Thank you
{{system_name}}'


);
	return $options;
}
	add_action('admin_init','hrmgt_general_setting');	
	function hrmgt_general_setting()
	{
		$options=hrmgt_option();
		foreach($options as $key=>$val)
		{
			add_option($key,$val);			
		}
	}
	

	
	function hrmgt_change_adminbar_css($hook)
	{	
		$current_page = $_REQUEST['page'];	
		$pos = strrpos($current_page, "hrmgt-");
		if($pos !== false)			
		{
			$lancode=get_locale();			
			$code=substr($lancode,0,2);
			wp_register_script( 'jquery-1.8.2', plugins_url( '/assets/js/jquery-1.11.1.min.js', __FILE__), array( 'jquery' ) );
			wp_enqueue_script( 'jquery-1.8.2' );		
			
			wp_enqueue_style( 'accordian-jquery-ui-css', plugins_url( '/assets/css/jquery-ui.css', __FILE__) );
			wp_enqueue_script('accordian-jquery-ui', plugins_url( '/assets/js/jquery-ui.js',__FILE__ ));
			wp_enqueue_style( 'hrmgt-calender-css', plugins_url( '/assets/css/fullcalendar.css', __FILE__) );
			wp_enqueue_style( 'hrmgt-datatable-css', plugins_url( '/assets/css/dataTables.css', __FILE__) );
			wp_enqueue_style( 'jquery.rateyo', plugins_url( '/assets/css/jquery.rateyo.css', __FILE__) );
			wp_enqueue_style( 'hrmgt-datatable-select-css', plugins_url( '/assets/css/select.dataTables.min.css', __FILE__) );
			wp_enqueue_style( 'triview', plugins_url( '/assets/css/triview.css', __FILE__) );			
			wp_enqueue_style( 'hrmgt-style-css', plugins_url( '/assets/css/style.css', __FILE__) );
			wp_enqueue_style( 'hrmgt-popup-css', plugins_url( '/assets/css/popup.css', __FILE__) );
			wp_enqueue_style( 'hrmgt-custom-css', plugins_url( '/assets/css/custom.css', __FILE__) );
			
			wp_enqueue_script('hrmgt-calender_moment', plugins_url( '/assets/js/moment.min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
			wp_enqueue_script('hrmgt-calender', plugins_url( '/assets/js/fullcalendar.min.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
			wp_enqueue_script('hrmgt-datatable', plugins_url( '/assets/js/jquery.dataTables.min.js',__FILE__ ), array( 'jquery' ), '4.1.1', true);
			wp_enqueue_script('hrmgt-datatable-tools', plugins_url( '/assets/js/dataTables.tableTools.min.js',__FILE__ ), array( 'jquery' ), '4.1.1', true);
			wp_enqueue_script('hrmgt-datatable-editor', plugins_url( '/assets/js/dataTables.editor.min.js',__FILE__ ), array( 'jquery' ), '4.1.1', true);	
			wp_enqueue_script('hrmgt-multi-select-validation', plugins_url( '/assets/js/multi-select-validation.js',__FILE__ ), array( 'jquery' ), '4.1.1', true);	
			
			wp_enqueue_script('hrmgt-customjs', plugins_url( '/assets/js/hrmgt_custom.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
			wp_enqueue_script('hrmgt-popup', plugins_url( '/assets/js/popup.js', __FILE__ ), array( 'jquery' ), '4.1.1', false );
			wp_localize_script( 'hrmgt-popup', 'hrmgt  ', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );
			wp_enqueue_script('jquery');
			wp_enqueue_media();
		    wp_enqueue_script('thickbox');
		    wp_enqueue_style('thickbox');
			
			wp_enqueue_script('hrmgt-image-upload', plugins_url( '/assets/js/image-upload.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );			 
			wp_enqueue_script('hrmgt-dataTables-responsive', plugins_url( '/assets/js/dataTables.responsive.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );			 
			wp_enqueue_style( 'hrmgt-bootstrap-css', plugins_url( '/assets/css/bootstrap.min.css', __FILE__) );
			wp_enqueue_style( 'hrmgt-bootstrap-multiselect-css', plugins_url( '/assets/css/bootstrap-multiselect.css', __FILE__) );
			wp_enqueue_style( 'hrmgt-bootstrap-timepicker-css', plugins_url( '/assets/css/bootstrap-timepicker.min.css', __FILE__) );
		 	wp_enqueue_style( 'hrmgt-font-awesome-css', plugins_url( '/assets/css/font-awesome.min.css', __FILE__) );
		 	wp_enqueue_style( 'hrmgt-white-css', plugins_url( '/assets/css/white.css', __FILE__) );
		 	wp_enqueue_style( 'hrmgt-open-sans','https://fonts.googleapis.com/css?family=Open+Sans');
		 	wp_enqueue_style( 'hrmgt-gymmgt-min-css', plugins_url( '/assets/css/hrmgt.min.css', __FILE__) );
			if (is_rtl())
			{
				wp_enqueue_style( 'hrmgt-bootstrap-rtl-css', plugins_url( '/assets/css/bootstrap-rtl.min.css', __FILE__) );
			}
			wp_enqueue_style( 'hrmgt-gym-responsive-css', plugins_url( '/assets/css/hr-responsive.css', __FILE__) );
			 
			wp_enqueue_script('hrmgt-calender-es', plugins_url( '/assets/js/calendar-lang/'.$code.'.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
			
			wp_enqueue_script('hrmgt-bootstrap-js', plugins_url( '/assets/js/bootstrap.min.js', __FILE__ ) );
			wp_enqueue_script('hrmgt-bootstrap-multiselect-js', plugins_url( '/assets/js/bootstrap-multiselect.js', __FILE__ ) );
			wp_enqueue_script('hrmgt-bootstrap-timepicker-js', plugins_url( '/assets/js/bootstrap-timepicker.min.js', __FILE__ ) );
			wp_enqueue_script('hrmgt-timeago-js', plugins_url( '/assets/js/jquery.timeago.js', __FILE__ ) );
			 		
			wp_enqueue_style( 'wcwm-validate-css', plugins_url( '/lib/validationEngine/css/validationEngine.jquery.css', __FILE__) );	 	
			wp_register_script( 'jquery-validationEngine-'.$code.'', plugins_url( '/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js', __FILE__), array( 'jquery' ) );
			wp_enqueue_script( 'jquery-validationEngine-'.$code .'' );
			wp_register_script( 'jquery-validationEngine', plugins_url( '/lib/validationEngine/js/jquery.validationEngine.js', __FILE__), array( 'jquery' ) );
			wp_enqueue_script( 'jquery-validationEngine' );
				
			wp_register_script( 'jquery.rateyo', plugins_url( '/assets/js/jquery.rateyo.js', __FILE__), array( 'jquery' ) );
			wp_enqueue_script( 'jquery.rateyo' );	
		}
		
	}
	if(isset($_REQUEST['page']))
		add_action( 'admin_enqueue_scripts', 'hrmgt_change_adminbar_css' );
		
}
add_action( 'admin_bar_menu', 'smgt_school_dashboard_link', 999 );

function smgt_school_dashboard_link( $wp_admin_bar )
{
	$args = array(
		'id'    => 'wphrm-dashboard',
		'title' => __('Wphrm Dashboard','hr_mgt'),
		'href'  => home_url().'?hr-dashboard=user',
		'meta'  => array( 'class' => 'hrmgt-school-dashboard' )
	);
	$wp_admin_bar->add_node( $args );
}

function hrmgt_install_login_page()
{ 
	if ( !get_option('hrmgt_login_page') ) 
	{
		$curr_page = array(
			'post_title' => __('WP HRM Login Page', 'hr_mgt'),
			'post_content' => '[hrmgt_login]',
			'post_status' => 'publish',
			'post_type' => 'page',
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_category' => array(1),
			'post_parent' => 0 );		
		$curr_created = wp_insert_post( $curr_page );
		update_option( 'hrmgt_login_page', $curr_created );
	}
}

function hrmgt_login_form()
{  ?>
<!--<table>
	<tbody>
		<tr style="background-color: aliceblue;">
			<th>USER ROLE</th>
			<th>USER NAME</th>
			<th>PASSWORD</th>
		</tr>
		<tr>
			<th>HR Manager</th>
			<td>hrmanager</td>
			<td>hrmanager</td>
		</tr>
		<tr>
			<th>Accountant</th>
			<td>accountant</td>
			<td>accountant</td>
		</tr>
		<tr>
			<th>Employee</th>
			<td>employee</td>
			<td>employee</td>
		</tr>
	</tbody>
</table>-->
<?php 
	$args = array( 'redirect' => site_url() );	
	if(isset($_GET['login']) && $_GET['login'] == 'failed')
	{
		?>
		<div id="login-error" style="background-color: #FFEBE8;border:1px solid #C00;padding:5px;">
		  <p><?php _e('Login failed: You have entered an incorrect Username or password, please try again.','hr_mgt');?></p>
		</div>
		<?php
	}
	global $reg_errors;
	$reg_errors = new WP_Error;
		if ( is_wp_error( $reg_errors ) )
		{ 
			foreach ( $reg_errors->get_error_messages() as $error ) 
			{			 
				echo '<div>';
					echo '<strong>'.__('ERROR','hr_mgt').'</strong>:';
					echo $error . '<br/>';
				echo '</div>';				 
			}
		}
		
	 $args = array(
		'echo' => true,
		'redirect' => site_url( $_SERVER['REQUEST_URI'] ),
		'form_id' => 'loginform',
		'label_username' => __( 'Username' , 'hr_mgt'),
		'label_password' => __( 'Password', 'hr_mgt' ),
		'label_remember' => __( 'Remember Me' , 'hr_mgt'),
		'label_log_in' => __( 'Log In' , 'hr_mgt'),
		'id_username' => 'user_login',
		'id_password' => 'user_pass',
		'id_remember' => 'rememberme',
		'id_submit' => 'wp-submit',
		'remember' => 0,
		'value_username' => NULL,
	    'value_remember' => false ); 
	 $args = array('redirect' => site_url('/?hr-dashboard=user') );
	 
if ( is_user_logged_in() )
{ ?>
<a href="<?php echo home_url('/')."?hr-dashboard=user"; ?>"><?php _e('Dashboard','hr_mgt');?></a>
<br /><a href="<?php echo wp_logout_url(); ?>"><?php _e('Logout','hr_mgt');?></a> 
<?php }
	 else 
	 {
		wp_login_form( $args );
		 echo '<a href="'.wp_lostpassword_url().'" title="Lost Password">'.__('Forgot your password?','hr_mgt').'</a> ';
	 }
}
function hrmgt_user_dashboard()
{	
	if(isset($_REQUEST['hr-dashboard']))
	{		
		require_once HRMS_PLUGIN_DIR. '/fronted_template.php';
		exit;
	}	
}
function hrmgt_remove_all_theme_styles() {
	global $wp_styles;
	$wp_styles->queue = array();
}
if(isset($_REQUEST['hr-dashboard']) && $_REQUEST['hr-dashboard'] == 'user')
{
	add_action('wp_print_styles', 'hrmgt_remove_all_theme_styles', 100);
}
function hrmgt_load_script1()
{
	if(isset($_REQUEST['hr-dashboard']) && $_REQUEST['hr-dashboard'] == 'user')
	{	
		wp_register_script('hrmgt-popup-front', plugins_url( 'assets/js/popup.js', __FILE__ ), array( 'jquery' ));
		wp_enqueue_script('hrmgt-popup-front');		
		wp_localize_script( 'hrmgt-popup-front', 'hrmgt', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script('jquery');	
	}
}

function hrmgt_domain_load()
{
	load_plugin_textdomain( 'hr_mgt', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );	
}

add_action( 'plugins_loaded', 'hrmgt_domain_load' );
add_action('init','hrmgt_install_login_page');
add_shortcode( 'hrmgt_login','hrmgt_login_form' );
add_action('wp_head','hrmgt_user_dashboard');
add_action('wp_enqueue_scripts','hrmgt_load_script1');
add_action('init','hrmgt_output_ob_start');

function hrmgt_output_ob_start()
{
	ob_start();
}

function requirement_auto_close()
{
	global $wpdb;
	$table_name =$wpdb->prefix . "hrmgt_posted_job";
	$date = date("m/d/Y");	
	$result = $wpdb->get_results("select * from $table_name where  closing_date='$date'");
	foreach($result as $key=>$val)
	{		
		$requirement_data['status']="0";
		$wpdb->update($table_name,$requirement_data,array('id'=>$val->id));
	}	
}

add_action('init','requirement_auto_close');
function hrmgt_menu()
{
	$user_menu = array();
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/department.png' ),'menu_title'=>__( 'Department', 'hr_mgt' ),'employee'=>1,'page_link'=>'department');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/user.png' ),'menu_title'=>__( 'All User', 'hr_mgt' ),'employee'=>1,'page_link'=>'user');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/Attendance.png' ),'menu_title'=>__( 'Attendance', 'hr_mgt' ),'employee'=>1,'page_link'=>'attendance');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/pl.png' ),'menu_title'=>__( 'Paid Leave', 'hr_mgt' ),'employee'=>1,'page_link'=>'pl');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/leave.png' ),'menu_title'=>__( 'Leave', 'hr_mgt' ),'employee'=>1,'page_link'=>'leave');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/payslip.png' ),'menu_title'=>__( 'Payslip', 'hr_mgt' ),'employee'=>1,'page_link'=>'payslip');
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/earning_deduction.png' ),'menu_title'=>__( 'Earning/Deduction', 'hr_mgt' ),'employee'=>1,'page_link'=>'earning_deduction');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/asset_benefit.png' ),'menu_title'=>__( 'Assets/Benefit', 'hr_mgt' ),'employee'=>1,'page_link'=>'asset_benefit');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/employee-training.png' ),'menu_title'=>__( 'Employee Training', 'hr_mgt' ),'employee'=>1,'page_link'=>'employee_training');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/prformance-mark.png' ),'menu_title'=>__( 'Performance Marks', 'hr_mgt' ),'employee'=>1,'page_link'=>'performance');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/projectr.png' ),'menu_title'=>__( 'Project', 'hr_mgt' ),'employee'=>1,'page_link'=>'project');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/requirement.png' ),'menu_title'=>__( 'Recruitment', 'hr_mgt' ),'employee'=>1,'page_link'=>'requirements');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/events.png' ),'menu_title'=>__( 'Event', 'hr_mgt' ),'employee'=>1,'page_link'=>'event');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/skill_metrix.png' ),'menu_title'=>__( 'Skill Metrix', 'hr_mgt' ),'employee'=>1,'page_link'=>'skill_metrix');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/travel.png' ),'menu_title'=>__( 'Travel', 'hr_mgt' ),'employee'=>1,'page_link'=>'travel');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/travel.png' ),'menu_title'=>__( 'Notice', 'hr_mgt' ),'employee'=>1,'page_link'=>'notice');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/employee_feedback.png' ),'menu_title'=>__( 'Employee Feedback', 'hr_mgt' ),'employee'=>1,'page_link'=>'employee_feedback');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/client_feedback.png' ),'menu_title'=>__( 'Client Feedback', 'hr_mgt' ),'employee'=>1,'page_link'=>'client_feedback');		
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/message.png' ),'menu_title'=>__( 'Message', 'hr_mgt' ),'employee'=>1,'page_link'=>'message');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/report.png' ),'menu_title'=>__( 'Report ', 'hr_mgt' ),'employee'=>1,'page_link'=>'report ');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/genral.png' ),'menu_title'=>__( 'General ', 'hr_mgt' ),'employee'=>1,'page_link'=>'genral ');	
	$user_menu[] = array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/mail.png' ),'menu_title'=>__( 'Mail Template ', 'hr_mgt' ),'employee'=>1,'page_link'=>'mail_template ');	
	return $user_menu;
}

add_action('init','hrmgt_frontend_menu_list');
function hrmgt_frontend_menu_list()
{
	$access_array=array(
		 'department' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/department.png'),
		  'menu_title' =>'Department',
		  'employee' =>'1',	
		  'accountant' =>'1',
		  'manager' =>'1',	
		  'page_link' =>'department'),
		 
		 'user' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/user.png'),
		  'menu_title' =>'All User',
		  'employee' =>'1',
		  'accountant' =>'1',	
		  'manager' =>'1',	
		  'page_link' =>'user'),
		
		
		  'attendance' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/attendance.png'),
		  'menu_title' =>'Attendance',
		  'employee' =>'1',	
		  'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'attendance'), 
		  
		 'leave' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/leave.png'),
		  'menu_title' =>'Leave',
		  'employee' =>'1',	
		  'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'leave'), 
		  
		  'leave' =>array(
			'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/pl.png'),
			'menu_title' =>'Paid Leave',
			'employee' =>'1',	
			'accountant'=>'1',
			'manager'=>'1',
			'page_link' =>'pl'), 
		  
		  'payslip' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/payslip.png'),
		  'menu_title' =>'Payslip',
		  'employee' =>'1',
		  'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'payslip'), 
		  
		  'earning_deduction' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/earning_deduction.png'),
		  'menu_title' =>'Earning/Deduction',
		  'employee' =>'1',
		  'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'earning_deduction'), 
		  
		  'asset_benefit' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/asset_benefit.png'),
		  'menu_title' =>'Assets/Benefit',
		  'employee' =>'1',
		  'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'asset_benefit'), 		  
		
		  
		  'employee_training' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/employee-training.png'),
		  'menu_title' =>'Employee Training',
		  'employee' =>'1',
		  'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'employee_training'),
		  
		  'performance' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/performance-mark.png'),
		  'menu_title' =>'Performance Marks',
		  'employee' =>'1',	
		  'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'performance'),

		  'requirements' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/requirements.png'),
		  'menu_title' =>'Recruitment',
		  'employee' =>'1',
		  'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'requirements'),
		  
		  

		  'event' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/events.png'),
		  'menu_title' =>'Event',
		  'employee' =>'1',
		  'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'event'),
		  
		
		  
		  'project' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/projectr.png'),
		  'menu_title' =>'Project',
		  'employee' =>'1',	
		  'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'project'),
		  
		 	  
		  'travel' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/travel.png'),
		  'menu_title' =>'Travel',
		  'employee' =>'1',	
		   'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'travel'),
		  
		  'notice' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/notice.png'),
		  'menu_title' =>'Notice',
		  'employee' =>'1',	
		   'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'notice'),
		
		  
		  'employee_feedback' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/employee_feedback.png'),
		  'menu_title' =>'Employee Feedback',
		  'employee' =>'1',
          'accountant'=>'1',
		  'manager'=>'1',		  
		  'page_link' =>'employee_feedback'),
		  
		  'client_feedback' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/client_feedback.png'),
		  'menu_title' =>'Client Feedback',
		  'employee' =>'1',
          'accountant'=>'1',
		  'manager'=>'1',		  
		  'page_link' =>'client_feedback'),
		  
		  
		  'message' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/message.png'),
		  'menu_title' =>'Message',
		  'employee' =>'1',
		   'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'message'),
		  
		 
		  
		  'report' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/report.png'),
		  'menu_title' =>'Report',
		  'employee' =>'1',
		 'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'report'),
		  
		  'skill_metrix' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/skill_metrix.png'),
		  'menu_title' =>'Skill Matrix',
		  'employee' =>'1',
		 'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'skill_metrix'),
		  
		  
		  'mail_template' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/mail.png'),
		  'menu_title' =>'Mail Template',
		  'employee' =>'1',
		  'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'mail_template'),
		  
		  
		  'genral' =>array(
		  'menu_icone' =>plugins_url( 'wphrm/assets/images/icon/genral.png'),
		  'menu_title' =>'General',
		  'employee' =>'1',
		  'accountant'=>'1',
		  'manager'=>'1',
		  'page_link' =>'genral'),		  
	);	
	
	if(!get_option('hrmgt_access_right')) 
	{		
		update_option( 'hrmgt_access_right', $access_array );
	}
}
function hrmgt_install_tables()
{
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	global $wpdb;	
		$table_hrmgt_apply_candidates = $wpdb->prefix . 'hrmgt_apply_candidates';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_apply_candidates." ( 			
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `job_id` int(11) NOT NULL,
		  `crierearea` varchar(25) NOT NULL,
		  `first_name` varchar(100) NOT NULL,
		  `middle_name` varchar(100) NOT NULL,
		  `last_name` varchar(100) NOT NULL,
		  `gender` varchar(50) NOT NULL,
		  `birth_date` varchar(20) NOT NULL,
		  `address` varchar(255) NOT NULL,
		  `city_name` varchar(100) NOT NULL,
		  `state_name` varchar(100) NOT NULL,
		  `country_name` varchar(255) NOT NULL,
		  `zip_code` varchar(50) NOT NULL,
		  `email` varchar(100) NOT NULL,
		  `mobile` varchar(20) NOT NULL,
		  `phone` varchar(20) NOT NULL,
		  `interests` text NOT NULL,
		  `achievements` text NOT NULL,
		  `notes` text NOT NULL,
		  `bio_data` varchar(255) NOT NULL,
		  `status` varchar(50) NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		$table_hrmgt_assets = $wpdb->prefix . 'hrmgt_assets';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_assets." (				  
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `employee_id` int(11) NOT NULL,
		  `asset_id` int(11) NOT NULL,
		  `assign_date` varchar(20) NOT NULL,
		  `return_date` varchar(20) NOT NULL,
		  `description` text NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		$table_hrmgt_pl_menaegment = $wpdb->prefix . 'hrmgt_pl_menaegment';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_pl_menaegment." (				  
		   `id` int(10) NOT NULL AUTO_INCREMENT,
		  `employee_id` int(20) NOT NULL,
		  `year` int(20) NOT NULL,
		  `month_1` tinyint(20) NOT NULL,
		  `month_2` tinyint(20) NOT NULL,
		  `month_3` tinyint(20) NOT NULL,
		  `month_4` tinyint(20) NOT NULL,
		  `month_5` tinyint(20) NOT NULL,
		  `month_6` tinyint(20) NOT NULL,
		  `month_7` int(20) NOT NULL,
		  `month_8` tinyint(20) NOT NULL,
		  `month_9` tinyint(20) NOT NULL,
		  `month_10` tinyint(20) NOT NULL,
		  `month_11` tinyint(20) NOT NULL,
		  `month_12` tinyint(4) NOT NULL,
		  `created_by` int(20) NOT NULL,
		  `created_at` date NOT NULL,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
	$table_hrmgt_assets = $wpdb->prefix . 'hrmgt_attendance_details';
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_assets." (				  
		  `id` int(20) NOT NULL AUTO_INCREMENT,
		  `employee_id` int(20) NOT NULL,
		  `day_1` text,
		  `day_2` text,
		  `day_3` text,
		  `day_4` text,
		  `day_5` text,
		  `day_6` text,
		  `day_7` text,
		  `day_8` text,
		  `day_9` text,
		  `day_10` text,
		  `day_11` text,
		  `day_12` text,
		  `day_13` text,
		  `day_14` text,
		  `day_15` text,
		  `day_16` text,
		  `day_17` text,
		  `day_18` text,
		  `day_19` text,
		  `day_20` text,
		  `day_21` text,
		  `day_22` text,
		  `day_23` text,
		  `day_24` text,
		  `day_25` text,
		  `day_26` text,
		  `day_27` text,
		  `day_28` text,
		  `day_29` text,
		  `day_30` text,
		  `day_31` text,
		  `month` varchar(20) NOT NULL,
		  `year` varchar(20) NOT NULL,
		  `tatal_present` varchar(20) NOT NULL,
		  `tatal_absent` varchar(20) NOT NULL,
		  `total_hl` varchar(20) NOT NULL,
		  `total_aa` varchar(20) NOT NULL,
		  `tatal_holidy` varchar(20) NOT NULL,
		  `payable_days` varchar(20) NOT NULL,
		  `opening_pl` float NOT NULL,
		  `used_pl` float NOT NULL,
		  `remaining_pl` float NOT NULL,
		  `total_p_p` varchar(20) NOT NULL,
		  `approval_status` tinyint(4) NOT NULL,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		$table_hrmgt_attendance = $wpdb->prefix . 'hrmgt_attendance';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_attendance." (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		  `employee_id` int(11) NOT NULL,
		  `attendance_date` date NOT NULL,
		  `signin_time` varchar(50) NOT NULL,
		  `signout_time` varchar(50) NOT NULL,
		  `lunch_start_time` varchar(50) NOT NULL,
		  `lunch_end_time` varchar(50) NOT NULL,
		  `working_hours` varchar(50) NOT NULL,
		  `lunch_hourse` varchar(50) NOT NULL,
		  `note` text NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		$table_hrmgt_benefits = $wpdb->prefix . 'hrmgt_benefits';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_benefits." (				  
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `employee_id` int(11) NOT NULL,
		  `education_allowance` varchar(255) NOT NULL,
		  `lunch_allowance` varchar(255) NOT NULL,
		  `housing_allowance` varchar(255) NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		
		$table_hrmgt_client_feedback = $wpdb->prefix . 'hrmgt_client_feedback';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_client_feedback." (				  
		 `id` int(20) NOT NULL AUTO_INCREMENT,
		  `client_name` varchar(255) NOT NULL,
		  `project_id` varchar(20) NOT NULL,
		  `comment` text NOT NULL,
		  `rate` varchar(255) NOT NULL,
		  `created_at` varchar(200) NOT NULL,
		  `created_by` int(20) NOT NULL,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		$table_hrmgt_client_feedback_meta = $wpdb->prefix . 'hrmgt_client_feedback_meta';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_client_feedback_meta." (				  
		`id` int(20) NOT NULL AUTO_INCREMENT,
	    `project_id` int(20) NOT NULL,
	    `employee_id` int(20) NOT NULL,
	    PRIMARY KEY (`id`)
		) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		$table_hrmgt_department = $wpdb->prefix . 'hrmgt_department';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_department." (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `department_name` varchar(255) NOT NULL,
		  `parent_department_id` int(11) NOT NULL,
		  `dept_head_id` int(11) NOT NULL,
		  `compassionate_leave` int(11) NOT NULL,
		  `hospitalisation_leave` int(11) NOT NULL,
		  `marriage_leave` int(11) NOT NULL,
		  `maternity_leave` int(11) NOT NULL,
		  `paternity_leave` int(11) NOT NULL,
		  `sick_leave` int(11) NOT NULL,
		  `annual_leaves` int(11) NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_date` date NOT NULL,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		$table_hrmgt_faq = $wpdb->prefix . 'hrmgt_faq';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_faq." (				  
		   `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(255) NOT NULL,
		  `description` text NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		$table_hrmgt_file = $wpdb->prefix . 'hrmgt_file';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_file." (				  
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(255) NOT NULL,
		  `added_date` varchar(25) NOT NULL,
		  `description` text NOT NULL,
		  `file` varchar(255) NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		$table_hrmgt_pl_menaegment = $wpdb->prefix . 'hrmgt_pl_menaegment';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_file." (				  
		  `id` int(10) NOT NULL AUTO_INCREMENT,
			  `employee_id` int(20) NOT NULL,
			  `year` int(20) NOT NULL,
			  `month_1` tinyint(20) NOT NULL,
			  `month_2` tinyint(20) NOT NULL,
			  `month_3` tinyint(20) NOT NULL,
			  `month_4` tinyint(20) NOT NULL,
			  `month_5` tinyint(20) NOT NULL,
			  `month_6` tinyint(20) NOT NULL,
			  `month_7` int(20) NOT NULL,
			  `month_8` tinyint(20) NOT NULL,
			  `month_9` tinyint(20) NOT NULL,
			  `month_10` tinyint(20) NOT NULL,
			  `month_11` tinyint(20) NOT NULL,
			  `month_12` tinyint(4) NOT NULL,
			  `created_by` int(20) NOT NULL,
			  `created_at` date NOT NULL,
			  PRIMARY KEY (`id`)";
		$wpdb->query($sql);
		
		
		
		
		
		
		$table_hrmgt_file_meta = $wpdb->prefix . 'hrmgt_file_meta';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_file_meta." (				  
		  `id` int(20) NOT NULL AUTO_INCREMENT,
		  `file_id` int(20) NOT NULL,
		  `doc_for` varchar(200) NOT NULL,
		   PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		
		$table_hrmgt_holiday = $wpdb->prefix . 'hrmgt_holiday';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_holiday." (				  
		`id` int(11) NOT NULL AUTO_INCREMENT,
	  `holiday_title` varchar(255) NOT NULL,
	  `start_date` varchar(50) NOT NULL,
	  `end_date` varchar(50) NOT NULL,
	  `description` text NOT NULL,
	  `created_by` int(11) NOT NULL,
	  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		$table_hrmgt_leave = $wpdb->prefix . 'hrmgt_leave';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_leave." (				  
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		  `employee_id` int(11) NOT NULL,
		  `leave_type` int(11) NOT NULL,
		  `leave_duration` varchar(50) NOT NULL,
		  `start_date` varchar(50) NOT NULL,
		  `end_date` varchar(50) NOT NULL,
		  `reason` text NOT NULL,
		  `status` varchar(50) NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		$table_hrmgt_message = $wpdb->prefix . 'hrmgt_message';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_message." (				  
		 `message_id` int(11) NOT NULL AUTO_INCREMENT,
		  `sender` int(11) NOT NULL,
		  `receiver` int(11) NOT NULL,
		  `msg_date` datetime NOT NULL,
		  `msg_subject` varchar(150) NOT NULL,
		  `message_body` text NOT NULL,
		  `post_id` int(11) NOT NULL,
		  `msg_status` int(11) NOT NULL,
		  PRIMARY KEY (`message_id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		$table_hrmgt_message_replies = $wpdb->prefix . 'hrmgt_message_replies';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_message_replies." (				  
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		  `message_id` int(11) NOT NULL,
		  `sender_id` int(11) NOT NULL,
		  `receiver_id` int(11) NOT NULL,
		  `message_comment` text NOT NULL,
		  `created_date` datetime NOT NULL,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		$table_hrmgt_parfomance_marks = $wpdb->prefix . 'hrmgt_parfomance_marks';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_parfomance_marks." (				  
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(255) NOT NULL,
		  `mark` varchar(50) NOT NULL,
		  `period_start` varchar(250) NOT NULL,
		  `period_end` varchar(20) NOT NULL,
		  `description` text NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		$table_hrmgt_parfomance_marks_meta = $wpdb->prefix . 'hrmgt_parfomance_marks_meta';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_parfomance_marks_meta." (				  
		  `id` int(20) NOT NULL AUTO_INCREMENT,
		  `performance_id` int(20) NOT NULL,
		  `employee_id` int(20) NOT NULL,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		
		$table_hrmgt_payslip = $wpdb->prefix . 'hrmgt_payslip';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_payslip." (				  
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `employee_id` int(11) NOT NULL,
		  `salary_date` varchar(20) NOT NULL,
		  `start_date` varchar(20) NOT NULL,
		  `end_date` varchar(20) NOT NULL,
		  `bonus_title` varchar(255) NOT NULL,
		  `bonus_amount` double NOT NULL,
		  `hourly_title` varchar(255) NOT NULL,
		  `extra_hourse` double NOT NULL,
		  `extra_hourse_amount` double NOT NULL,
		  `commission_title` varchar(255) NOT NULL,
		  `commission_amount` double NOT NULL,
		  `advance_salary_title` varchar(255) NOT NULL,
		  `advance_salary_amount` double NOT NULL,
		  `basic_salary` double NOT NULL,
		  `extra_salary_entry` text NOT NULL,
		  `extra_deduction_entry` text NOT NULL,
		  `total_amount` double NOT NULL,
		  `description` text NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		$table_hrmgt_policy = $wpdb->prefix . 'hrmgt_policy';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_policy." (				  
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `policy_type_id` int(11) NOT NULL,
		  `policy_title` varchar(255) NOT NULL,
		  `description` text NOT NULL,
		  `status` varchar(10) NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		$table_hrmgt_skill_metrix = $wpdb->prefix . 'hrmgt_skill_metrix';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_skill_metrix." (				  
		 `id` int(20) NOT NULL AUTO_INCREMENT,
		  `employee_id` int(50) NOT NULL,
		  `skill_start` varchar(20) NOT NULL,
		  `skill_end` varchar(20) NOT NULL,
		  `skill` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		
		$table_hrmgt_posted_job = $wpdb->prefix . 'hrmgt_posted_job';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_posted_job." (				  
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `job_title` varchar(255) NOT NULL,
		  `department_id` int(11) NOT NULL,
		  `designation` int(11) NOT NULL,
		  `positions` int(11) NOT NULL,
		  `closing_date` varchar(20) NOT NULL,
		  `description` text NOT NULL,
		  `status` varchar(50) NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  `criere_entry` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		$table_hrmgt_project = $wpdb->prefix . 'hrmgt_project';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_project." (				  
		     `id` int(11) NOT NULL AUTO_INCREMENT,
			  `project_title` varchar(100) NOT NULL,
			  `client_name` varchar(100) NOT NULL,
			  `start_date` varchar(20) NOT NULL,
			  `end_date` varchar(20) NOT NULL,
			  `completion_date` varchar(50) NOT NULL,
			  `status` varchar(20) NOT NULL,
			  `remark` text NOT NULL,
			  `description` text NOT NULL,
			  `created_by` int(11) NOT NULL,
			  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		$table_hrmgt_project_meta = $wpdb->prefix . 'hrmgt_project_meta';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_project_meta." (				  
		  `id` int(20) NOT NULL AUTO_INCREMENT,
		  `project_id` int(20) NOT NULL,
		  `employee_id` int(20) NOT NULL,
		   PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		

		$table_hrmgt_skill_metrix = $wpdb->prefix . 'hrmgt_skill_metrix';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_skill_metrix." (				  
		  `id` int(20) NOT NULL AUTO_INCREMENT,
		  `employee_id` int(50) NOT NULL,
		  `skill_start` varchar(20) NOT NULL,
		  `skill_end` varchar(20) NOT NULL,
		  `skill` varchar(255) NOT NULL,
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		

		
		$table_hrmgt_suggestion = $wpdb->prefix . 'hrmgt_suggestion';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_suggestion." (				  
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		  `suggetion_title` varchar(255) NOT NULL,
		  `employee_id` int(11) NOT NULL,
		  `suggestion_date` varchar(20) NOT NULL,
		  `suggestion` text NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		$table_hrmgt_task_tracker = $wpdb->prefix . 'hrmgt_task_tracker';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_task_tracker." (				  
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		  `employee_id` int(11) NOT NULL,
		  `task_cat_id` int(11) NOT NULL,
		  `work_title` varchar(255) NOT NULL,
		  `working_date` varchar(50) NOT NULL,
		  `start_time` varchar(50) NOT NULL,
		  `end_time` varchar(50) NOT NULL,
		  `status` varchar(100) NOT NULL,
		  `description` text NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		$table_hrmgt_training = $wpdb->prefix . 'hrmgt_training';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_training." (				  
		   `id` int(11) NOT NULL AUTO_INCREMENT,
		  `employee_id` int(11) NOT NULL,
		  `training_type` int(11) NOT NULL,
		  `training_title` varchar(255) NOT NULL,
		  `training_subject` varchar(255) NOT NULL,
		  `traininer` varchar(100) NOT NULL,
		  `training_location` varchar(255) NOT NULL,
		  `start_date` varchar(50) NOT NULL,
		  `end_date` varchar(50) NOT NULL,
		  `description` text NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		$table_hrmgt_training_emp = $wpdb->prefix . 'hrmgt_training_emp';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_training_emp." (				  
		   `id` int(11) NOT NULL AUTO_INCREMENT,
		  `training_id` int(11) NOT NULL,
		  `employee_id` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		$table_hrmgt_travel = $wpdb->prefix . 'hrmgt_travel';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_travel." (				  
		   `id` int(11) NOT NULL AUTO_INCREMENT,
		  `employee_id` int(11) NOT NULL,
		  `visit_purpose` varchar(255) NOT NULL,
		  `start_date` varchar(20) NOT NULL,
		  `end_date` varchar(20) NOT NULL,
		  `expected_budget` varchar(10) NOT NULL,
		  `actual_budget` varchar(10) NOT NULL,
		  `destination_data` text NOT NULL,
		  `description` text NOT NULL,
		  `status` varchar(50) NOT NULL,
		  `created_by` int(11) NOT NULL,
		  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`)
			  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
		
		$table_hrmgt_generated_salary_slip = $wpdb->prefix . 'hrmgt_generated_salary_slip';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_hrmgt_generated_salary_slip." (				  
		  `id` int(20) NOT NULL AUTO_INCREMENT,
		  `department_id` int(20) NOT NULL,
		  `attendance_detail_id` int(20) NOT NULL,
		  `employee_id` int(20) NOT NULL,
		  `account_number` varchar(200) NOT NULL,
		  `earning` text NOT NULL,
		  `deduction` text NOT NULL,
		  `total_earning` varchar(200) NOT NULL,
		  `total_deduction` varchar(200) NOT NULL,
		  `net_salary` varchar(200) NOT NULL,
		  `basic_salary` varchar(200) NOT NULL,
		  `ctc_month` varchar(200) NOT NULL,
		  PRIMARY KEY (`id`)
			  ) DEFAULT CHARSET=utf8";	
		$wpdb->query($sql);
		
	$new_field='month';
	$table_generated_salary_slip = $wpdb->prefix . 'hrmgt_generated_salary_slip';	
	if (!in_array($new_field, $wpdb->get_col( "DESC " . $table_generated_salary_slip, 0 ) )){  
		$result= $wpdb->query("ALTER  TABLE $table_generated_salary_slip  ADD   $new_field   varchar(255)");
	}

	$new_field='archive_status';
	$table_hrmgt_posted_job = $wpdb->prefix . 'hrmgt_posted_job';	
	if (!in_array($new_field, $wpdb->get_col( "DESC " . $table_hrmgt_posted_job, 0 ) )){  
		$result= $wpdb->query("ALTER TABLE  $table_hrmgt_posted_job ADD `archive_status` INT( 10 ) NOT NULL DEFAULT '1'");
	}
	
	$new_field='hours';
	$table_hrmgt_generated_salary_slip = $wpdb->prefix . 'hrmgt_generated_salary_slip';	
	if (!in_array($new_field, $wpdb->get_col( "DESC " . $table_hrmgt_generated_salary_slip, 0 ) )){  
		$result= $wpdb->query("ALTER TABLE  $table_hrmgt_generated_salary_slip ADD `hours` varchar( 20 ) NOT NULL DEFAULT '1'");
	}
	$new_field='payable_days';
	$table_hrmgt_generated_salary_slip = $wpdb->prefix . 'hrmgt_generated_salary_slip';	
	if (!in_array($new_field, $wpdb->get_col( "DESC " . $table_hrmgt_generated_salary_slip, 0 ) )){  
		$result= $wpdb->query("ALTER TABLE  $table_hrmgt_generated_salary_slip ADD `payable_days` varchar( 20 ) NOT NULL DEFAULT '1'");
	}
	$new_field='project_id';
	$table_hrmgt_parfomance_marks = $wpdb->prefix . 'hrmgt_parfomance_marks';	
	if (!in_array($new_field, $wpdb->get_col( "DESC " . $table_hrmgt_parfomance_marks, 0 ) )){  
		$result= $wpdb->query("ALTER TABLE  $table_hrmgt_parfomance_marks ADD `project_id` varchar( 20 ) NOT NULL DEFAULT '1'");
	}
	
	$new_field='total_days';
	$table_hrmgt_generated_salary_slip = $wpdb->prefix . 'hrmgt_generated_salary_slip';	
	if (!in_array($new_field, $wpdb->get_col( "DESC " . $table_hrmgt_generated_salary_slip, 0 ) )){  
		$result= $wpdb->query("ALTER TABLE  $table_hrmgt_generated_salary_slip ADD `total_days` varchar( 20 ) NOT NULL DEFAULT '1'");
	}
	
	$new_field='year';
	$table_hrmgt_generated_salary_slip = $wpdb->prefix . 'hrmgt_generated_salary_slip';	
	if (!in_array($new_field, $wpdb->get_col( "DESC " . $table_hrmgt_generated_salary_slip, 0 ) )){  
		$result= $wpdb->query("ALTER TABLE  $table_hrmgt_generated_salary_slip ADD `year` varchar( 20 ) NOT NULL DEFAULT '1'");
	}
}

?>