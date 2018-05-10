<?php 		
$obj_leave=new HrmgtLeave;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'leave_list';
$to =array();
$arr = array();
?>
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>     
		</div>
    </div> 
</div>
<div class="page-inner" style="min-height:1088px !important">
<div class="page-title">
	<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?></h3>
</div>
<?php
if(isset($_POST['save_leave']))
{
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_leave->hrmgt_add_leave($_POST);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=hrmgt-leave&tab=leave_list&message=2');
		}
	}
	else
	{			
		$result=$obj_leave->hrmgt_add_leave($_POST);				
		if($result)
		{				
			wp_redirect ( admin_url().'admin.php?page=hrmgt-leave&tab=leave_list&message=1');
		}
	}
}

if(isset($_POST['approve_comment'])&& $_POST['approve_comment']=='Submit')
{
	$result=$obj_leave->hrmgt_approve_leave($_POST);	
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=hrmgt-leave&tab=leave_list&message=4');
	}
}

if(isset($_POST['reject_leave'])&& $_POST['reject_leave']=='Submit')
{	
	$result=$obj_leave->hrmgt_reject_leave($_POST);		
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=hrmgt-leave&tab=leave_list&message=5');
	}
}

	
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result=$obj_leave->hrmgt_delete_leave($_REQUEST['leave_id']);
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=hrmgt-leave&tab=leave_list&message=3');
	}
}
if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == 1){ ?>
		<div id="message" class="updated below-h2  "><p><?php _e('Leave inserted successfully','hr_mgt');	?></p></div>
	<?php 	}elseif($message == 2)	{?>
		<div id="message" class="updated below-h2 "><p><?php _e("Leave updated successfully.",'hr_mgt');?></p></div>
	<?php 	}elseif($message == 3) 	{ ?>
		<div id="message" class="updated below-h2"><p><?php _e('Leave deleted successfully','hr_mgt');?></div></p>
	<?php }  elseif($message == 4) { ?>
		<div id="message" class="updated below-h2"><p><?php _e('Leave Approved successfully','hr_mgt');	?></div></p>
	<?php }
	 elseif($message == 5){ ?>
		<div id="message" class="updated below-h2"><p><?php _e('Leave Reject successfully','hr_mgt');	?></div></p>
	<?php }
} ?>
<div class="row">
<div class="col-md-12">
<div class="panel panel-white">
<div class="panel-body">
	<h2 class="nav-tab-wrapper">
    	<a href="?page=hrmgt-leave&tab=leave_list" class="nav-tab <?php echo $active_tab == 'leave_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Leave List', 'hr_mgt'); ?></a>
    	
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{ ?>
        <a href="?page=hrmgt-leave&tab=add_leave&action=edit&leave_id=<?php echo $_REQUEST['leave_id'];?>" class="nav-tab <?php echo $active_tab == 'add_leave' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Leave', 'hr_mgt'); ?></a>  
		<?php 
		}
		else 
		{ ?>
			<a href="?page=hrmgt-leave&tab=add_leave" class="nav-tab <?php echo $active_tab == 'add_leave' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Leave', 'hr_mgt'); ?></a>
		<?php  }?>
    </h2>
<?php 
if($active_tab == 'leave_list')
{ ?>
<script type="text/javascript">
$(document).ready(function() {	
	var employee = $('#employee').val();
	jQuery('#leave_filter').validationEngine();
	jQuery('#leave_list').DataTable({
		"bProcessing": true,
		 "bServerSide": true,
		 "sAjaxSource": ajaxurl+'?action=datatable_employee_leave_ajax_to_load&employee='+employee,
		 "bDeferRender": true,
	});
} );
</script> 
<div class="panel-body">
<form name="leave_filter" action="" class="form-inline" method="post">
<div class="form-group">
    <label for="email"><?php _e('Select Employee','hr_mgt')?></label>
</div>
<select class="form-control" id="employee" name="employee_id">
<option value="0"><?php _e('Select Employee','hr_mgt');?></option>
<?php
	$emp_id=0;
	if(isset($_POST['employee_id']))
	{
		$emp_id = $_POST['employee_id'];
	}
	$employeedate = hrmgt_get_working_user('employee');	
	foreach($employeedate as $employee)
	{ ?>	
	<option value="<?php print $employee->ID ?>" <?php selected($employee->ID,$emp_id) ?>><?php  print hrmgt_get_display_name($employee->ID); ?></option>
<?php } ?>
</select>
<input type="submit" name="get_leave" value="Get Leave" class="btn btn-info">
</form> 
<br>
  	<div class="table-responsive">
        <table id="leave_list" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><?php _e( 'Leave ID', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Leave Type', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Leave Duration', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Leave Start Date', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Leave End Date', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Reason', 'hr_mgt' ) ;?></th>
					<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><?php _e( 'Leave ID', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Leave Type', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Leave Duration', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Leave Start Date', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Leave End Date', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Reason', 'hr_mgt' ) ;?></th>
					<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
				</tr>           
			</tfoot> 
	  </table>
    </div>
</div>

<?php }
if($active_tab == 'add_leave')
{
	require_once HRMS_PLUGIN_DIR.'/admin/leave/add_leave.php';
}
?>
</div>
</div>
</div>
</div>
