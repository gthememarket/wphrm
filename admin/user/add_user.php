<?php $user_type=isset($_REQUEST['user_type'])?$_REQUEST['user_type']:'employee'; ?>
<div class="panel-body">		
	<div class="col-md-12" style="padding:30px 0">
<div class="" style="float:left">
   <a href="?page=hrmgt-user&tab=add_user&user_type=employee" class="btn btn-<?php if($user_type=="employee") print "info"; else print "primary"?>" ><?php _e('Add Employee','hr_mgt') ?></a>
   <a href="?page=hrmgt-user&tab=add_user&user_type=manager" class="btn btn-<?php if($user_type=="manager") print "info"; else print "primary"?>" ><?php _e('Add HR Manager','hr_mgt') ?></a>
   <a href="?page=hrmgt-user&tab=add_user&user_type=accountant" class="btn btn-<?php if($user_type=="accountant") print "info"; else print "primary"?>" ><?php _e('Add Accountant','hr_mgt') ?></a>    
</div>
</div>

<?php
if($user_type=="employee"){
	require_once HRMS_PLUGIN_DIR.'/admin/user/add_employee.php';
}
elseif($user_type=="manager"){
	require_once HRMS_PLUGIN_DIR.'/admin/user/add_hr.php';
}
else{
	require_once HRMS_PLUGIN_DIR.'/admin/user/add_accountant.php';
}
?></div>
