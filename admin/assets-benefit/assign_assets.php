<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#assets_form').validationEngine();
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
			$("#start_date").datepicker("option","minDate", selected)
		}
      }); 
});
</script>
     <?php 	                                 
			$assign_id=0;
			if(isset($_REQUEST['assign_id']))
				$assign_id=$_REQUEST['assign_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$result = $obj_compansation->hrmgt_get_single_assets($assign_id);
				} ?>
		<div class="panel-body">
        <form name="assets_form" action="" method="post" class="form-horizontal" id="assets_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="assign_id" value="<?php echo $assign_id;?>"  />
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?><span class="require-field">*</span></label>
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
					$employeedata=hrmgt_get_working_user('employee');
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
			<label class="col-sm-2 control-label" for="assets_category"><?php _e('Assets ','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="asset_id" id="assets_cat">
				<option value=""><?php _e('Select Asset','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$result->asset_id;
				elseif(isset($_REQUEST['asset_id']))
					$category =$_REQUEST['asset_id'];  
				else 
					$category = "";
				$activity_category=hrmgt_get_all_category('assets_cat');
				if(!empty($activity_category))
				{
					foreach ($activity_category as $retrive_data)
					{
						echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
					}
				} ?>
				</select>
			</div>
			<div class="col-sm-2"><button id="addremove" model="assets_cat"><?php _e('Add Or Remove','hr_mgt');?></button></div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="start_date"><?php _e('Given Date','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="start_date" class="form-control text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->assign_date));}elseif(isset($_POST['assign_date'])) echo $_POST['assign_date'];?>" name="assign_date">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date"><?php _e('Return date','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="end_date" class="form-control text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->return_date)) ;}elseif(isset($_POST['return_date'])) echo $_POST['return_date'];?>" name="return_date">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="description" class="form-control" name="description"><?php if($edit){echo $result->description; }elseif(isset($_POST['description'])) echo $_POST['description']; ?> </textarea>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Assign Asset','hr_mgt');}?>" name="assign_asset" class="btn btn-success"/>
        </div>
		</form>
</div>