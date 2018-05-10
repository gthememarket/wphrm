<?php 
$obj_HrmgtAttendanceDetails=new HrmgtAttendanceDetails;
if($active_tab == 'monthaly_attendance'){ ?>	
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#monthaly_attendance').DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[
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
} );
</script>
<script type="text/javascript">
$(document).ready(function() {
 $('#date').datepicker({
	dateFormat: "yy-mm-dd",
	changeMonth: true,
	changeYear: true,
	dateFormat: 'mm-yy',
	yearRange:'-10:+10',
	       
}); 
} );
</script>
<form class="form-inline" style="margin-top:20px" method="post">		
	<div class="form-group">
		<label class="col-sm-4 control-label" for="employee_id" style="margin-top:8px"><?php _e('Employee','hr_mgt');?></label>
		<div class="col-sm-8">
			<select class="form-control validate[required]" name="employee_id" style="width:100">
				<option value="All"><?php _e('All Employee','hr_mgt');?></option>
				<?php 				
				$employee =0;
				if(isset($_POST['employee_id']))
				{
					$employee = $_POST['employee_id'];
				}
				
				$employeedata=hrmgt_get_working_user('employee');
				if(!empty($employeedata))
				{
					foreach ($employeedata as $retrive_data)
					{
						echo '<option value="'.$retrive_data->ID.'" '.selected($employee,$retrive_data->ID).'>'.$retrive_data->display_name.'</option>';
					}
				} ?>
			</select>
		</div>
	</div>
		
	<div class="form-group ">
		<label for="date" class="col-sm-4" style="margin-top:8px"><?php _e('Select Date','hr_mgt'); ?></label>
		<div class="col-sm-8">
		<input type="text" class="form-control" name="report_date"  id="date" value="<?php if (isset($_POST['report_date'])) echo $_POST['report_date']; else print date('m-Y');  ?>">
	    </div>   
	</div>	
	
	<input type="submit"  name="get_att_report" class="btn btn-primary" value="GO">
</form>
<?php
if(isset($_POST['get_att_report']))
{
	$fatch['date'] = $_POST['report_date'];
	$fatch['employee_id'] = $_POST['employee_id'];
	$AttendanceDetailsData=$obj_HrmgtAttendanceDetails->get_date_wise_attendance_deatail($fatch);
}
else
{	$fatch['date'] = date('m-Y');
	$AttendanceDetailsData=$obj_HrmgtAttendanceDetails->get_date_wise_attendance_deatail($fatch);
}

?>

<div class="panel-body">
<div class="table-responsive">	
  <table id="monthaly_attendance" class="display" cellspacing="0" width="100%">
     <thead>
        <tr>
			<th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
			<th><?php _e( 'Designation ', 'hr_mgt' ) ;?></th>			  
			<th><?php _e( 'Date ', 'hr_mgt' ) ;?></th>			  
            <th><?php _e( 'Total Holiday', 'hr_mgt' ) ;?></th>
			<th><?php _e( 'Total Present', 'hr_mgt' ) ;?></th>
			<th><?php _e( 'Total Absent', 'hr_mgt' ) ;?></th>
			<th><?php _e( 'Total Half Days', 'hr_mgt' ) ;?></th>
			<th><?php _e( 'Payable Days', 'hr_mgt' ) ;?></th>			   
			<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
        </tr>
    </thead>
	<tfoot>
      <tr>
		 <th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
		 <th><?php _e( 'Designation ', 'hr_mgt' ) ;?></th>
		 <th><?php _e( 'Date ', 'hr_mgt' ) ;?></th>	
         <th><?php _e( 'Total Holiday', 'hr_mgt' ) ;?></th>
	     <th><?php _e( 'Total Present', 'hr_mgt' ) ;?></th>
		 <th><?php _e( 'Total Absent', 'hr_mgt' ) ;?></th>
		 <th><?php _e( 'Total Half Days', 'hr_mgt' ) ;?></th>
		 <th><?php _e( 'Payable Days', 'hr_mgt' ) ;?></th>			   
		 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
       </tr>
    </tfoot> 
	<tbody>   
		<?php 
			if(!empty($AttendanceDetailsData)){
				foreach($AttendanceDetailsData as $key=>$retrivedata){ 
				$countdata = get_monthly_total_attendace($retrivedata->employee_id,$retrivedata->month,$retrivedata->year);
		?>					       
					<tr>
						<td><?php print hrmgt_get_display_name($retrivedata->employee_id); ?></td>
						<td><?php print get_the_title( get_user_meta($retrivedata->employee_id,'designation',true)) ?></td>		
						<td><?php print date('F', mktime(0, 0, 0, $retrivedata->month, 10)).'-'.$retrivedata->year ;?></td>
						<td><?php print $retrivedata->tatal_holidy ;?></td>
						<td><?php print $retrivedata->tatal_present;?></td>
						<td><?php print $retrivedata->tatal_absent ;?></td>	
						<td><?php print $retrivedata->total_hl;?></td>						    
						<td><?php print $retrivedata->payable_days;?></td>				    
						<td><a href="?page=hrmgt-attendance&tab=add_attendance_detail&AttendanceDetails_id=<?php echo $retrivedata->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a></td>						    
					</tr>  
				<?php }
			}
		?>                
		</tbody>
   </table>  
  </div>
	<?php  $emplyee  =  isset($_POST['employee_id'])? $_POST['employee_id']:"All" ?>
  <a href="?page=hrmgt-attendance&tab=add_attendance_detail&emplyee=<?php print $emplyee ?>&date=<?php print $fatch['date'] ?> " class="btn btn-primary"> <?php _e('Edit All', 'hr_mgt' ) ;?></a>
</div>

<?php }  ?>

