<?php 
add_action( 'admin_menu', 'apartment_system_menu' );
function apartment_system_menu()
{
	add_menu_page('WP HRM', __('WP HRM','hr_mgt'),'manage_options','hrmgt-hr_system','hr_system_dashboard',plugins_url('wphrm/assets/images/hr-managemt-3.png' )); 
	
	
	if($_SESSION['hrmgt_verify'] == ''){ 
		add_submenu_page('hrmgt-hr_system','Licence Settings','Licence Settings','manage_options','hrmgt-setup','hrmgt_options_page');
	 }
	 
	add_submenu_page('hrmgt-hr_system', 'Dashboard', __( 'Dashboard', 'hr_mgt' ), 'administrator', 'hrmgt-hr_system', 'hr_system_dashboard');
	
	add_submenu_page('hrmgt-hr_system', 'Department', __( 'Department', 'hr_mgt' ), 'administrator', 'hrmgt-department', 'hrmgt_department');
	add_submenu_page('hrmgt-hr_system', 'All User', __( 'All User', 'hr_mgt' ), 'administrator', 'hrmgt-user', 'hrmgt_user');
	add_submenu_page('hrmgt-hr_system', 'Attendance', __( 'Attendance', 'hr_mgt' ), 'administrator', 'hrmgt-attendance', 'hrmgt_attendance');
	
	add_submenu_page('hrmgt-hr_system', 'Paid Leave', __( 'Paid Leave', 'hr_mgt' ), 'administrator', 'hrmgt-pl', 'hrmgt_paid_leave');
	
	add_submenu_page('hrmgt-hr_system', 'Leave', __( 'Leave', 'hr_mgt' ), 'administrator', 'hrmgt-leave', 'hrmgt_leave');
	
	add_submenu_page('hrmgt-hr_system', 'Employee Training', __( 'Employee Training', 'hr_mgt' ), 'administrator', 'hrmgt-employee_training', 'hrmgt_employee_training');
	
	add_submenu_page('hrmgt-hr_system', 'Skill Matrix', __( 'Skill Matrix', 'hr_mgt' ), 'administrator', 'hrmgt-skill_matrix', 'hrmgt_skill_matrix');
	
	add_submenu_page('hrmgt-hr_system', 'Performance  Marks', __( 'Performance  Marks', 'hr_mgt' ), 'administrator', 'hrmgt-parfomance_marks', 'hrmgt_parfomance_marks');
	add_submenu_page('hrmgt-hr_system', 'Travel', __( 'Travel', 'hr_mgt' ), 'administrator', 'hrmgt-travel', 'hrmgt_travel');
	
	add_submenu_page('hrmgt-hr_system', 'Notice', __( 'Notice', 'hr_mgt' ), 'administrator', 'hrmgt-notice', 'hrmgt_notice');
	add_submenu_page('hrmgt-hr_system', 'Project', __( 'Project', 'hr_mgt' ), 'administrator', 'hrmgt-project', 'hrmgt_project');
	
	add_submenu_page('hrmgt-hr_system', 'Payslip', __( 'Payslip', 'hr_mgt' ), 'administrator', 'hrmgt-payslip', 'hrmgt_payslip');
	
	add_submenu_page('hrmgt-hr_system', 'Earning/Deduction', __( 'Earning/Deduction', 'hr_mgt' ), 'administrator', 'hrmgt-earning_deduction', 'hrmgt_earning_deduction');

	add_submenu_page('hrmgt-hr_system', 'Assets', __( 'Assets', 'hr_mgt' ), 'administrator', 'hrmgt-assets_benefit', 'hrmgt_assets_benefit');
	
	add_submenu_page('hrmgt-hr_system', 'Recruitment', __( 'Recruitment', 'hr_mgt' ), 'administrator', 'hrmgt-requirements', 'hrmgt_requirements');
	
	add_submenu_page('hrmgt-hr_system', 'Event', __( 'Event', 'hr_mgt' ), 'administrator', 'hrmgt-event', 'hrmgt_event');
	
	add_submenu_page('hrmgt-hr_system', 'Message', __( 'Message', 'hr_mgt' ), 'administrator', 'hrmgt-message', 'hrmgt_message');
	
	add_submenu_page('hrmgt-hr_system', 'Employee Feedback', __( 'Employee Feedback', 'hr_mgt' ), 'administrator', 'hrmgt-feedback', 'hrmgt_feedback');
	
	add_submenu_page('hrmgt-hr_system', 'Client Feedback', __( 'Client Feedback', 'hr_mgt' ), 'administrator', 'hrmgt-client-feedback', 'hrmgt_client_feedback');
	
	add_submenu_page('hrmgt-hr_system', 'Report', __( 'Report', 'hr_mgt' ), 'administrator', 'hrmgt-report', 'hrmgt_report');
	
	add_submenu_page('hrmgt-hr_system', 'Access Right', __( 'Access Right', 'hr_mgt' ), 'administrator', 'hrmgt-access-right', 'hrmgt_access_right');
	
	add_submenu_page('hrmgt-hr_system', 'Mail Template', __( 'Mail Template', 'hr_mgt' ), 'administrator', 'hrmgt-mail_template', 'hrmgt_mail_template');
	
	add_submenu_page('hrmgt-hr_system', 'General Setting', __( 'General Setting', 'hr_mgt' ), 'administrator', 'hrmgt-general_settings', 'hrmgt_general_settings_page');
	
	
}
function hr_system_dashboard()
{
	require_once HRMS_PLUGIN_DIR. '/admin/dasboard.php';
}

