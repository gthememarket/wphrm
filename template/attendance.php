<?php 
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'attendance_list';
$obj_attendance=new HrmgtAttendance;
$role=hrmgt_get_user_role(get_current_user_id() );

?>
<style>
.our{
	color:white !important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#attendance_list').DataTable({
		"order": [[ 0, "asc" ]],
		"responsive": true,
		"aoColumns":[
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": false}]
		});		
		jQuery('#absent_list').DataTable({
			"responsive": true,
		});		
} );
</script>
<script type="text/javascript">
$(document).ready(function() {
 $('#sdate').datepicker({
	dateFormat: "yy-mm-dd",
	changeMonth: true,
	changeYear: true,
	maxDate:0,
	yearRange:'-65:+0',
 });
} );
</script>
<?php
if(isset($_POST['save_attendance']))
{	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_attendance->hrmgt_add_attendance($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=attendance&tab=attendance_list&message=2');
		}
	}
	else
	{
		$result=$obj_attendance->hrmgt_add_attendance($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=attendance&tab=attendance_list&message=1');
		}
	}
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete'){
	$result=$obj_attendance->hrmgt_delete_attendancet($_REQUEST['attendance_id']);
	if($result)	{
		wp_redirect ('?hr-dashboard=user&page=attendance&tab=attendance_list&message=3');
	}
}
if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == 1){ ?>
		<div id="message" class="updated below-h2 msg "><p>	<?php _e('Attendance insert successfully','hr_mgt');?></p></div>
	<?php }
	elseif($message == 2){ ?>
		<div id="message" class="updated below-h2 msg "><p><?php _e("Attendance update successfully.",'hr_mgt');?></p></div>
	<?php }	elseif($message == 3) { ?>
		<div id="message" class="updated below-h2 msg "><p>	<?php 	_e('Attendance delete successfully','hr_mgt');?></div>
	<?php }  elseif($message == 4) { ?>
		<div id="message" class="updated below-h2"><p><?php	_e('Attendance Already Taken','hr_mgt'); ?></div></p>
	<?php } } ?>
<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">
    <li class="<?php if($active_tab == 'attendance_list') echo "active";?>">
        <a href="?hr-dashboard=user&page=attendance&tab=attendance_list">
            <i class="fa fa-align-justify"></i> <?php _e('Attendance', 'hr_mgt'); ?>
		</a>        
    </li>
	  
	<?php if($role=="manager"){ ?>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){ ?>
		<li class="<?php if($active_tab == 'add_attendance') echo "active";?>">
			<a href="?hr-dashboard=user&page=attendance&tab=add_attendance">
				 </i> <?php _e('Edit Attendance', 'hr_mgt'); ?>
			</a>          
		</li>
		<?php } else { ?>
		<li class="<?php if($active_tab == 'add_attendance') echo "active";?>">
			<a href="?hr-dashboard=user&page=attendance&tab=add_attendance">
				 <i class="fa fa-plus-circle"></i> <?php _e('Add Attendance', 'hr_mgt'); ?>
			</a>          
		</li>			
		<?php }?>
	  
	  <li class="<?php if($active_tab == 'view_attendance') echo "active";?>">
        <a href="?hr-dashboard=user&page=attendance&tab=view_attendance ">
            <i class="fa fa-eye"></i> <?php _e('View Attendance', 'hr_mgt'); ?>
		</a>          
      </li>
	  <?php } ?> 
		
	  <li class="<?php if($active_tab == 'monthaly_attendance') echo "active";?>">
         <a href="?hr-dashboard=user&page=attendance&tab=monthaly_attendance ">
             <i class="fa fa-eye"></i> <?php _e('Monthly Attendance', 'hr_mgt'); ?>
		</a>          
      </li>
	
	  <?php if($active_tab=="add_attendance_detail"){ ?>
	<li class="<?php if($active_tab == 'add_attendance_detail') echo "active";?>">
          <a href="#">
            <?php _e('Edit Monthly Attendance', 'hr_mgt'); ?>
		</a>         
	</li>
	  <?php } if($active_tab=='approve_payslip'){ ?>	  
	  <li class="<?php if($active_tab == 'approve_payslip') echo "active";?>">
         <a href="?hr-dashboard=user&page=attendance&tab=approve_payslip "><?php _e('Approve Payslip', 'hr_mgt'); ?></a>          
      </li>
	  <?php } ?>	  
