<?php 		
$active_tab = isset($_GET['tab'])?$_GET['tab']:'department_report';
$obj_travel=new HrmgtTravel;
$obj_leave=new HrmgtLeave;
$obj_performance=new HrmgtParfomanceMark;
$obj_skill=new hrmgtSkillMetrix;
$obj_project=new HrmgtProject;
$obj_feedback=new HrmgtCientFeedBack; 
?>
<script>
$(document).ready(function(){
	$('#report_form').validationEngine();
});
</script>
 
<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?>
		</h3>
</div>

<div id="main-wrapper">
	<div class="row">
		<div class="col-md-12">		
			<div class="panel panel-white">				
				<div class="panel-body"> 
					<ul class="nav nav-tabs panel_tabs" role="tablist">
				<li class="<?php if($active_tab == 'department_report') echo "active";?>">
				  <a href="?hr-dashboard=user&page=hrmgt-report&tab=department_report">
					 <i class="fa fa-align-justify"></i> <?php _e('Department Report', 'hr_mgt'); ?></a>
				  </a>
				</li>
				
				<li class="<?php if($active_tab == 'payslip_report') echo "active";?>">
				  <a href="?hr-dashboard=user&page=hrmgt-report&tab=payslip_report">
					 <i class="fa fa-align-justify"></i> <?php _e('Payslip Report', 'hr_mgt'); ?></a>
				  </a>
				</li>
				<li class="<?php if($active_tab == 'month_report') echo "active";?>">
				  <a href="?hr-dashboard=user&page=hrmgt-report&tab=month_report">
					 <i class="fa fa-align-justify"></i> <?php _e('Employee Report', 'hr_mgt'); ?></a>
				  </a>
				</li>				
			</ul>		
			<?php if($active_tab=='department_report'){ 
				$obj_deparment = new HrmgtDepartment();
				$result = $obj_deparment->get_all_child_departments();						
				foreach($result as $key=>$value){
					$department_id =  $value->id;							
					$department_name =  $value->department_name;							
					$args = array('meta_key'=>'department','meta_value'=>$department_id);							
					$result = get_users($args);	
					$totle_dept_emp =count($result);	
					$chart_array[0] = array('Department Name','No Of Employee');
					$chart_array[] = array($department_name,$totle_dept_emp);
				} ?>
					
					<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
					<script type="text/javascript">
					  google.charts.load('current', {'packages':['corechart']});
					  google.charts.setOnLoadCallback(drawChart);
					  function drawChart() {

						var data = google.visualization.arrayToDataTable(<?php  print json_encode($chart_array); ?>);

						var options = {
						  title: ''
						};

						var chart = new google.visualization.PieChart(document.getElementById('piechart'));

						chart.draw(data, options);
					  }
					</script>
  
					<div id="piechart" style="width: 900px; height: 500px;"></div>
		<?php }	
if($active_tab=='payslip_report'){ 
	global $wpdb;
	$tbl_salary_slip = $wpdb->prefix. 'hrmgt_generated_salary_slip';
	 $year=date("Y");		
	
		$months_data = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun',
		'07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Desc');
		
		foreach($months_data as $key=>$value){
			$total_amount = 0;
			$month_name = $value;
			$month_no = $key;
			$result = $wpdb->get_var("SELECT SUM(net_salary) FROM $tbl_salary_slip WHERE month=$key" ); 
			$total_amount =  $result;			
			$chart_arrays[0]= array('Month','Amount');
			$chart_arrays[]= array($value,(int)$total_amount);
		}
		
	?>	
			
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script>
	 google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawBasic);

	function drawBasic() {
      var data_col = google.visualization.arrayToDataTable(<?php echo json_encode($chart_arrays); ?>); 
	 
	
     var chart_col = new google.visualization.ColumnChart(document.getElementById('chart_div'));
				 chart_col.draw(data_col);

      chart.draw(data_col);
    } 
	</script>
		<div id="chart_div"></div>
	<?php } if($active_tab=="month_report"){?>
	<script>
	$(document).ready(function(){
	 $('#start_date').datepicker({
		   changeMonth: true,
	        changeYear: true,
	        yearRange:'-10:+0',
			dateFormat: 'yy-mm-dd',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
      });
	  $('#end_date').datepicker({
		  changeMonth: true,
	        changeYear: true,
	        yearRange:'-10:+0',
			dateFormat: 'yy-mm-dd',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        } 
	  });	  
	});	
	</script>	
