<script>
$(document).ready(function(){
	$("body").on("click","#exprience_latter",function(){
		$("#submit_data").submit();
		var department_name = $("input[name='department_name']").val();
		var employee_name1 = $("input[name='employee_name1']").val();
		var join_date = $("input[name='join_date']").val();
		var leave_date = $("input[name='leave_date']").val();
		var employee_name = $("input[name='employee_name']").val();
		var join_date = $("input[name='join_date']").val();	
	});
}); 
</script>
<?php
if(isset($_REQUEST['tab']) && $_REQUEST['tab']=="view_employee"){ ?>
<?php
	$user_id = $_REQUEST['employee_id'];
	
	$empdata = get_userdata($user_id);
	
	$empmetadata = get_user_meta($user_id);	
	
	$emp_gender = get_user_meta($user_id,'gender',true);
	$emp_dob = get_user_meta($user_id,'birth_date',true);
	$emp_marital = get_user_meta($user_id,'marital_status',true);
	$hrmgt_user_avatar = get_user_meta($user_id,'hrmgt_user_avatar',true);
	$mobile = get_user_meta($user_id,'mobile',true);
	$joining_date = get_user_meta($user_id,'joining_date',true);
	$salary = get_user_meta($user_id,'employee_salary',true);
	$qualification = get_user_meta($user_id,'qualification',true);
	$address = get_user_meta($user_id,'address',true).", <br>" .get_user_meta($user_id,'city_name',true);
	$designation = get_the_title(get_user_meta($user_id,'designation',true))?>

<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list">  </div>
		</div>
    </div> 
</div>



	<div class="panel-body">
	<div class="member_view_row1">
	<div class="col-md-8 membr_left">
		<div class="col-md-6 left_side">
			<?php if(!empty($hrmgt_user_avatar)){ ?>
				<img  class="img-responsive" alt="Pro" src="<?php print $hrmgt_user_avatar ?>" class="img-responsive">
			<?php }else{ ?> 
				<img  class="img-responsive" alt="Pro" src="<?php print get_option('hrmgt_system_logo'); ?>" class="img-responsive">
			<?php  }?>
			
		</div>
		<div class="col-md-6 right_side">
			<table class="table">
				<tbody>
					<tr>
						<th scope="row"><i class="fa fa-user"></i><?php _e('Name','hrmgt');?></th>
						<td scope="row"><span class="txt_color"><?php _e($empdata->display_name,'hrmgt');?> </span></td>
					</tr>					
					<tr>
						<th scope="row"><i class="fa fa-envelope"></i> <?php _e('Email','hrmgt');?> </th>
						<td scope="row"><span class="txt_color"><?php _e($empdata->user_email,'hrmgt');?> </span></span></td>
					</tr>
					<tr>
						<th scope="row"><i class="fa fa-phone"></i> <?php _e('Mobile No','hrmgt');?></th>
						<td scope="row"><span class="txt_color"> <?php _e($mobile,'hrmgt');?> </span></td>
					</tr>
					<tr>
						<th scope="row"><i class="fa fa-birthday-cake"></i><?php _e('Date Of Birth','hrmgt');?>  </th>
						<td scope="row"><span class="txt_color"><?php print hrmgt_change_dateformat($emp_dob);?></span></td>
					</tr>
					<tr>
						<th scope="row"><i class="fa fa-mars"></i> <?php _e('Gender','hrmgt');?> </th>
						<td scope="row"><span class="txt_color"><?php  _e($emp_gender,'hrmgt');?></span></td>
					</tr>					
					<tr>
						<th scope="row"><i class="fa fa-user"></i> <?php _e('User Name','hrmgt');?>  </th>
						<td scope="row"><span class="txt_color"><?php _e($empdata->user_login,'hrmgt');?> </span></td>
					</tr>
					<tr>
						<td><a href="admin.php?page=hrmgt-user&tab=add_user&user_type=employee&action=edit&id=<?php  print $user_id; ?>" class="btn btn-primary"> <?php _e(' Edit Experience Letter','hrmgt') ?></a></td>
						<td><a href="#" class="btn btn-primary experience_letter" id="<?php  print $user_id; ?>"> <?php _e(' View Experience Letter','hrmgt') ?></a></td>
					</tr>
					
					
						
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-4 member_right">	
			<span class="report_title">
				<span class="fa-stack cutomcircle">
					<i class="fa fa-align-left fa-stack-1x"></i>
				</span> 
				<span class="shiptitle"><?php _e('More Info','hrmgt'); ?></span>	
			</span>
			<table class="table">
				<tbody>						
					<tr>
						<th scope="row"><i class="fa fa-graduation-cap"></i> <?php _e('Education','hrmgt') ?> </th>
						<td scope="row"><span class="txt_color"><?php print isset($qualification)?$qualification:''?></span></td>
					</tr>				
					<tr>
						<th scope="row"><i class="fa fa-map-marker"></i> <?php _e('Address','hrmgt') ?>  </th>
						<td scope="row"><span class="txt_color"><?php print isset($address)?$address:''  ?> </span></td>
					</tr>					
					<tr>
						<th scope="row"><i class="fa fa-calendar-o"></i> <?php _e('Join Date','hrmgt') ?>  </th>
						<td scope="row"><span class="txt_color"><?php print isset($joining_date)?hrmgt_change_dateformat($joining_date):''  ?> </span></td>
					</tr>
					<tr>
						<th scope="row"><i class="fa fa-money"></i> <?php _e('Salary','hrmgt') ?>  </th>
						<td scope="row"><span class="txt_color"><?php print isset($salary)?$salary:''  ?> </span></td>
					</tr>
					
					<tr>
						<th scope="row"><i class="fa fa-calendar"></i> <?php _e('Working Since','hrmgt') ?>  </th>
						<td scope="row"><span class="txt_color"><?php  print hrmgt_get_date_diff($joining_date,date("y-m-d"));	?> </span></td>
					</tr>
					
					<tr>
						<th scope="row"><i class="fa fa-calendar"></i> <?php _e('Department','hrmgt') ?>  </th>
						<td scope="row"><span class="txt_color"><?php print hrmgt_get_department_name(get_user_meta($user_id,'department',true));?> </span></td>
					</tr>
					<?php if($designation){?>
					<tr>
						<th scope="row"><i class="fa fa-calendar"></i> <?php _e('Designation','hrmgt') ?>  </th>
						<td scope="row"><span class="txt_color"><?php print $designation;?> </span></td>
					</tr>					
					<?php } ?>
					
					
					
					
					
					
					
					
				</tbody>
			</table>
	</div>
	
	</div>
	<div class="clear"></div>
	<br>
	<div class="col-md-12 border">
		<span class="report_title">
			<span class="fa-stack cutomcircle">
				<i class="fa fa-line-chart fa-stack-1x"></i>
			</span> 
			<span class="shiptitle"><?php _e('Employee Attendance ','hrmgt');?></span>		
		</span>
	</div>
	<div class="col-md-12">
		<?php 		
		$chart_array = hrmgt_employee_attendance_report($user_id);
		if(isset($chart_array) && count($chart_array) >1){				
		?>
		  
		<div id="attend_chart_div" style="width: 100%; height:350px;"></div>
		<?php }
 elseif(isset($chart_array)) {?>
  <div class="clear col-md-12"><?php _e("There is not enough data to generate report.",'hrmgt');?></div>
  <?php }?>
	</div>
	</div>
	
<?php } ?>
	</div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawColColors);
	function drawColColors() {
		var data_col = google.visualization.arrayToDataTable(<?php echo json_encode($chart_array); ?>);	
		var options_col = {
			title: '',
			colors: ['green', 'red']
		};
		var chart_col = new google.visualization.ColumnChart(document.getElementById('attend_chart_div'));
		chart_col.draw(data_col, options_col);
   }   
</script>