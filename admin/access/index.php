<?php 		
$active_tab = isset($_GET['tab'])?$_GET['tab']:'access_right_setting';
$obj_travel=new HrmgtTravel; ?>
<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?>
		</h3>
</div>
<?php

if(isset($_POST['save_access_right'])){
	$access_right = array();	
	$result=get_option( 'hrmgt_access_right');

	$access_right['department'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/department.png' ),'menu_title'=>'Department',
	'employee' => isset($_REQUEST['department_employee'])?$_REQUEST['department_employee']:0,
    'accountant' => isset($_REQUEST['department_accountant'])?$_REQUEST['department_accountant']:0,
	'manager' => isset($_REQUEST['department_manager'])?$_REQUEST['department_manager']:0,	
	'page_link'=>'department');
	
	$access_right['user'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/user.png' ),'menu_title'=>'All User',
	'employee' => isset($_REQUEST['employee_employee'])?$_REQUEST['employee_employee']:0,
	'accountant' => isset($_REQUEST['employee_accountant'])?$_REQUEST['employee_accountant']:0,
	'manager' => isset($_REQUEST['employee_manager'])?$_REQUEST['employee_manager']:0,
	'page_link'=>'user');
	
	$access_right['attendance'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/attendance.png' ),'menu_title'=>'Attendance',
	'employee' => isset($_REQUEST['attendance_employee'])?$_REQUEST['attendance_employee']:0,	
	'accountant' => isset($_REQUEST['attendance_accountant'])?$_REQUEST['attendance_accountant']:0,
	'manager' => isset($_REQUEST['attendance_manager'])?$_REQUEST['attendance_manager']:0,	
	'page_link'=>'attendance');
	
	$access_right['leave'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/leave.png'),'menu_title'=>'Leave',
	'employee' => isset($_REQUEST['leave_employee'])? $_REQUEST['leave_employee']:0,	
	'accountant' => isset($_REQUEST['leave_accountant'])? $_REQUEST['leave_accountant']:0,
	'manager' => isset($_REQUEST['leave_manager'])? $_REQUEST['leave_manager']:0,
	'page_link'=>'leave');
	
	
	$access_right['pl'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/pl.png'),'menu_title'=>'Paid Leave',
	'employee' => isset($_REQUEST['pl_employee'])? $_REQUEST['pl_employee']:0,	
	'accountant' => isset($_REQUEST['pl_accountant'])? $_REQUEST['pl_accountant']:0,
	'manager' => isset($_REQUEST['pl_manager'])? $_REQUEST['pl_manager']:0,
	'page_link'=>'pl');
	
	
	$access_right['payslip'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/payslip.png' ),'menu_title'=>'Payslip',
	'employee' => isset($_REQUEST['payslip_employee'])?$_REQUEST['payslip_employee']:0,
	'accountant' => isset($_REQUEST['payslip_accountant'])?$_REQUEST['payslip_accountant']:0,
	'manager' => isset($_REQUEST['payslip_manager'])?$_REQUEST['payslip_manager']:0,
	'page_link'=>'payslip');
	
	$access_right['earning_deduction'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/earning_deduction.png' ),'menu_title'=>'Earning/Deduction',
	'employee' => isset($_REQUEST['earning_deduction_employee'])?$_REQUEST['earning_deduction_employee']:0,
	'accountant' => isset($_REQUEST['earning_deduction_accountant'])?$_REQUEST['earning_deduction_accountant']:0,
	'manager' => isset($_REQUEST['earning_deduction_manager'])?$_REQUEST['earning_deduction_manager']:0,
	'page_link'=>'earning_deduction');
	
	$access_right['asset_benefit'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/asset_benefit.png' ),'menu_title'=>'Asset/Benefit',
	'employee' => isset($_REQUEST['asset_benefit_employee'])?$_REQUEST['asset_benefit_employee']:0,
	'accountant' => isset($_REQUEST['asset_benefit_accountant'])?$_REQUEST['asset_benefit_accountant']:0,
	'manager' => isset($_REQUEST['asset_benefit_manager'])?$_REQUEST['asset_benefit_manager']:0,
	'page_link'=>'asset_benefit');	
	
	$access_right['employee_training'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/employee-training.png' ),'menu_title'=>'Employee Training',
	'employee' => isset($_REQUEST['employee_training_employee'])?$_REQUEST['employee_training_employee']:0,	
	'accountant' => isset($_REQUEST['employee_training_accountant'])?$_REQUEST['employee_training_accountant']:0,
	'manager' => isset($_REQUEST['employee_training_manager'])?$_REQUEST['employee_training_manager']:0,	
	'page_link'=>'employee_training');
	
	$access_right['performance'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/prformance-mark.png' ),'menu_title'=>'Performance Marks',
	'employee' => isset($_REQUEST['perfomance_employee'])?$_REQUEST['perfomance_employee']:0,
	'accountant' => isset($_REQUEST['perfomance_accountant'])?$_REQUEST['perfomance_accountant']:0,
	'manager' => isset($_REQUEST['perfomance_manager'])?$_REQUEST['perfomance_manager']:0,
	'page_link'=>'performance');
	
	$access_right['project'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/projectr.png' ),'menu_title'=>'Project',
	'employee' => isset($_REQUEST['project_employee'])?$_REQUEST['project_employee']:0,	
	'accountant' => isset($_REQUEST['project_accountant'])?$_REQUEST['project_accountant']:0,
	'manager' => isset($_REQUEST['project_manager'])?$_REQUEST['project_manager']:0,	
	'page_link'=>'project');
	
	$access_right['requirements'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/requirement.png' ),'menu_title'=>'Recruitment',
	'employee' => isset($_REQUEST['requirements_employee'])?$_REQUEST['requirements_employee']:0,
	'accountant' => isset($_REQUEST['requirements_accountant'])?$_REQUEST['requirements_accountant']:0,
	'manager' => isset($_REQUEST['requirements_manager'])?$_REQUEST['requirements_manager']:0,
	'page_link'=>'requirements');
	
	$access_right['event'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/events.png' ),'menu_title'=>'Event',
	'employee' => isset($_REQUEST['event_employee'])?$_REQUEST['event_employee']:0,	
	'accountant' => isset($_REQUEST['event_accountant'])?$_REQUEST['event_accountant']:0,
	'manager' => isset($_REQUEST['event_manager'])?$_REQUEST['event_manager']:0,	
	'page_link'=>'event');
	
	$access_right['travel'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/travel.png' ),'menu_title'=>'Travel',
	'employee' => isset($_REQUEST['travel_employee'])?$_REQUEST['travel_employee']:0,
	'accountant' => isset($_REQUEST['travel_accountant'])?$_REQUEST['travel_accountant']:0,
	'manager' => isset($_REQUEST['travel_manager'])?$_REQUEST['travel_manager']:0,
	'page_link'=>'travel');
	
	$access_right['notice'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/notice.png' ),'menu_title'=>'Notice',
	'employee' => isset($_REQUEST['notice_employee'])?$_REQUEST['notice_employee']:0,
	'accountant' => isset($_REQUEST['notice_accountant'])?$_REQUEST['notice_accountant']:0,
	'manager' => isset($_REQUEST['notice_manager'])?$_REQUEST['notice_manager']:0,
	'page_link'=>'notice');
	
	$access_right['file'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/file.png' ),'menu_title'=>'File',
	'employee' => isset($_REQUEST['file_employee'])?$_REQUEST['file_employee']:0,
	'accountant' => isset($_REQUEST['file_accountant'])?$_REQUEST['file_accountant']:0,
	'manager' => isset($_REQUEST['file_manager'])?$_REQUEST['file_manager']:0,
	'page_link'=>'file');
	
	$access_right['employee_feedback'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/employee_feedback.png' ),'menu_title'=>'Employee Feedback',
	'employee' => isset($_REQUEST['employee_feedback_employee'])?$_REQUEST['employee_feedback_employee']:0,
	'accountant' => isset($_REQUEST['employee_feedback_accountant'])?$_REQUEST['employee_feedback_accountant']:0,
	'manager' => isset($_REQUEST['employee_feedback_manager'])?$_REQUEST['employee_feedback_manager']:0,
	'page_link'=>'employee_feedback');
	
	$access_right['client_feedback'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/client_feedback.png' ),'menu_title'=>'Client Feedback',
	'employee' => isset($_REQUEST['client_feedback_employee'])?$_REQUEST['client_feedback_employee']:0,
	'accountant' => isset($_REQUEST['client_feedback_accountant'])?$_REQUEST['client_feedback_accountant']:0,
	'manager' => isset($_REQUEST['client_feedback_manager'])?$_REQUEST['client_feedback_manager']:0,
	'page_link'=>'client_feedback');
	
	$access_right['message'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/message.png' ),'menu_title'=>'Message',
	'employee' => isset($_REQUEST['message_employee'])?$_REQUEST['message_employee']:0,	
	'accountant' => isset($_REQUEST['message_accountant'])?$_REQUEST['message_accountant']:0,	
	'manager' => isset($_REQUEST['message_manager'])?$_REQUEST['message_manager']:0,	
	'page_link'=>'message');
	
	$access_right['time_tracker'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/time-trackers.png' ),'menu_title'=>'Time Tracker',
	'employee' => isset($_REQUEST['time_tracker_employee'])?$_REQUEST['time_tracker_employee']:0,	
	'accountant' => isset($_REQUEST['time_tracker_accountant'])?$_REQUEST['time_tracker_accountant']:0,	
	'manager' => isset($_REQUEST['time_tracker_manager'])?$_REQUEST['time_tracker_manager']:0,	
	'page_link'=>'time_tracker');
	
	$access_right['report'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/report.png' ),'menu_title'=>'Report',
	'employee' => isset($_REQUEST['report_employee'])?$_REQUEST['report_employee']:0,	
	'accountant' => isset($_REQUEST['report_accountant'])?$_REQUEST['report_accountant']:0,	
	'manager' => isset($_REQUEST['report_manager'])?$_REQUEST['report_manager']:0,	
	'page_link'=>'report');
	
	$access_right['skill_metrix'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/skill_metrix.png' ),'menu_title'=>'Skill Matrix',
	'employee' => isset($_REQUEST['skill_metrix_employee'])?$_REQUEST['skill_metrix_employee']:0,	
	'accountant' => isset($_REQUEST['skill_metrix_accountant'])?$_REQUEST['skill_metrix_accountant']:0,	
	'manager' => isset($_REQUEST['skill_metrix_manager'])?$_REQUEST['skill_metrix_manager']:0,	
	'page_link'=>'skill_metrix');
	
	$access_right['genral'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/genral.png' ),'menu_title'=>'General',
	'employee' => isset($_REQUEST['genral_employee'])?$_REQUEST['genral_employee']:0,	
	'accountant' => isset($_REQUEST['genral_accountant'])?$_REQUEST['genral_accountant']:0,	
	'manager' => isset($_REQUEST['genral_manager'])?$_REQUEST['genral_manager']:0,	
	'page_link'=>'genral');
	
	$access_right['mail_template'] =array('menu_icone'=>plugins_url( 'wphrm/assets/images/icon/mail.png' ),'menu_title'=>'Mail Template',
	'employee' => isset($_REQUEST['mail_template_employee'])?$_REQUEST['mail_template_employee']:0,	
	'accountant' => isset($_REQUEST['mail_template_accountant'])?$_REQUEST['mail_template_accountant']:0,	
	'manager' => isset($_REQUEST['mail_template_manager'])?$_REQUEST['mail_template_manager']:0,	
	'page_link'=>'mail_template');
	

	$result=update_option( 'hrmgt_access_right',$access_right );
	wp_redirect ( admin_url() . 'admin.php?page=hrmgt-access-right&message=1');	
	
}
$access_right=get_option( 'hrmgt_access_right');	
	if(isset($_REQUEST['message'])){
	$message =$_REQUEST['message'];
	if($message == 1){ ?>
		<div id="message" class="updated below-h2 "><p>	<?php _e('Record Updated Successfully','hr_mgt');?></p></div>
	<?php 		
	} }
 ?>