<div  class="container panel-body">
<form class="form-inline" id="report_form" method="post">
  <div class="form-group">
    <label for="email"><?php _e(' Select Employee','hr_mgt');?><span class="require-field">*</span></label>
	<select class="form-control validate[required] " name="employee_id">
		<option value=""><?php _e('Select Employee','hr_mgt');?></option>
		<?php
			$employee=0;		
			if(isset($_REQUEST['employee_id'])){
				$employee =$_REQUEST['employee_id'];  
			}
				$employeedata = hrmgt_get_working_user('employee');
				if(!empty($employeedata)){
				foreach ($employeedata as $retrive_data){ 
					echo '<option value="'.$retrive_data->ID.'" '.selected($employee,$retrive_data->ID).'>'.$retrive_data->display_name.'</option>';
				}} ?>				
	</select>
  </div>
  <div class="form-group">
    <label for="pwd"><?php _e('Start Date','hr_mgt');?></label>
   <input id="start_date" class="form-control" value="<?php if(isset($_POST['start_date'])) print $_POST['start_date']; else $_POST['start_date']=""; ?>" type="text" name="start_date" />
  </div>
   <div class="form-group">
    <label for="pwd"><?php _e('End date','hr_mgt');?></label>
   <input id="end_date"  value="<?php if(isset($_POST['end_date'])) print $_POST['end_date']; else $_POST['end_date']=""; ?>" class="form-control"  type="text" name="end_date" />
  </div>
  <input type="submit" class="btn btn-info" name="get_report" value="<?php _e('Get Report','hr_mgt'); ?>" >
</form>

