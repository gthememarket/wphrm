<?php 
require_once(ABSPATH.'wp-admin/includes/user.php' );
 $obj_holidy=new HrmgtHoliday();
 $obj_payslip=new HrmgtPayslip;
 $user = wp_get_current_user ();

 if (! is_user_logged_in ()) {
	$page_id = get_option ( 'hrmgt_login_page' );
	
	wp_redirect ( home_url () . "?page_id=" . $page_id );
}
if (is_super_admin ())
{
	wp_redirect ( admin_url () . 'admin.php?page=hrmgt-hr_system' );
}
$slug_array = array('view_employee','add_attendance_detail','salary_slip');
//$slug_array = array('view_employee');
$manager_role = $user->roles;
if($manager_role[0] != 'manager')
{

if(in_array($_REQUEST['tab'],$slug_array) || in_array($_REQUEST['type'],$slug_array))
{
	 $user_id = get_current_user_id();
	 //var_dump($user_id);die;
	 $AttendanceDetailsData = hrmgt_get_attendance_empid($user_id);

	 foreach($AttendanceDetailsData as $AttendanceDetailsData1)
	 {
		$test = array();
		$data[] = $AttendanceDetailsData1->id;
		$att = array_merge($test,$data);
	 }
	 
	 	
	if(isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != $user_id)
	 {
	   wp_redirect(site_url().'?hr-dashboard=user&page=user&tab=view_employee&ction=view&employee_id='.$user_id);
	    exit();
	 } 
	 if(isset($_REQUEST['tab'])&& $_REQUEST['tab'] == 'add_attendance_detail'){
	 
		 if(!in_array($_REQUEST['AttendanceDetails_id'],$att))
		 {
		    wp_redirect(site_url().'?hr-dashboard=user&page=attendance&tab=monthaly_attendance');
		   exit();
		 }
	 }
	 
	  if(isset($_REQUEST['type'])&& $_REQUEST['type'] == 'salary_slip'){
	  
	   $SlipData = $obj_payslip->hrmgt_get_generated_slip_by_user_id($user_id);
	
	 foreach($SlipData as $SlipData1)
	 {
		$test1 = array();
		$data1[] = $SlipData1->id;
		$slip_data = array_merge($test1,$data1);
	 }
	if(!in_array($_REQUEST['AttDetail_id'],$slip_data)){
		  wp_redirect(site_url().'?hr-dashboard=user&page=payslip');
		   exit();
		 }
	 } 
}
} 
$HrmgtAttendance= new HrmgtAttendance();
$HrmgtAttendanceDetails= new HrmgtAttendanceDetails();

 $args= array('post_type'=>'hrmgt_events','orderby'=>'post_title');
 $cat_result = get_posts( $args );
 $cal_array = array();
 foreach($cat_result as $key=>$value)
 {
	$post_id = $value->ID;
	$title = get_the_title($value->ID);
	$start_date = get_post_meta($post_id,'event_start_date',true);
	$end_date = get_post_meta($post_id,'event_end_date',true);	
	$cal_array[] = array(
	
		'title'=>$title,
		'start' =>mysql2date('Y-m-d',$start_date ) ,
		'end' =>  date('Y-m-d', strtotime($end_date. ' + 1 days')),
		'background'=>'#1DB198'
	);
 }
?>
<?php 
global $wpdb;	
if(isset($_POST['punch_in']))
{	
	//date_default_timezone_set('Asia/Kolkata');
	date_default_timezone_set('Asia/Dhaka');
	$current_userid =  get_current_user_id();
	$date = date("Y-m-d");	
	$time = date('H:i:s');	
	$punch_in['employee_id'] =$current_userid;
	$punch_in['attendance_date'] =$date;
	$punch_in['signin_time'] =$time;	
	$HrmgtAttendance->hrmgt_add_attendance($punch_in);	
}

if(isset($_POST['lunchtart']))
{
	date_default_timezone_set('Asia/Dhaka');	
	$time = date('H:i:s');	
	$lunch_in['attendance_id'] =$_POST['id'];	
	$lunch_in['lunch_start_time'] =$time;
	$lunch_in['action'] ="edit";		
	$HrmgtAttendance->hrmgt_add_attendance($lunch_in);
}

