<script type="text/javascript">
$(document).ready(function() {
	$('#view_attendance').validationEngine();
	 $('#start_date').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+0',
			maxDate:0,
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
      }); 
	  $('#end_date').datepicker({
		  changeMonth: true,
		  dateFormat: 'yy-mm-dd',
	        changeYear: true,
	        yearRange:'-65:+0',
			maxDate:0,
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
      }); 
}); 
</script>
	
<div class="panel-body">
	
	<form name="view_attendance" action="" method="post" id="view_attendance">
		<div class="form-group col-md-3">
			<label for="class_id"><?php _e('Select Employee','hr_mgt');?><span class="require-field">*</span></label>		
			<select class="form-control validate[required]" name="emp_id">
				<option value=" "><?php _e('Select Employee','hr_mgt');?></option>
				<?php 
				if(isset($_REQUEST['emp_id']))
					$employee =$_REQUEST['emp_id'];						
					$employeedata=hrmgt_get_working_user('employee');	
					if(!empty($employeedata)){
						foreach ($employeedata as $retrive_data){ 
							echo '<option value="'.$retrive_data->ID.'" '.selected($employee,$retrive_data->ID).'>'.$retrive_data->display_name.'</option>';
						}
					} ?>
			</select>
		</div>	
		
		<div class="form-group col-md-3 button-possition">
			<label for="subject_id">&nbsp;</label>
			<input type="submit" name="view_attendance" Value="<?php _e('Go','hr_mgt');?>"  class="btn btn-info"/>
		</div>	
	</form>		
	<?php 
		if(isset($_REQUEST['emp_id']))
		{			
			$user_id = $_REQUEST['emp_id'];
			$attendancedata = $obj_attendance->hrmgt_get_attendance($user_id);			
	?>
		<table class="table col-md-12 table-responsive"">
			<tr>
				<th width="200px"><?php _e('Date','school-mgt');?></th>
				<th><?php _e('Day','school-mgt');?></th>
				<th><?php _e('Sign In','school-mgt');?></th>
				<th><?php _e('Sign Out','school-mgt');?></th>
				<th><?php _e('Lunch Start','school-mgt');?></th>
				<th><?php _e('Lunch End','school-mgt');?></th>
				<th><?php _e('Lunch Hour','school-mgt');?></th>
				<th><?php _e('Working Hour','school-mgt');?></th>
			</tr>
			<?php 
			if(!empty($attendancedata))
			{
				foreach($attendancedata as $attendace)
				{
					echo '<tr>';
					echo '<td>';
					echo hrmgt_change_dateformat($attendace->attendance_date);
					echo '</td>';						
							
					echo '<td>';
					echo date("D", strtotime($attendace->attendance_date));
					echo '</td>';
							
					echo '<td>';
					echo $attendace->signin_time;
					echo '</td>';
							
					echo '<td>';
					echo $attendace->signout_time;
					echo '</td>';
							
					echo '<td>';
					echo $attendace->lunch_start_time;
					echo '</td>';
							
					echo '<td>';
					echo $attendace->lunch_end_time;
					echo '</td>';
							
					echo '<td>';
					echo $attendace->lunch_hourse;
					echo '</td>';
							
					echo '<td>';
					echo $attendace->working_hours;
					echo '</td>';
					echo '</tr>';							
				}
			}
			else
			{
				echo '<td>';
				echo __("Records Not Found","hr_mgt");
				echo '</td>';
			} 
		?>
		</table>
<?php } ?>
</div>