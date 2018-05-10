<script type="text/javascript">
$(document).ready(function() {
	$('#suggestion_form').validationEngine();
	 $('#suggestion_date').datepicker({
			dateFormat:'yy-mm-dd',
			changeMonth: true,
	        changeYear: true,
	        yearRange:'-10:+0',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
      }); 	 
});
</script>
     <?php 	                                 
		$suggestion_id=0;
		if(isset($_REQUEST['suggestion_id']))
			$suggestion_id=$_REQUEST['suggestion_id'];
		$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
				$edit=1;
				$result = $obj_suggestion->hrmgt_get_single_suggestion($suggestion_id);
			} ?>
		<div class="panel-body">
        <form name="suggestion_form" action="" method="post" class="form-horizontal" id="suggestion_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="suggestion_id" value="<?php echo $suggestion_id;?>"  />
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date"><?php _e('Suggestion Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="suggetion_title" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $result->suggetion_title;}elseif(isset($_POST['suggetion_title'])) echo $_POST['suggetion_title'];?>" name="suggetion_title">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Suggestion From','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="employee_id">
				<option value=""><?php _e('Select Employee','hr_mgt');?></option>
				<?php 
				if($edit)
					$employee =$result->employee_id;
				elseif(isset($_REQUEST['employee_id']))
					$employee =$_REQUEST['employee_id'];  
				else 
					$employee = "";
					$employeedata = hrmgt_get_working_user('employee');
					if(!empty($employeedata))
					{
						foreach ($employeedata as $retrive_data){ 
							echo '<option value="'.$retrive_data->ID.'" '.selected($employee,$retrive_data->ID).'>'.$retrive_data->display_name.'</option>';
					}
				} ?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="start_date"><?php _e('Suggestion Date','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="suggestion_date" class="form-control text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->suggestion_date)); }elseif(isset($_POST['suggestion_date'])) echo $_POST['suggestion_date'];?>" name="suggestion_date">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Suggestion','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="suggestion" class="form-control" name="suggestion"><?php if($edit){echo $result->suggestion; }elseif(isset($_POST['suggestion'])) echo $_POST['suggestion']; ?> </textarea>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Suggestion','hr_mgt');}?>" name="save_suggestion" class="btn btn-success"/>
        </div>
		</form>
</div>