<script type="text/javascript">
$(document).ready(function() {
	$('#complaint_form').validationEngine();
	 $('#complaint_date').datepicker({
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
			$complaint_id=0;
			if(isset($_REQUEST['complaint_id']))
				$complaint_id=$_REQUEST['complaint_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$postdata=get_post($complaint_id);					
				} ?>
		<div class="panel-body">
        <form name="complaint_form" action="" method="post" class="form-horizontal" id="complaint_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="complaint_id" value="<?php echo $complaint_id;?>"  />
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date"><?php _e('Complaint Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="complaint_title" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $postdata->post_title;}elseif(isset($_POST['complaint_title'])) echo $_POST['complaint_title'];?>" name="complaint_title">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Complaint From','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="employee_id">
				<option value=""><?php _e('Select Employee','hr_mgt');?></option>
				<?php 
				if($edit)
					$employee =$postdata->complaint_from;
				elseif(isset($_REQUEST['employee_id']))
					$employee =$_REQUEST['employee_id'];  
				else 
					$employee = "";				
					$employeedata = hrmgt_get_working_user('employee');
					if(!empty($employeedata))
					{
						foreach ($employeedata as $retrive_data){ 
							echo '<option value="'.$retrive_data->ID.'" '.selected($retrive_data->ID,$employee ).'>'.$retrive_data->display_name.'</option>';
					}
				} ?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="start_date"><?php _e('Complaint Date','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="complaint_date" class="form-control text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($postdata->complaint_date));}elseif(isset($_POST['complaint_date'])) echo $_POST['complaint_date'];?>" name="complaint_date">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="complaint_status"><?php _e('Complaint Status','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="complaint_status">
				<option value=""><?php _e('Select Status','hr_mgt');?></option>
				<?php 
				if($edit)
					$statusres =$postdata->complaint_status;
				elseif(isset($_REQUEST['complaint_status']))
					$statusres =$_REQUEST['complaint_status'];  
				else 
					$statusres = "";
				foreach(hrmgt_complaint_status() as $status){ ?>
						<option value="<?php echo $status;?>" <?php selected($status,$statusres);?>><?php echo $status;?></option>
				<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Complaint','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="compalint" class="form-control" name="compalint"><?php if($edit){echo $postdata->post_content; }elseif(isset($_POST['compalint'])) echo $_POST['compalint']; ?> </textarea>
			</div>
		</div>
		
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Complaint','hr_mgt');}?>" name="save_complaint" class="btn btn-success"/>
        </div>
		</form>
</div>