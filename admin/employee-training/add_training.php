<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#training_form').validationEngine();
	$('#start_date').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange:'-10:+10',
		onChangeMonthYear: function(year, month, inst) {
			$(this).val(month + "/" + year);
		},
		onSelect: function(selected) {
			$("#end_date").datepicker("option","minDate", selected)
		}
    }); 
	$('#end_date').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange:'-10:+10',
		onChangeMonthYear: function(year, month, inst) {
			$(this).val(month + "/" + year);
		},
		onSelect: function(selected) {
			$("#start_date").datepicker("option","maxDate", selected)
		}
	});	
	$('#employee_id').multiselect();		

});
</script>
     <?php 	                                 
			$training_id=0;
			if(isset($_REQUEST['training_id']))
				$training_id=$_REQUEST['training_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$result = $obj_training->hrmgt_get_single_training($training_id);
					
				} ?>
		<div class="panel-body">
        <form name="training_form" action="" method="post" class="form-horizontal" id="training_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="training_id" value="<?php echo $training_id;?>"  />
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="parent_category_category"><?php _e('Training Type','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="training_type" id="training_type_cat">
				<option value=""><?php _e('Select Training Type','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$result->training_type;
				elseif(isset($_REQUEST['training_type']))
					$category =$_REQUEST['training_type'];  
				else 
					$category = "";
				
				$activity_category=hrmgt_get_all_category('training_type_cat');
				if(!empty($activity_category))
				{
					foreach ($activity_category as $retrive_data)
					{
						echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
					}
				} ?>
				</select>
			</div>
			<div class="col-sm-2"><button id="addremove" model="training_type_cat"><?php _e('Add Or Remove','hr_mgt');?></button></div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="reason"><?php _e('Training Subject ( Skill )','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<select class="form-control validate[required]" name="training_subject" id="training_skill_cat">
				<option value=""><?php _e('Select Training Subject','hr_mgt');?></option>
				<?php
				if($edit)
					$category =$result->training_subject;
				elseif(isset($_REQUEST['training_subject']))
					$category =$_REQUEST['training_subject'];  
				else 
					$category = "";			
				 $activity_category=hrmgt_get_all_category('training_skill_cat');
				if(!empty($activity_category))
				{
					foreach ($activity_category as $retrive_data)
					{
						echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
					}
				} ?>
				
			</select>				
			</div>
			<div class="col-sm-2"><button id="addremove" model="training_skill_cat"><?php _e('Add Or Remove','hr_mgt');?></button></div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="reason"><?php _e('Training Title ','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="training_title" class="form-control validate[required]" type="text"  name="training_title" 
				value="<?php if($edit){ echo $result->training_title;}elseif(isset($_POST['training_title'])) echo $_POST['training_title'];?>">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="reason"><?php _e('Trainer','hr_mgt');?></label>
			<div class="col-sm-8">
				<select id="traininer" class="form-control" type="text"  name="traininer">
				<option><?php _e('Select Trainer','hr_mgt'); ?></option>	
				<?php 
					if($edit)
						$category = $result->traininer;
					elseif(isset($_REQUEST['traininer']))
					$category =$_REQUEST['traininer'];  
					else 
					$category = "";					
					
					/* $get_employee = array('role' => 'employee');
					$employeedata=get_users($get_employee); */
					$employeedata=hrmgt_get_working_user('employee');
					foreach ($employeedata as $retrive_data){  ?>					
						<option value="<?php print $retrive_data->ID ?>"<?php print selected($category,$retrive_data->ID) ?> > <?php print  $retrive_data->display_name ?></option>";
					<?php }					
				?>					
				</select> 				
			</div>
			<div class="col-sm-2">
				<a  class="button" href="?page=hrmgt-user&tab=add_user&user_type=employee" id="" model=""> <?php _e('Add Trainer','hr_mgt'); ?></a>		
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?></label>
			<div class="col-sm-8">
				<select class="form-control " name="employee[]" id="employee_id" multiple="multiple">			
				<?php 
				if($edit)
					$employee =	$obj_training->check_training_emp($training_id);
				else
					$employee =array();
				
				
					/* $get_employee = array('role' => 'employee');
					$employeedata=get_users($get_employee); */
					$employeedata=hrmgt_get_working_user('employee');
					if(!empty($employeedata))
					{
						foreach ($employeedata as $retrive_data){ ?>
							<option value="<?php echo $retrive_data->ID;?>" <?php if(in_array($retrive_data->ID,$employee)) echo 'selected';  ?>><?php echo $retrive_data->display_name; ?> </option>
					<?php }
				} ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="reason"><?php _e('Training Location','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="training_location" class="form-control" type="text"  name="training_location" 
				value="<?php if($edit){ echo $result->training_location;}elseif(isset($_POST['training_location'])) echo $_POST['training_location'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="start_date"><?php _e('Training Start Date','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="start_date" class="form-control" type="text"  name="start_date" 
				value="<?php if($edit){ echo date("Y-m-d",strtotime($result->start_date)); } elseif(isset($_POST['start_date'])) echo $_POST['start_date'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date"><?php _e('Training End Date','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="end_date" class="form-control" type="text"  name="end_date" 
				value="<?php if($edit){ echo date("Y-m-d",strtotime($result->end_date)); }elseif(isset($_POST['end_date'])) echo $_POST['end_date'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="note"><?php _e('Description','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="description" class="form-control" name="description"><?php if($edit){echo $result->description; }elseif(isset($_POST['description'])) echo $_POST['description']; ?> </textarea>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Training','hr_mgt');}?>" name="save_training" class="btn btn-success"/>
        </div>
		</form>
</div>