<div id="main-wrapper">
	<div class="row">
		<div class="col-md-12">		
			<div class="panel panel-white">				
				<div class="panel-body"> 
					<ul class="nav nav-tabs panel_tabs" role="tablist">
				<li class="<?php if($active_tab == 'access_right_setting') echo "active";?>">
				  <a href="?hr-dashboard=user&page=hrmgt-access-right&tab=access_right_setting">
					 <i class="fa fa-align-justify"></i> <?php _e('Access Right Settings', 'hr_mgt'); ?></a>
				  </a>
				</li>
				
				  
			</ul>		
		<?php
		if($active_tab=='access_right_setting'){ ?>
		<style>
			#access_right_form .row{
				border-bottom:1px solid grey;
				padding:10px 0;
				
			}
		</style>
		<form name="student_form" style="margin-top:50px" action="" method="post" class="form-horizontal" id="access_right_form">
		<div class="col-md-12">
		<div class="row">
			<div class="col-md-3"><?php _e('Menu','hr_mgt');?></div>
			<div class="col-md-3"><?php _e('Employee','hr_mgt');?></div>				
			<div class="col-md-3"><?php _e('Accountant','hr_mgt');?></div>				
			<div class="col-md-3"><?php _e('HR Manager','hr_mgt');?></div>				
		</div>
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Department','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" <?php echo checked($access_right['department']['employee'],1);?> value="1" name="department_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" <?php echo checked($access_right['department']['accountant'],1);?> value="1" name="department_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['department']['manager'],1);?>  name="department_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('All User','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['user']['employee'],1);?> name="employee_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['user']['accountant'],1);?> name="employee_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['user']['manager'],1);?>  name="employee_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Attendance','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['attendance']['employee'],1);?> name="attendance_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['attendance']['accountant'],1);?>  name="attendance_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['attendance']['manager'],1);?> name="attendance_manager" readonly>	              
					</label>
				</div>
			</div>
			</div>
			
			
			
			<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Paid Leave','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['pl']['employee'],1);?> name="pl_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['pl']['accountant'],1);?> name="pl_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['pl']['manager'],1); ?> name="pl_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Leave','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['leave']['employee'],1);?> name="leave_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['leave']['accountant'],1);?> name="leave_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['leave']['manager'],1); ?> name="leave_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Payslip','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['payslip']['employee'],1);?> name="payslip_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['payslip']['accountant'],1);?> name="payslip_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['payslip']['manager'],1);?>  name="payslip_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Earning/Deduction','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['earning_deduction']['employee'],1);?> name="earning_deduction_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['earning_deduction']['accountant'],1);?> name="earning_deduction_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['earning_deduction']['manager'],1);?>  name="earning_deduction_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Asset/Benefit','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['asset_benefit']['employee'],1);?> name="asset_benefit_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['asset_benefit']['accountant'],1);?> name="asset_benefit_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['asset_benefit']['manager'],1);?>  name="asset_benefit_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>		
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Employee Training','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['employee_training']['employee'],1);?> name="employee_training_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['employee_training']['accountant'],1);?> name="employee_training_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['employee_training']['manager'],1);?> name="employee_training_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Perfomance Marks','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['performance']['employee'],1);?> name="perfomance_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['performance']['accountant'],1);?> name="perfomance_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['performance']['manager'],1);?> name="perfomance_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Project','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['project']['employee'],1);?> name="project_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['project']['accountant'],1);?> name="project_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['project']['manager'],1);?> name="project_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Recruitment','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['requirements']['employee'],1);?> name="requirements_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['requirements']['accountant'],1);?> name="requirements_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['requirements']['manager'],1);?> name="requirements_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Event','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['event']['employee'],1);?> name="event_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['event']['accountant'],1);?>  name="event_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['event']['manager'],1);?> name="event_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Travel','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" <?php echo checked($access_right['travel']['employee'],1);?> value="1" name="travel_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['travel']['accountant'],1);?> name="travel_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['travel']['manager'],1);?> name="travel_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Notice','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" <?php echo checked($access_right['notice']['employee'],1);?> value="1" name="notice_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['notice']['accountant'],1);?> name="notice_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['notice']['manager'],1);?> name="notice_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>	
		
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Employee Feedback','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['employee_feedback']['employee'],1);?> name="employee_feedback_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['employee_feedback']['accountant'],1);?> name="employee_feedback_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['employee_feedback']['manager'],1);?> name="employee_feedback_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
				
				
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Client Feedback','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['client_feedback']['employee'],1);?> name="client_feedback_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['client_feedback']['accountant'],1);?> name="client_feedback_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['client_feedback']['manager'],1);?> name="client_feedback_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
				
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Message','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['message']['employee'],1);?> name="message_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['message']['accountant'],1);?> name="message_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['message']['manager'],1);?> name="message_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>	
		
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Report','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['report']['employee'],1);?> name="report_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['report']['accountant'],1);?> name="report_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['report']['manager'],1);?> name="report_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Skill matrix','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['skill_metrix']['employee'],1);?> name="skill_metrix_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['skill_metrix']['accountant'],1);?> name="skill_metrix_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['skill_metrix']['manager'],1);?> name="skill_metrix_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('Mail Template','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['mail_template']['employee'],1);?> name="mail_template_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['mail_template']['accountant'],1);?> name="mail_template_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['mail_template']['manager'],1);?> name="mail_template_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>
		
		
		
		
		<div class="row">
			<div class="col-md-3">
				<span class="menu-label">
					<?php _e('General','hr_mgt');?>
				</span>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['genral']['employee'],1);?> name="genral_employee" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['genral']['accountant'],1);?> name="genral_accountant" readonly>	              
					</label>
				</div>
			</div>
			<div class="col-md-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" <?php echo checked($access_right['genral']['manager'],1);?> name="genral_manager" readonly>	              
					</label>
				</div>
			</div>
		</div>		
		<div class="col-sm-offset-4 col-sm-8 row_bottom">
			<input type="submit" value="<?php _e('Save', 'school-mgt' ); ?>" name="save_access_right" class="btn btn-success"/>
		</div>		
		</div>
		</form>		
		<?php } ?>
			</div>			
		</div>
	</div>
</div>
</div>