</ul>
	<div class="tab-content">
    	<?php if($active_tab == 'attendance_list'){  ?>		
			<form method="post" class="form-inline" id="filter_attendance_form" style="float:left;width:100%"> 
	<div class="col-md-12">
		 <div class="form-group col-md-3 date-field" style="padding: 21px 0px 0px;">
			<label for="exam_id"><?php _e('Date','hr_mgt');?></label>
				<input type="text"  id="sdate" class="form-control" name="curr_date" value="<?php if(isset($_REQUEST['curr_date'])) echo $_REQUEST['curr_date'];else echo date('Y-m-d');?>">
		 </div>
		 <?php if($role == 'manager'){ ?>
		  <div class="form-group col-md-3 date-field" style="padding: 21px 0px 0px;">
			<label for="exam_id"><?php _e('Status','hr_mgt');?></label>
				<select name="status" class="form-control" style="width:75%">
				<?php 
					if(isset($_POST['status']) && $_POST['status']=='absent')
					{
						$status = $_POST['status'];
					}
					else
					{
						$status = $_present;
					}
					?>
					<option value="present" <?php selected('present',$status) ?>><?php _e('Present','hr_mgt'); ?></option>
					<option value="absent"  <?php selected('absent',$status) ?> ><?php _e('Absent','hr_mgt'); ?></option>
				</select>
		 </div>
		 <?php } ?>
		 <div class="form-group col-md-2 button-possition">
			<label for="">&nbsp;</label>
			<input type="submit" value="<?php _e('Go','hr_mgt');?>" name="filter_attendance"  class="btn btn-info"/>
		</div>
    </div>   
 </form>
<?php // }
	if(isset($_REQUEST['filter_attendance']) ) {
		$AttData['attendance_date']=$_REQUEST['curr_date'];
		$AttData['status']=isset($_REQUEST['status']) ? $_REQUEST['status']:'present';		
	}	
	else {
		$AttData['attendance_date']=date('Y-m-d');
		$AttData['status']="present";			
	}
		
?>		
	<div class="panel-body" style="float: left; width: 100%;" >
    <div class="table-responsive">
    <?php if($AttData['status']=='present'){ ?> 
		<table id="attendance_list" class="table table-striped table-hover " cellspacing="0" width="100%">
        	 <thead>
            <tr>
				<th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Attendance Date', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'SignIn Time', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'SignOut Time', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Lunch Start Time', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Lunch End Time', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Working Hours', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Day Status', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Lunch Hours', 'hr_mgt' ) ;?></th>
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			   <th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
               <th><?php _e( 'Attendance Date', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'SignIn Time', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'SignOut Time', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Lunch Start Time', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Lunch End Time', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Working Hours', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Day Status', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Lunch Hours', 'hr_mgt' ) ;?></th>
			   <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>           
        </tfoot> 
        <tbody>
        <?php 
		$attendance	  = array();
		$todaypresent = array();
		$attendancedata =$obj_attendance->get_all_attendance($AttData);
		//$todaypresent = $obj_attendance->get_all_currat_day_attendance(date("Y-m-d"),'adminstator');
		
		
		 $attendance_day = date('j',strtotime($AttData['attendance_date']));		
		 $attendance_month = date('M',strtotime($AttData['attendance_date']));
		 $attendance_year = date('Y',strtotime($AttData['attendance_date']));		 	
		if(!empty($attendancedata))
		{				
		    $working_hours = strtotime(get_option('full_working_hour'));			
			$HalfDayHours = strtotime(get_option('half_working_hour'));				
		 	foreach ($attendancedata as $retrieved_data)
			{
				$TodayWorkHour = strtotime($retrieved_data->working_hours);				
			?>
			<tr>
				<?php 
				if($role=="manager"){ ?>
					<td class="Employee"><a href="?hr-dashboard=user&page=attendance&tab=view_attendance&emp_id=<?php echo $retrieved_data->employee_id;?>"><?php echo hrmgt_get_display_name($retrieved_data->employee_id);?></a></td>
				<?php }else{ ?>
					<td class="Employee"><?php echo hrmgt_get_display_name($retrieved_data->employee_id);?></td>
				<?php }	?>
				<td class="Attendance date"><?php echo hrmgt_change_dateformat($retrieved_data->attendance_date);?></td>
				<td class="Signin"><?php echo $retrieved_data->signin_time;?></td>
				<td class="Signout"><?php echo $retrieved_data->signout_time;?></td>
				<td class="lunchstart"><?php echo $retrieved_data->lunch_start_time;?></td>
				<td class="lunchend"><?php echo $retrieved_data->lunch_end_time;?></td>
				
				<?php			
				if($retrieved_data->signout_time !='')
				{					
					if( $working_hours <= $TodayWorkHour)
					{						
						$Hours = $retrieved_data->working_hours;
						$class="bg-success";
						$status = "Full Day";
					} 
					elseif($working_hours > $TodayWorkHour && $HalfDayHours < $TodayWorkHour)
					{
						$Hours = $retrieved_data->working_hours;
						$class="bg-warning";
						$status = "Half Day";
					}
					elseif($working_hours > $TodayWorkHour && $HalfDayHours > $TodayWorkHour)
					{
						$Hours = $retrieved_data->working_hours;
						$class="bg-danger";
						$status = "Absent";
					}					
				} 
				else
				{									
					//date_default_timezone_set('Asia/Calcutta');
					$totaltime = hrmgt_get_time_difference($retrieved_data->signin_time,date('H:i:s'));									
					$lunch = hrmgt_get_time_difference($retrieved_data->lunch_start_time,$retrieved_data->lunch_end_time);					
					$Hours ="";//hrmgt_get_working_hours($totaltime,$lunch);
					$class="bg-success";
					$status = "Present";
				}
				?>
				<td class="working our <?php print $class ?>"><?php print $Hours; ?></td>
				<td class="working "><?php print $status ?></td>
				
				<td class="lunch hour"><?php echo $retrieved_data->lunch_hourse;?></td>	
				
			
               <td class="action">
			   <?php if($role=="manager"){ ?>				
					<a href="?hr-dashboard=user&page=attendance&tab=add_attendance&action=edit&attendance_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
					<a href="?hr-dashboard=user&page=attendance&tab=attendance_list&action=delete&attendance_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
					onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
					<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>                 
			   <?php } ?>
				</td>
            </tr>      
            <?php } 			
		} ?>
		</tbody>
        </table>
		<?php  }  if($AttData['status']=='absent'){ ?>
		<table id="absent_list" class="display" cellspacing="0" width="100%">
         <thead>
            <tr>
			   <th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Designation ', 'hr_mgt' ) ;?></th>
               <th><?php _e( 'Email', 'hr_mgt' ) ;?></th>	   
               <th><?php _e( 'Department', 'hr_mgt' ) ;?></th>	   
            </tr>
         </thead>	
		  <tfoot>
            <tr>
			   <th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Designation ', 'hr_mgt' ) ;?></th>
               <th><?php _e( 'Email', 'hr_mgt' ) ;?></th>	   
               <th><?php _e( 'Department', 'hr_mgt' ) ;?></th>	   
            </tr>
         </tfoot>
		 <tbody>
			<?php 
			$AbsentData=$obj_attendance->get_all_attendance($AttData);
			if($AbsentData){
				foreach($AbsentData as $key=>$retrieved_data){ 
				$userdata = get_userdata($retrieved_data)
				?> 
				<tr>
					<td><?php print hrmgt_get_display_name($retrieved_data) ?></td>
					<td><?php print get_the_title($userdata->designation); ?></td>					
					<td><?php print $userdata->user_email; ?></td>					
					<td><?php print hrmgt_get_department_name(get_user_meta($retrieved_data,'department',true)); ?></td>		
				</tr>
			
			<?php }
			}
		?>
		 </tbody>

		</table>
		<?php } ?>
        </div>
        </div>
		<?php } ?>	
		<?php if($active_tab=="add_attendance"){ 
			require_once  HRMS_PLUGIN_DIR.'/template/attendance/add_attendance.php';
		} ?>
		<?php if($active_tab=="view_attendance"){ 
			require_once  HRMS_PLUGIN_DIR.'/template/attendance/view_attendance.php';
		} if($active_tab=="monthaly_attendance"){
			require_once  HRMS_PLUGIN_DIR.'/template/attendance/monthaly_attendance.php';
		} if($active_tab=="add_attendance_detail"){
			require_once  HRMS_PLUGIN_DIR.'/template/attendance/add_attendance_detail.php';
		}
		if($active_tab=="approve_payslip"){
			require_once  HRMS_PLUGIN_DIR.'/template/attendance/approve_payslip.php';
		}	?>
	</div>
</div>