if(isset($_POST['lunchend']))
{	
	$lunch_in['attendance_id'] =$_POST['id'];	
	$table_hrmgt_attendance = $wpdb->prefix. 'hrmgt_attendance';
	$id=$_POST['id'];
	
	$sql = "select * from $table_hrmgt_attendance where id= '$id' ";		
	$result = $wpdb->get_row($sql);
	$lunch_start_time = $result->lunch_start_time;
	
	date_default_timezone_set('Asia/Dhaka');	
	$time = date('H:i:s');	
	
	$lunch_in['lunch_end_time'] =$time;
	$lunch_in['action'] ="edit";
	$lunch_in['lunch_start_time']=$lunch_start_time;	
	$HrmgtAttendance->hrmgt_add_attendance($lunch_in);
}

if(isset($_POST['punch_out']))
{	
	$punch_in['mode'] = "dayout";
	$id = $_POST['id'];
	$table_hrmgt_attendance = $wpdb->prefix. 'hrmgt_attendance';
	$sql = "select * from $table_hrmgt_attendance where id= '$id' ";		
	$result = $wpdb->get_row($sql);
	$signin_time = $result->signin_time;
	$lunch_end_time = $result->lunch_end_time;
	$lunch_start_time = $result->lunch_start_time;	
	if(empty($lunch_start_time))
	{
		$lunch_in['lunch_start_time']="00:00:00";
	}
	else
	{
		$lunch_in['lunch_start_time']=	$lunch_start_time;
	}
	
	
	if(empty($lunch_end_time))
	{
		$lunch_in['lunch_end_time']="00:00:00";
	}
	else
	{
		$lunch_in['lunch_end_time']=$lunch_end_time;
	}
	
	
	date_default_timezone_set('Asia/Dhaka');	
	$time = date('H:i:s');	
	$lunch_in['lunch_end_time'];
	$lunch_in['lunch_start_time'];
	$lunch_in['attendance_id'] =$_POST['id'];	
	$lunch_in['signout_time'] =$time;
	$lunch_in['action'] ="edit";
	$lunch_in['signin_time']=$signin_time;		
	$HrmgtAttendance->hrmgt_add_attendance($lunch_in);
	
}
?>
<style>
.fc-content{
	text-align:center;
}
a:hover
{
	text-decoration:none !important;
}
</style>

<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/dataTables.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/dataTables.editor.min.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/dataTables.tableTools.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/jquery-ui.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/font-awesome.min.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/popup.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/style.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/custom.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/fullcalendar.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/dataTables.responsive.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/jquery.rateyo.css'; ?>">
<link rel="icon" href="<?php print HRMS_PLUGIN_URL .'/assets/images/hr-managemt-1.png' ?>" type="image/x-icon"/>
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/bootstrap.min.css'; ?>">	
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/bootstrap-timepicker.min.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/bootstrap-multiselect.css'; ?>">	
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/white.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/hrmgt.min.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/triview.css'; ?>">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

<?php  
if (is_rtl())
{ ?>
	<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/bootstrap-rtl.min.css'; ?>">
<?php } ?>

<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/jquery-1.11.1.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/jquery.timeago.js'; ?>"></script>
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/lib/validationEngine/css/validationEngine.jquery.css'; ?>">
<link rel="stylesheet"	href="<?php echo HRMS_PLUGIN_URL.'/assets/css/hr-responsive.css'; ?>">

<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/jquery-ui.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/moment.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/fullcalendar.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/jquery.dataTables.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/image-upload.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/dataTables.tableTools.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/dataTables.editor.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/bootstrap.min.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/dataTables.responsive.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/bootstrap-timepicker.min.js'; ?>"></script>
<!-- <script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/popup.js'; ?>"></script>-->
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/bootstrap-multiselect.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/responsive-tabs.js'; ?>" ></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/jquery.rateyo.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/lib/validationEngine/js/languages/jquery.validationEngine-en.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/lib/validationEngine/js/jquery.validationEngine.js'; ?>"></script>
<?php
	$lancode=get_locale();
	$code=substr($lancode,0,2); ?>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/assets/js/calendar-lang/'.$code.'.js'; ?>"></script>
