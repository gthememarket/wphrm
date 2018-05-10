<script type="text/javascript">
$(document).ready(function() {
	$('#department_form').validationEngine();
} );
</script>
     <?php 	
		$dept_id=0;
		if(isset($_REQUEST['dept_id']))
			$dept_id=$_REQUEST['dept_id'];
		$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
				$edit=1;
				$result = $obj_department->hrmgt_get_single_department($dept_id);	
				
			} ?>
	<div class="panel-body">
        <form name="department_form" action="" method="post" class="form-horizontal" id="department_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="dept_id" value="<?php print $dept_id ?>"  />
		<div class="form-group">
			<label class="col-sm-2 control-label" for="department_name"><?php _e('Department Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="department_name" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $result->department_name;}elseif(isset($_POST['department_name'])) echo $_POST['department_name'];?>" name="department_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="parent_category_category"><?php _e('Parent Department','hr_mgt');?></label>
			<div class="col-sm-8">
			<?php $parent_department=0;
			if($edit){$parent_department=$result->parent_department_id;}elseif( isset($_POST['parent_department_id'])) $parent_department=$_POST['parent_department_id'];?>
				<select class="form-control" name="parent_department_id" id="parent_dept_cat">
					<option value=""><?php _e('Select Department','hr_mgt');?></option>
					<?php 
						$dept_result = $obj_department->get_all_departments();					
						foreach($dept_result as $key=>$value){
							$dept_name = $value->department_name;
							$dept_id = $value->id; ?>					
							<option value="<?php echo $dept_id;?>" <?php selected($parent_department,$dept_id);?>><?php echo $dept_name;?></option>
						<?php }		 
					?>			
				</select>
			</div>			
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="activity_category"><?php _e('Department Head','hr_mgt');?></label>
			<div class="col-sm-8">
				<select class="form-control" name="dept_head_id">
				<option value=""><?php _e('Select Department Head','hr_mgt');?></option>
				<?php 
				if($edit)
					$dept_head =$result->dept_head_id;
				elseif(isset($_REQUEST['dept_head_id']))
					$dept_head =$_REQUEST['dept_head_id'];  
				else 
					$dept_head = "";					 
					$employeedata=hrmgt_get_working_user('employee');
					if(!empty($employeedata))
					{
						foreach ($employeedata as $retrive_data){ 
							echo '<option value="'.$retrive_data->ID.'" '.selected($dept_head,$retrive_data->ID).'>'.$retrive_data->display_name.'</option>';
					}
				} ?>
				</select>
			</div>
			
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="compassionate_leave"><?php _e('Compassionate Leave','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="compassionate_leave" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->compassionate_leave;}elseif(isset($_POST['compassionate_leave'])) echo $_POST['compassionate_leave'];?>" name="compassionate_leave">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hospitalisation_leave"><?php _e('Hospitalisation Leave','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="hospitalisation_leave" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->hospitalisation_leave;}elseif(isset($_POST['hospitalisation_leave'])) echo $_POST['hospitalisation_leave'];?>" name="hospitalisation_leave">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="marriage_leave"><?php _e('Marriage Leave','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="marriage_leave" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->marriage_leave;}elseif(isset($_POST['marriage_leave'])) echo $_POST['marriage_leave'];?>" name="marriage_leave">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="maternity_leave"><?php _e('Maternity Leave','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="maternity_leave" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->maternity_leave;}elseif(isset($_POST['maternity_leave'])) echo $_POST['maternity_leave'];?>" name="maternity_leave">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="paternity_leave"><?php _e('Paternity Leave','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="paternity_leave" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->paternity_leave;}elseif(isset($_POST['paternity_leave'])) echo $_POST['paternity_leave'];?>" name="paternity_leave">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="sick_leave"><?php _e('Sick Leave','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="sick_leave" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->sick_leave;}elseif(isset($_POST['sick_leave'])) echo $_POST['sick_leave'];?>" name="sick_leave">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="annual_leaves"><?php _e('Annual Leaves Allowed','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="annual_leaves" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->annual_leaves;}elseif(isset($_POST['annual_leaves'])) echo $_POST['annual_leaves'];?>" name="annual_leaves">
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Department','hr_mgt');}?>" name="save_department" class="btn btn-success"/>
        </div>
		</form>
    </div>