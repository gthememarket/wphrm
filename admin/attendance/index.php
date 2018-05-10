<?php 
$obj_attendance=new HrmgtAttendance;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'attendance_list';

?>

<div class="page-inner" style="min-height:1088px !important">
<div class="page-title">
	<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?>
	</h3>
</div>
<?php 
	if(isset($_POST['save_attendance']))
	{	
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{		
			$result=$obj_attendance->hrmgt_add_attendance($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-attendance&tab=attendance_list&message=2');
			}
		}
		else
		{			
			$result=$obj_attendance->hrmgt_add_attendance($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-attendance&tab=attendance_list&message=1');
			}
		}
	}
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{
		$result=$obj_attendance->hrmgt_delete_attendancet($_REQUEST['attendance_id']);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=hrmgt-attendance&tab=attendance_list&message=3');
		}
	}
	if(isset($_REQUEST['message']))
	{
		$message =$_REQUEST['message'];
		if($message == 1){ ?>
			<div id="message" class="updated below-h2 "><p><?php _e('Attendance insert successfully','hr_mgt');?></p></div>
		<?php
		} elseif($message == 2)	{?>
		<div id="message" class="updated below-h2 "><p><?php _e("Attendance update successfully.",'hr_mgt'); ?></p></div>
		<?php 
		} elseif($message == 3) { ?>
			<div id="message" class="updated below-h2"><p><?php	_e('Attendance delete successfully','hr_mgt'); ?></div></p>
		<?php } elseif($message == 4) { ?>
		<div id="message" class="updated below-h2"><p><?php	_e('Attendance Already Taken','hr_mgt'); ?></div></p>
	<?php } }  ?>
	
	<div id="main-wrapper">
	<div class="row">
	<div class="col-md-12">	
	<div class="panel panel-white">
	<div class="panel-body">
		<h2 class="nav-tab-wrapper">
			<a href="?page=hrmgt-attendance&tab=attendance_list" class="nav-tab <?php echo $active_tab == 'attendance_list' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Attendance List', 'hr_mgt'); ?></a>
			
			<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
			{ ?>
			<a href="?page=hrmgt-attendance&tab=add_attendance&action=edit&attendance_id=<?php echo $_REQUEST['attendance_id'];?>" class="nav-tab <?php echo $active_tab == 'add_attendance' ? 'nav-tab-active' : ''; ?>">
			<?php _e('Edit Attendance', 'hr_mgt'); ?></a>  
			<?php 
			}
			else 
			{ ?>
				<a href="?page=hrmgt-attendance&tab=add_attendance" class="nav-tab <?php echo $active_tab == 'add_attendance' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Attendance', 'hr_mgt'); ?></a>
			<?php  }?>
			
			<a href="?page=hrmgt-attendance&tab=view_attendance" class="nav-tab <?php echo $active_tab == 'view_attendance' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-menu"></span> '.__('View Attendance', 'hr_mgt'); ?></a>
			
			<a href="?page=hrmgt-attendance&tab=monthaly_attendance" class="nav-tab <?php echo $active_tab == 'monthaly_attendance' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Monthly Attendance', 'hr_mgt'); ?></a>
			
			<?php if($active_tab=="add_attendance_detail") { ?>
			<a href="#" class="nav-tab <?php echo $active_tab == 'add_attendance_detail' ? 'nav-tab-active' : ''; ?>">
			<?php _e('Edit Monthly Attendance', 'hr_mgt'); ?></a>							
			<?php } ?>
			<?php if($active_tab=='approve_payslip'){?>	
			<a href="?page=hrmgt-attendance&tab=approve_payslip" class="nav-tab <?php echo $active_tab == 'approve_payslip' ? 'nav-tab-active' : ''; ?>">
			<?php _e('Approve Payslip', 'hr_mgt'); ?></a>
			<?php } ?>
		</h2>
 <?php 