<script type="text/javascript"	src="<?php echo HRMS_PLUGIN_URL.'/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js'; ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#calendar').fullCalendar( {
			 header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
			editable: false	,						
			events:<?php echo json_encode($cal_array);?>		
		 } );
	});
</script>
</head>

<body class="apart-management-content">
<?php if(!isset($_REQUEST['page'])){?>
<div class="popup-bg">
    <div class="overlay-content">
		<div class="category_list"></div>    
    </div> 
</div>
<?php }?>
	<div class="mainpage">
		<div class="navbar">	
			<div class="col-md-8 col-sm-8 col-xs-6">
				<h3 class="logo-image"><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" />
				<span class="system-name"><?php echo get_option( 'hrmgt_system_name' );?> </span>
				</h3>
			</div>		
			<ul class="nav navbar-right col-md-4 col-sm-4 col-xs-6">	
				<li class="dropdown">
					<a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
					<?php
						$userimage = get_user_meta( $user->ID,'hrmgt_user_avatar',true );	
						if (empty ( $userimage ))
						{
							echo '<img src='.get_option( 'hrmgt_system_logo' ).' height="40px" width="40px" class="img-circle" />';
						}
						else	
							echo '<img src=' . $userimage . ' height="40px" width="40px" class="img-circle"/>';
						?>
						<span>	<?php echo $user->display_name;?> </span> <b class="caret"></b>
					</a>
					<ul class="dropdown-menu extended logout">
						<li><a href="?hr-dashboard=user&page=profile"><i class="fa fa-user"></i>
							<?php _e('My Profile','hr_mgt');?></a></li>
						<li><a href="<?php echo wp_logout_url(home_url()); ?>"><i class="fa fa-sign-out m-r-xs"></i><?php _e('Log Out','hr_mgt');?> </a></li>
					</ul>
				</li>
			</ul>	
		</div>
	</div>
	
