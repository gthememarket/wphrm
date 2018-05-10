<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#perfomance_form').validationEngine();	
	$('#period_start').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange:'-10:+0',
		dateFormat: 'yy-mm-dd',
		onChangeMonthYear: function(year, month, inst) {
			$(this).val(month + "/" + year);
		},
		onSelect: function(selected) {
			$("#period_end").datepicker("option","minDate", selected)
		}
	}); 
	  
	  
	$('#period_end').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange:'-10:+0',
		dateFormat: 'yy-mm-dd',
		onChangeMonthYear: function(year, month, inst) {
			$(this).val(month + "/" + year);
		},
		onSelect: function(selected) {
			$("#period_start").datepicker("option","maxDate", selected)
		} 
	});
	  
	$('.employee').multiselect({
		includeSelectAllOption: true,
		disableIfEmpty: true
	});		
});
</script>
     <?php 	                                 
			$parfomance_id=0;
			if(isset($_REQUEST['parfomance_id']))
				$parfomance_id=$_REQUEST['parfomance_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$result = $obj_par_mark->hrmgt_get_single_parfomance_marks($parfomance_id);
					$employee_project = $obj_par_mark->hrmgt_get_performace_employee($parfomance_id);					
					$employees_id = array();
					foreach($employee_project as $key=>$value){
						$employees_id[] = $value->employee_id;
					}			
					
				} ?>
		<div class="panel-body">
        <form name="perfomance_form" action="" method="post" class="form-horizontal" id="perfomance_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="parfomance_id" value="<?php echo $parfomance_id;?>"  />
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Project','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php $projects = $obj_project->get_all_project(); ?>
				
				<select class="form-control" id="project_id" name="project_id" required="required">
					<option value=""><?php _e('Select Project','hr_mgt');?></option>
				<?php
				foreach($projects as $project)
				{ ?>
					<option value="<?php print $project->id ?>" <?php if($edit){selected($project->id,$result->project_id);}?> ><?php print $project->project_title; ?></option>
				<?php 
				} ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			
				<select class="form-control employee" id="employees" name="employee_id[]" Multiple required="required">				
				<?php	
					if ($edit)
					{
						$employee = "";				
						$employeedata=hrmgt_get_working_user('employee');			
						if(!empty($employeedata))
						{	
							foreach ($employeedata as $retrive_data)
							{ ?>
								<option value="<?php print $retrive_data->ID ?>" <?php if ($edit) { if(in_array($retrive_data->ID,$employees_id)){ print 'selected="selected"'; } }?> ><?php print $retrive_data->display_name ?></option>
						<?php } 
						}   
					}   ?>
				</select>
				<span class="smgt_loading" style="visibility:hidden">Loading...</span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="holiday_title"><?php _e('Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="title" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $result->title;}elseif(isset($_POST['title'])) echo $_POST['title'];?>" name="title">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="holiday_title"><?php _e('Marks','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="mark" class="form-control  text-input" type="text"  value="<?php if($edit){ echo $result->mark;}elseif(isset($_POST['mark'])) echo $_POST['mark'];?>" name="mark">
			</div>
		</div>
		
		
		
		
		<div class="form-group">
		<div class="row">
			<label class="col-sm-2 control-label" for="holiday_title"><?php _e('Performance Evaluation period','hr_mgt');?></label>
			<div class="col-md-8">
				<div class="col-md-5" style="padding-right:0"><input id="period_start" type="text" name="period_start" class="form-control" value="<?php if($edit) print $result->period_start; ?>"></div> 
				<div class="col-md-2" style="text-align:center;padding:0"><?php _e('To','hr_mgt'); ?></div>
				<div class="col-md-5" style="padding-left:0" ><input id="period_end" type="text" name="period_end" class="form-control" value="<?php if($edit) print $result->period_end; ?>"></div>
			</div>			
		</div>
		</div>
		
		<!---<div class="form-group">
			<label class="col-sm-2 control-label" for="holiday_title"><?php _e('Performance Evaluation period','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="period" class="form-control  text-input" type="text"  value="<?php if($edit){ echo $result->period;}elseif(isset($_POST['period'])) echo $_POST['period'];?>" name="period">
			</div>
			</div>-->
		
		
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="description" class="form-control" name="description"><?php if($edit){echo $result->description; }elseif(isset($_POST['description'])) echo $_POST['description']; ?> </textarea>
			</div>
		</div>
		
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Performance Mark','hr_mgt');}?>" name="save_perfomance_marks" class="btn btn-success"/>
        </div>
		</form>
</div>