if($active_tab == 'attendance_list'){ ?>
	
<script type="text/javascript">

$(document).ready(function() {
var attendance_date = $('#sdate').val();
var table = $('#attendance_list').DataTable({
	 "bProcessing": true,
	 "bServerSide": true,
	 "sAjaxSource": ajaxurl+'?action=datatable_Present_attendance_ajax_load1&attendance_date='+attendance_date,
	 "bDeferRender": true,
	});
					
$('input[type="search"]').on( 'keyup change', function () {
  var searchValue = $(this).val();
    var fetch = table.search(searchValue).draw();
	if(fetch){
	table.search(searchValue).draw();
	}else{
	alert('Not Fetch');
	}
  });					
	jQuery('#absent_list').DataTable();
   $('#sdate').datepicker({
	 dateFormat: "yy-mm-dd",
	changeMonth: true,
	  changeYear: true,
	  maxDate:0,
	  yearRange:'-65:+0',
	}); 
} );
</script>
<style>
.our{
	color:white;
}
</style>
 <form method="post" class="form-inline" id="filter_attendance_form" style="float:left;width:100%"> 
	<div class="col-md-12">
		 <div class="form-group col-md-3 date-field" style="padding: 21px 0px 0px;">
			<label for="exam_id"><?php _e('Date','hr_mgt');?></label>
			<input type="text"  id="sdate" class="form-control" name="curr_date" value="<?php if(isset($_REQUEST['curr_date'])) echo $_REQUEST['curr_date'];else echo date('Y-m-d');?>">
		 </div>
		  <div class="form-group col-md-3 date-field" style="padding: 21px 0px 0px;">
			<label for="exam_id"><?php _e('Status','hr_mgt');?></label>
				<select name="status" id ="status" class="form-control" style="width:75%">
				<?php 
					if(isset($_POST['status']) && $_POST['status']=='absent'){
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
		 <div class="form-group col-md-2 button-possition">
			<label for="">&nbsp;</label>
			<input type="submit" value="<?php _e('Go','hr_mgt');?>" id="filter_attendance" name="filter_attendance"  class="btn btn-info"/>
		</div>
    </div>   
 </form>
</div>
	<?php  
		if(isset($_REQUEST['filter_attendance']) ) 
		{
			$AttData['attendance_date']=$_REQUEST['curr_date'];
			$AttData['status']=$_REQUEST['status'];		
		}	
		else
		{
			$AttData['attendance_date']=date('Y-m-d');
			$AttData['status']="present";			
		}
	?>


    <form name="activity_form" action="" method="post">    
        <div class="panel-body">

        	<div class="table-responsive">
		<?php if($AttData['status']=='present'){ ?> 
	<table id="attendance_list" class="table table-striped table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
			   <th></th>
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
			 <th></th>
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
    </table>
	<p>
	<mark class="bg-success" style='height:10px;width:30px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</mark> : Present  &nbsp;&nbsp;&nbsp;&nbsp;
	<mark class="bg-danger" style='height:10px;width:30px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</mark> : Absent &nbsp;&nbsp;&nbsp;&nbsp;
	<mark class="bg-warning" style='height:10px;width:30px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</mark> : Half Day
	</p>
	<?php  } 
		if($AttData['status']=='absent'){ ?>
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
			if($AbsentData)
			{
				foreach($AbsentData as $key=>$retrieved_data)
				{ 
				$userdata = get_userdata($retrieved_data)
				?> 
				<tr>
					<td><?php print hrmgt_get_display_name($retrieved_data) ?></td>
					<td><?php print get_the_title($userdata->designation); ?></td>					
					<td><?php print $userdata->user_email; ?></td>					
					<td>
					<?php
						if(get_user_meta($retrieved_data,'department',true)!="")
						{
							print hrmgt_get_department_name(get_user_meta($retrieved_data,'department',true)); 
						}						
					?>
					</td>	
				</tr>			
			   <?php
			   }
			}
		?>
		 </tbody>
		</table>
		<?php } ?>
        </div>
        </div>
</form>
<?php  }
	else{
		if(isset($active_tab)){
			require_once HRMS_PLUGIN_DIR.'/admin/attendance/'.$active_tab.'.php';
		 }
	}  ?>
</div>
</div>
</div>
</div>