<div class="container-fluid" style="background:#364150; none repeat scroll 0 0">
	<div class="row">
	<div class="col-sm-2 nopadding hr_left nav-side-menu">	<!--  Left Side -->
	<div class="brand"><?php _e('Menu',''); ?>    
	<i data-target="#menu-content" data-toggle="collapse" class="fa fa-bars fa-2x toggle-btn collapsed" aria-expanded="false"></i></div>
	<?php	
	//$menu = gmgt_menu();
	$menu 	= 	get_option( 'hrmgt_access_right');	
	$class 	= 	"";
	if (! isset ( $_REQUEST ['page'] ))	
		$class = 'class = "active"';
		 //print_r($menu); 	?>
		 
			<ul class="nav nav-pills nav-stacked collapse menu-sec " id="menu-content">
				<li><a href="<?php echo site_url();?>"><span class="icone"><img src="<?php echo plugins_url( 'wphrm/assets/images/icon/home.png' )?>"/></span><span class="title"><?php _e('Home','apartment_mgt');?></span></a></li>
				<li <?php echo $class;?>><a href="?apartment-dashboard=user"><span class="icone"><img src="<?php echo plugins_url('wphrm/assets/images/icon/dashboard.png' )?>"/></span><span
					class="title"><?php _e('Dashboard','hr_mgt');?></span></a></li>
					<?php								
						$role = hrmgt_get_user_role(get_current_user_id());
						foreach ( $menu as $key=>$value ) 
						{
							if ( isset($value[$role]) &&  $value[$role]) 
							{
								if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $value ['page_link'])
									$class = 'class = "active"';
								else
									$class = "";
								echo '<li ' . $class . '><a href="?hr-dashboard=user&page=' . $value ['page_link'] . '" class="left-tooltip" data-tooltip="'. $value ['menu_title'] . '" title="'. $value ['menu_title'] . '"><span class="icone"> <img src="' .$value ['menu_icone'].'" /></span><span class="title">'.$value['menu_title'] . '</span></a></li>';
							}					
						}		
					?>								
			</ul>
	</div>
		
		<div class="col-md-10 page-inner" style="min-height:1050px;">
			<div class="right_side <?php if(isset($_REQUEST['page']))echo $_REQUEST['page'];?>">
				<?php 
			if (isset ( $_REQUEST ['page'] )) {
				require_once HRMS_PLUGIN_DIR . '/template/' . $_REQUEST['page'] . '.php';
				return false;
				} ?>				
				<div class="row ">
					<div class="row left_section col-md-8 col-sm-8">
						<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
							<a href="<?php echo home_url().'?hr-dashboard=user&page=user&tab=employee_list';?>">
								<div class="panel info-box panel-white">
									<div class="panel-body member">
										<img src="<?php echo HRMS_PLUGIN_URL."/assets/images/dashboard/employee.png"?>" class="dashboard_background">
										<div class="info-box-stats">
											<p class="counter"><?php echo sprintf("%02d", count(get_users(array('role'=>'employee'))));?></p>											
											<span class="info-box-title"><?php echo esc_html( __( 'Employee', 'hr_mgt' ) );?></span>
										</div>										
									</div>
								</div>
							</a>
						</div>
						<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
							<a href="<?php echo home_url().'?hr-dashboard=user&page=department';?>">
								<div class="panel info-box panel-white">
								<div class="panel-body staff-member">
								<img src="<?php echo HRMS_PLUGIN_URL."/assets/images/dashboard/department.png"?>" class="dashboard_background">
									<div class="info-box-stats">
										<p class="counter"><?php $counter=get_count('hrmgt_department'); echo sprintf("%02d",$counter);?></p>
										<span class="info-box-title"><?php echo esc_html( __( 'Department', 'hr_mgt' ) );?></span>
									</div>									
								</div>
							</div>
								</a>
						</div>
						<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
						<a href="<?php echo home_url().'?hr-dashboard=user&page=genral&tab=holiday_list';?>">
							<div class="panel info-box panel-white">
								<div class="panel-body group">
								<img src="<?php echo HRMS_PLUGIN_URL."/assets/images/dashboard/holidays.png"?>" class="dashboard_background">
									<div class="info-box-stats">
										<p class="counter"><?php $counter=get_count('hrmgt_holiday'); echo sprintf("%02d",$counter);?></p>
										
										<span class="info-box-title"><?php echo esc_html( __( 'Holidays', 'hr_mgt' ) );?></span>
									</div>
									
									
								</div>
							</div>
							</a>
						</div>
						
						<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6">
						<a href="<?php echo home_url().'?hr-dashboard=user&page=message';?>">
							<div class="panel info-box panel-white">
								<div class="panel-body message">
								<img src="<?php echo HRMS_PLUGIN_URL."/assets/images/dashboard/message.png"?>" class="dashboard_background_message">
									<div class="info-box-stats">
										<p class="counter"><?php $counter= count(hrmgt_count_inbox_item(get_current_user_id())); echo sprintf("%02d",$counter);?></p>
										
										<span class="info-box-title"><?php echo esc_html( __( 'Message', 'hr_mgt' ) );?></span>
									</div>								
								</div>
							</div>
							</a>
						</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 membership-list ">
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php _e('Punch Details','hr_mgt');?></h3>						
					</div>
					<div class="panel-body">
						<form method="post">							
						<?php 
							$result = $HrmgtAttendance->hrmgt_punchin_user();
							if(isset($result)){ 							
								print "<input type='hidden' name='id'  value='$result->id' />";
							} ?>						
							<?php
							if(empty($result->signin_time)){
								print "<input type='submit' name='punch_in' class='btn btn-primary' value='Dayin' />";
							}
							else{
								print "<input type='submit' name='punch_in' class='btn btn-primary' value='Dayin' disabled  />";
							}
							?>
								
							<?php
							if(isset($result->signin_time)){
								if(empty($result->lunch_start_time)){
									print "<input type='submit' name='lunchtart' class='btn btn-primary' value='Lunch Start'/>";
								}
								else{
									print "<input type='submit' name='lunchtart' class='btn btn-primary' value='Lunch Start' disabled />";
								}
								
							 } 
							 ?>
														
							<div class="punch-details">						
							<?php 
								if(isset($result)){
									if(isset($result->signin_time)){ ?>
										<div class="punchin">
											<table class="table">												
												<thead>
													<tr>
														<th><?php _e('Date','hr_mgt');?></th>
														<th><?php _e('Dayin','hr_mgt');?></th>
														<th><?php _e('Dayout','hr_mgt');?></th>
														<th><?php _e('Dayout','hr_mgt');?></th>
													</tr>
													<tr>
														<td><?php print $result->attendance_date ?></td>
														<td><?php print $result->signin_time ?></td>
														<td><?php print $result->signout_time ?></td>
														<?php 
															if( empty($result->signout_time) ){
															if( !empty($result->lunch_start_time) && empty($result->lunch_end_time)){
																print "<td><input type='submit' name='punch_out' class='btn btn-primary' value='Dayout' disabled /></td>";
															}
															else{
																print "<td><input type='submit' name='punch_out' class='btn btn-primary' value='Dayout' /></td>";
															}																														}
															else{
																print "<td><input type='submit' name='punch_out' class='btn btn-primary' value='Dayout' disabled /></td>";
															}
															?>
															
													</tr>
												</thead>
												</table>
											</div>
									<?php }
										
									if(isset($result->lunch_start_time) && !empty($result->lunch_start_time)){ ?>
										<div class="punchin">
											<table class="table">
												<thead>
													<tr>															
														<th><?php _e('Lunch Start','hr_mgt');?> </th>
														<th><?php _e('Lunch End','hr_mgt');?> </th>
														<th><?php _e('Lunch End','hr_mgt');?></th>
													</tr>
													<tr>															
														<td><?php print $result->lunch_start_time ?></td>
														<td><?php print $result->lunch_end_time ?></td>
														<?php 
															if(empty($result->lunch_end_time)){
																print "<td><input type='submit' name='lunchend' class='btn btn-primary' value='Lunch End')' /></td>";
															}
															else{
																print "<td><input type='submit' name='lunchend' class='btn btn-primary' value='Lunch End')' disabled /></td>";
															}
														?>														
													</tr>
												</thead>
											</table>
										</div>
									<?php }	} ?>
						</div>
						</form>
						
					</div>					
				</div>
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><?php _e('Birthdays','hr_mgt');?></h3>						
					</div>					
					<div class="panel-body">
						<table class="table">
							<thead>
								<tr>
									<th><b><?php _e('Employee Name','hr_mgt');?></b></th>
									<th><b><?php _e('Date Of Birth','hr_mgt');?></b></th>
								</tr>
							</thead>
							<tbody>	
							 
							
							<?php 
							$birthday_emp =  get_employee_birthday(date('m'));
							if(!empty($birthday_emp))
							{								
								foreach($birthday_emp as $employee)
								{
									if(get_user_meta($employee->ID,'working_status',true)=="Working"){
									if($employee->hrmgt_user_avatar)
									{
										$profile = $employee->hrmgt_user_avatar;
									}
									else
									{
										$profile = get_option('hrmgt_system_logo');
									}
									?>
								<tr>
									<td><span class="bathday-profile"><img height="30px" width="30px" src="<?php print $profile ?>" /></span><?php print hrmgt_get_display_name($employee->ID) ?></td>
									<td><?php print hrmgt_change_dateformat($employee->birth_date) ?></td>
								</tr>								
							<?php } } } 
							else
							{
								_e('None','hr_mgt');
							}
							?>
						</tbody>
					</table>		
					
					</div>
				</div>
				
				
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><a href="?hr-dashboard=user&page=genral&tab=holiday_list"><?php _e('Holiday List','hr_mgt');?></a></h3>						
					</div>					
					<div class="panel-body">
						<table class="table">						
						<?php 
							$holidaydata = $obj_holidy->get_current_month_holidy(date('m'),date('Y'));
							if(!empty($holidaydata))
							{
								foreach($holidaydata as $holiday)
								{ ?>
								<tr class=" view-holiday" id="<?php print $holiday->id ?>" style="background:#FCF8E3">
									<td class="cursor view-holiday" ><?php _e($holiday->holiday_title,'hr_mgt') ?></td>
									<td class="cursor  text-right">
										<?php 
											$start_date = $holiday->start_date;
											$end_date = $holiday->end_date;
											if($start_date == $end_date)
											{
												echo date(get_option('date_format'),strtotime($start_date));
											}
											else
											{
												echo date(get_option('date_format'),strtotime($start_date)) ."<br>To<br> ".date(get_option('date_format'),strtotime($end_date));
											}
										?>
									</td>
								</tr>
						<?php 	}
							 }
							 else
							 {
								 _e('No Holiday','hr_mgt');
							 }	?>										
						</table>					
					</div>
				</div>
				
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><a href="?hr-dashboard=user&page=event"><?php _e('Event List','hr_mgt');?></a></h3>						
					</div>					
					<div class="panel-body">
						<table class="table">						
						<?php 
						
							$EventData = get_current_month_event(date('m'),date('Y'));					
							if(!empty($EventData))
							{
								foreach($EventData as $event)
								{ 
									$ed1 = strtotime(get_post_meta($event->ID,'event_start_date',true));
									$ed2 = strtotime(get_post_meta($event->ID,'event_end_date',true));
									if($ed1==$ed2)
									{
										$EventDate = hrmgt_change_dateformat(get_post_meta($event->ID,'event_start_date',true));
									}
									else
									{
										$EventDate = hrmgt_change_dateformat(get_post_meta($event->ID,'event_start_date',true)) .' <br>To<br>'.hrmgt_change_dateformat(get_post_meta($event->ID,'event_end_date',true));
									}			
								
								?>
								<tr class="" style="background:#FCF8E3;">
									<td class="cursor view-event" id="<?php print $event->ID;?>" ><?php _e($event->post_title,'hr_mgt') ?></td>
									<td class="cursor view-event text-right" id="<?php print $event->ID;?>" ><?php print $EventDate ?></td>
								</tr>	
							<?php }
							 } 
							else
							{
								_e('No Event','hr_mgt');
							}
							 ?>										
						</table>					
					</div>
				</div>
				
				<div class="panel panel-white">
					<div class="panel-heading">
						<h3 class="panel-title"><a href="?hr-dashboard=user&page=notice"><?php _e('Notice List','hr_mgt');?></a></h3>						
					</div>					
					<div class="panel-body">
						<table class="table">						
						<?php 
							$NoticeData = get_current_month_notice(date('m'),date('Y'),$role);					
							if(!empty($NoticeData))
							{
								foreach($NoticeData as $key=>$notice)
								{	
									$nd1 = strtotime(get_post_meta($notice->ID,'start_date',true));
									$nd2 = strtotime(get_post_meta($notice->ID,'end_date',true));
									if($nd1==$nd2)
									{
										$NoticeDate = hrmgt_change_dateformat(get_post_meta($notice->ID,'start_date',true));
									}
									else
									{
										$NoticeDate = hrmgt_change_dateformat(get_post_meta($notice->ID,'start_date',true)).' <br>To<br> '.hrmgt_change_dateformat(get_post_meta($notice->ID,'end_date',true));
									}
								?>
								<tr class="" style="background:#FCF8E3; color:grey">
									<td class="cursor view-notice" id="<?php print $notice->ID ?>" ><?php print $notice->post_title ?></td>
									<td class="cursor view-notice text-right" id="<?php print $notice->ID ?>" ><?php print $NoticeDate ?></td>
								</tr>	
							<?php }
							 }
							else
							{
								_e('No Notice','hr_mgt');
							}
							 ?>										
						</table>					
					</div>
				</div>
				
			</div>
					<div class="col-md-8 col-sm-8 col-xs-12">
						<div class="panel panel-white">
							<div class="panel-body">
								<div id="calendar"></div><br>
								<mark style="height:5px;width:10px; background:rgb(34,186,160)">&nbsp;&nbsp;&nbsp;</mark><span> &nbsp; <?php _e('Event','hr_mgt') ?><span>
							</div>
						</div>
					</div>
				</div>
		
			</div>

		</div>
	</div>

</div>

</body>
</html>