<?php if(isset($_REQUEST['employee_id']) || isset($_POST['get_report'])){ 
	 $employee_id = $_POST['employee_id'];
	 $start_date = $_POST['start_date'];
	 $end_date =$_POST['end_date'];
	
?>
<div id="dvContents">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.js"></script>

		<div class="container">
		<h3 style="padding:20px 0;"><?php print  __(' Report For : ','hr_mgt') . hrmgt_get_display_name($_REQUEST['employee_id']);?></h3>
		<h4><?php print  __('1. Leave Report','hr_mgt');?></h4>
  <div class="table-responsive ">  
  <table class="table table-striped" style="width:90%; margin-bottom: 100px;">
    <thead>
      <tr>
        <th><?php _e('Leave Type','hr_mgt'); ?></th>
        <th><?php _e('Leave Duration','hr_mgt'); ?></th>
        <th><?php _e('Leave Start Date ','hr_mgt'); ?></th>
        <th><?php _e('Leave End Date','hr_mgt'); ?></th>
        <th><?php _e('Reason Type','hr_mgt'); ?></th>
       
      </tr>
    </thead>
    <tbody>
	<?php 
	$leavedata  = $obj_leave->get_single_user_leaves_for_report($employee_id,$start_date,$end_date);	
	if(!empty($leavedata)){		
		foreach($leavedata as $key=>$retrive_data){ 			
			if($retrive_data->leave_duration=="full_day"){
				$dration = "Full Day";
			}elseif($retrive_data->leave_duration=="half_day"){
				$dration = "Half Day";
			}elseif($retrive_data->leave_duration =="more_then_day"){
				$dration = "More Then One Day";
			}
		?>
		 <tr>
			<td><?php print get_the_title($retrive_data->leave_type); ?></td>
			<td><?php print $dration; ?></td>
			<td><?php print hrmgt_change_dateformat($retrive_data->start_date); ?></td>
			<td><?php print hrmgt_change_dateformat($retrive_data->end_date); ?></td>
			<td><?php print $retrive_data->reason; ?></td>			
		</tr>			
	<?php }	 }?>            
    </tbody>
  </table>
  </div>
  <div class="clear"></div>
  <h4><?php print  __('2. Perfomance Report','hr_mgt');?></h4>
  <div class="table-responsive ">
    <table class="table table-striped" style="width:90%; margin-bottom: 100px; ">
    <thead>
      <tr>
        <th><?php _e(' Perfomance Title','hr_mgt'); ?></th>
        <th><?php _e('Perfomance Mark','hr_mgt'); ?></th>
        <th><?php _e('Performance Evaluation period','hr_mgt'); ?></th>
        <th><?php _e('Perfomance Description ','hr_mgt'); ?></th>      
      </tr>
    </thead>	
	<tbody>
		<?php
		$performancedata=$obj_performance->get_all_parfomance_marks_of_user_for_report($employee_id,$start_date,$end_date);
		if(!empty($performancedata)){
		foreach($performancedata as $key=>$retrive_data){ ?>
			<tr>
				<td><?php print $retrive_data->title ?></td>
				<td><?php print $retrive_data->mark ?></td>
				<td><?php print hrmgt_change_dateformat($retrive_data->period_start) ?></td>
				<td><?php print $retrive_data->description ?></td>
				
			</tr>
		<?php } }?>	
	</tbody>
	</table>
	</div>
	<h4><?php _e('3. Skill Report','hr_mgt');?></h4>
	<div class="table-responsive ">
	<table class="table" style="width:90%; margin-bottom: 100px;">
  <thead>
    <tr>    
      <th><?php _e('Employee Name','hr_mgt'); ?></th> 
		<?php
		$activity_category=hrmgt_get_all_category('training_skill_cat');
		$skill_array=array();
		if(!empty($activity_category)){
			foreach ($activity_category as $retrive_data){		
			$title_array[]=$retrive_data->ID;
			?>
			<th><?php print $retrive_data->post_title ?></th>
		<?php } ?>
			
		<?php }	?>
    </tr>
  </thead>
  <tbody>
  <?php 
	$result = $obj_skill->get_employee_single_matrix($_REQUEST['employee_id'],$start_date,$end_date);
	foreach($result as $retrived_data){ 
		$achive_skiil = json_decode($retrived_data->skill,true);
	?>
    <tr>     
      <th><?php print hrmgt_get_display_name($retrived_data->employee_id); ?></th>      
	<?php	
		$activity_category=hrmgt_get_all_category('training_skill_cat'); 			
		foreach($title_array as $keys=>$val)
		{
			if(isset($achive_skiil[$val]))
			{
				print '<td>' .$achive_skiil[$val].'</td>';
			}
			else
			{
				print '<td> - </td>';
			}
		}					
	 }
	?>
    </tr>   
  </tbody>
</table>	
</div>

	
	
	
	  <div class="clear"></div>
  <h4><?php _e('4. Project Report','hr_mgt');?></h4>
  <div class="table-responsive ">
    <table class="table table-striped" style="width:90%; margin-bottom: 100px; ">
    <thead>
		<tr>
			<th><?php _e('Project Title ','hr_mgt'); ?></th>	
			<th><?php _e('Client Name','hr_mgt'); ?></th>
			<th><?php _e('Project Start Date','hr_mgt'); ?></th>
			<th><?php _e('Project End Date','hr_mgt'); ?></th>      
			<th><?php _e('Actual Completion Date','hr_mgt'); ?></th>      
			<th><?php _e('Actual Status','hr_mgt'); ?></th>      
		</tr>
    </thead>	
	<tbody>
		<?php
		$obj_project=$obj_project->get_user_project_for_report($employee_id,$start_date,$end_date);
		if(!empty($obj_project)){
		foreach($obj_project as $key=>$retrive_data){ ?>
			<tr>
				<td><?php print $retrive_data->project_title ?></td>
				<td><?php print $retrive_data->client_name ?></td>
				<td><?php print hrmgt_change_dateformat ( $retrive_data->start_date) ?></td>
				<td><?php print hrmgt_change_dateformat ( $retrive_data->end_date) ?></td>
				<td><?php print hrmgt_change_dateformat($retrive_data->completion_date) ?></td>
				<td><?php print $retrive_data->status?></td>				
			</tr>
		<?php } }?>	
	</tbody>
	</table>
</div>



	
	  <div class="clear"></div>
  <h4><?php _e('4. Client Feedback Report','hr_mgt');?></h4>
  <div class="table-responsive ">
    <table class="table table-striped" style="width:90%; margin-bottom: 100px; ">
    <thead>
      <tr>
        <th><?php _e('Client Name ','hr_mgt'); ?></th>	        
        <th><?php _e('Project Name','hr_mgt'); ?></th>
        <th><?php _e('Comment','hr_mgt'); ?></th>      
        <th><?php _e('Ratting','hr_mgt'); ?></th>      
      </tr>
    </thead>	
	<tbody>
		<?php
		$feedback_data = $obj_feedback->hrmgt_get_cf_for_report($employee_id,$start_date,$end_date);
		if(!empty($feedback_data)){
		foreach($feedback_data as $key=>$retrive_data){ ?>
			<tr>
				<td><?php print $retrive_data->client_name ?></td>
				<td><?php print hrmgt_get_project_title($retrive_data->project_id)  ?></td>
				<td><?php print $retrive_data->comment ?></td>
				<td> <div id="rateYo_<?php echo $retrive_data->id;?>"></div>
					<script type="text/javascript">					
						$(function () { 
						$("#rateYo_<?php echo $retrive_data->id;?>").rateYo({ 
							rating    :<?php print $retrive_data->rate; ?>,
							readOnly:true,
							 starWidth: "30px"
						}); 
						
					});
					</script>					
				</td>				
			</tr>
		<?php } }?>	
	</tbody>
	</table>	
</div>
</div>
	</div>	
	</div>	
	
<script type="text/javascript">
	function PrintDiv() {
		var PrintDiv = document.getElementById('dvContents');
		var popupWin = window.open('', '_blank', 'width=1250,height=800');
		popupWin.document.open();
		popupWin.document.write('<html><body onload="window.print()">' + PrintDiv.innerHTML + '</html>');
		popupWin.document.close();
	}
</script>
	
<form id="form1">    
	<input type="button" class="btn btn-primary" onclick="PrintDiv();" value="Print" />
</form>		
<?php } ?>	

	<?php }	?>
	
		</div>
	</div>
	</div>
</div>
<div>