function hrmgt_user(){
	require_once HRMS_PLUGIN_DIR. '/admin/user/index.php';
}
function hrmgt_department(){
	require_once HRMS_PLUGIN_DIR. '/admin/department/index.php';
}
function hrmgt_hr_manager(){ 
	require_once HRMS_PLUGIN_DIR. '/admin/hr_manager/index.php';
}

function hrmgt_accountant(){
	require_once HRMS_PLUGIN_DIR. '/admin/accountant/index.php';
}
function hrmgt_employee()
{
	require_once HRMS_PLUGIN_DIR. '/admin/employee/index.php';
}
function hrmgt_attendance(){
	require_once HRMS_PLUGIN_DIR. '/admin/attendance/index.php';
}
function hrmgt_leave(){
	require_once HRMS_PLUGIN_DIR. '/admin/leave/index.php';
}
function hrmgt_client_feedback(){
	require_once HRMS_PLUGIN_DIR. '/admin/client-feedback/index.php';
}
function hrmgt_holidays(){
	require_once HRMS_PLUGIN_DIR. '/admin/holidays/index.php';
}
function hrmgt_office_management(){
	require_once HRMS_PLUGIN_DIR. '/admin/Office-management/index.php';
}
function hrmgt_company_policy(){
	require_once HRMS_PLUGIN_DIR. '/admin/company-policy/index.php';
}
function hrmgt_employee_training(){
	require_once HRMS_PLUGIN_DIR. '/admin/employee-training/index.php';
}
function hrmgt_skill_matrix(){
	require_once HRMS_PLUGIN_DIR. '/admin/skill_matrix/index.php';
}
function hrmgt_parfomance_marks(){
	require_once HRMS_PLUGIN_DIR. '/admin/parfomance-marks/index.php';
}
function hrmgt_file(){
	require_once HRMS_PLUGIN_DIR. '/admin/file/index.php';
}
function hrmgt_travel(){
	require_once HRMS_PLUGIN_DIR. '/admin/travel/index.php';
}
function hrmgt_organization(){
	require_once HRMS_PLUGIN_DIR. '/admin/organization/index.php';
}

function hrmgt_report(){
	require_once HRMS_PLUGIN_DIR. '/admin/report/index.php';
}
function hrmgt_compensation(){
	require_once HRMS_PLUGIN_DIR. '/admin/compensation/index.php';
}
function hrmgt_project(){
	require_once HRMS_PLUGIN_DIR. '/admin/project/index.php';
}
function hrmgt_paid_leave(){
	require_once HRMS_PLUGIN_DIR. '/admin/pl-mgt/index.php';
}
function hrmgt_payslip(){
	require_once HRMS_PLUGIN_DIR. '/admin/payslip/index.php';
}

function hrmgt_earning_deduction(){
	require_once HRMS_PLUGIN_DIR. '/admin/earning-deduction/index.php';
}

function hrmgt_assets_benefit(){
	require_once HRMS_PLUGIN_DIR. '/admin/assets-benefit/index.php';
}

function hrmgt_requirements(){
	require_once HRMS_PLUGIN_DIR. '/admin/requirements/index.php';
}
function hrmgt_event(){
	require_once HRMS_PLUGIN_DIR. '/admin/event/index.php';
}
function hrmgt_suggestion(){
	require_once HRMS_PLUGIN_DIR. '/admin/suggestion/index.php';
}
function hrmgt_message(){
	require_once HRMS_PLUGIN_DIR. '/admin/message/index.php';
}
function hrmgt_feedback(){
	require_once HRMS_PLUGIN_DIR. '/admin/employee_feedback/index.php';
}
function hrmgt_notice(){
	require_once HRMS_PLUGIN_DIR. '/admin/notice/index.php';
}

function hrmgt_general_settings_page(){
	require_once HRMS_PLUGIN_DIR. '/admin/general-settings/index.php';
} 
function hrmgt_mail_template(){
	require_once HRMS_PLUGIN_DIR. '/admin/mail_template/index.php';
} 
function hrmgt_access_right(){
	require_once HRMS_PLUGIN_DIR. '/admin/access/index.php';
}
function hrmgt_options_page(){
	require_once HRMS_PLUGIN_DIR. '/admin/setupform/index.php';
}
?>