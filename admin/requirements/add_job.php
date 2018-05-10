<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#job_form').validationEngine();
			$('#closing_date').datepicker({
			dateFormat:'yy-mm-dd',
			changeMonth: true,
	        changeYear: true,
	        yearRange:'-10:+10',
			minDate:0,
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
      }); 
});
</script>
     <?php 	                                 
			$job_id=0;
			if(isset($_REQUEST['job_id']))
				$job_id=$_REQUEST['job_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$result = $obj_requirements->hrmgt_get_single_posted_job($job_id);
					
				} ?>
		<div class="panel-body">
        <form name="job_form" action="" method="post" class="form-horizontal" id="job_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="job_id" value="<?php echo $job_id;?>"  />
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date"><?php _e('Job Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="job_title" class="form-control text-input validate[required]" type="text"  value="<?php if($edit){ echo $result->job_title;}elseif(isset($_POST['job_title'])) echo $_POST['job_title'];?>" name="job_title">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="department"><?php _e('Department','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="department_id" id="department">
				<option value=""><?php _e('Select Department','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$result->department_id;
				elseif(isset($_REQUEST['department_id']))
					$category =$_REQUEST['department_id'];  
				else 
					$category = "";
				
					$departmentdata=$obj_department->get_all_departments();
			 if(!empty($departmentdata))
			 {
				foreach ($departmentdata as $retrive_data){
						{
						echo '<option value="'.$retrive_data->id.'" '.selected($category,$retrive_data->id).'>'.$retrive_data->department_name.'</option>';
					}
				}
			 }?>
				</select>
			</div>		
		</div>		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="parent_category_category"><?php _e('Designation','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control  validate[required]" name="designation" id="designation_cat">
				<option value=""><?php _e('Select Designation','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$result->designation;
				elseif(isset($_REQUEST['designation']))
					$category =$_REQUEST['designation'];  
				else 
					$category = "";
				
				$activity_category=hrmgt_get_all_category('designation_cat');
				if(!empty($activity_category))
				{
					foreach ($activity_category as $retrive_data)
					{
						echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
					}
				} ?>
				</select>
			</div>
			<div class="col-sm-2"><button id="addremove" model="designation_cat"><?php _e('Add Or Remove','hr_mgt');?></button></div>
		</div>	
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="parent_category_category"><?php _e('Status','hr_mgt');?></label>
			<div class="col-sm-8">
			<?php 
				if($edit){
					$obj_requierment = new HrmgtRequirements();					
					$result = $obj_requierment->hrmgt_get_single_posted_job($_GET['job_id']);
					$status =  $result->status;				
				}				
			?>
				
				<select name="status" class="form-control">
					<option value="" ><?php _e('Select Status','hr_mgt');?></option>
					<option value="1" <?php	if(isset($status)){ if($status == 1){ echo 'selected="selected"';}else{echo '';} }?>><?php _e('Open','hr_mgt');?></option>
					<option value="0" <?php	if(isset($status)){	if($status == 0){echo 'selected="selected"';}else{echo '';}}?>><?php _e('Close','hr_mgt');?></option>
				</select>
			</div>
		</div>		
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="start_date"><?php _e('Number of Positions ','hr_mgt');?><span class="require-field">*</span>	</label>
			<div class="col-sm-8">
				<input id="positions" class="form-control validate[required,custom[number]] text-input" type="text"  value="<?php if($edit){ echo $result->positions;}elseif(isset($_POST['positions'])) echo $_POST['positions'];?>" name="positions">
			</div>
		</div>		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="closing_date"><?php _e('Job Post Closing Date','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="closing_date" class="form-control text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->closing_date)) ;}elseif(isset($_POST['closing_date'])) echo $_POST['closing_date'];?>" name="closing_date">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="description" class="form-control" name="description"><?php if($edit){echo $result->description; }elseif(isset($_POST['description'])) echo $_POST['description']; ?> </textarea>
			</div>
		</div>
		<?php 
			if($edit){
				$all_criere=json_decode($result->criere_entry);				
			}
		?>	
		<?php 
			if(!empty($all_criere)){
				foreach($all_criere as $criere){ ?>
				<div id="criere_entry">
			<div class="form-group">
			<label class="col-sm-2 control-label" for="income_entry"><?php _e('Criteria ','hr_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-4">
					<input id="criere_entry" class="form-control validate[required] text-input" type="text" value="<?php print $criere ?>" name="criere_entry[]" placeholder="Title">
				</div>
				<div class="col-sm-2">
					<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
						<i class="entypo-trash"><?php _e('Delete','hr_mgt');?></i>
					</button>
				</div>
			</div>		
		</div>
					
			<?php }	} else{ ?>		
		<div id="criere_entry">
			<div class="form-group">
			<label class="col-sm-2 control-label" for="income_entry"><?php _e('Criteria ','hr_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-4">
					<input id="criere_entry" class="form-control validate[required] text-input" type="text" value="" name="criere_entry[]" placeholder="Title">
				</div>
				<div class="col-sm-2">
					<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
						<i class="entypo-trash"><?php _e('Delete','hr_mgt');?></i>
					</button>
				</div>
			</div>		
		</div>
			<?php } ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="expense_entry"></label>
			<div class="col-sm-3">
				<button id="add_new_entry" class="btn btn-default btn-sm btn-icon icon-left" type="button"   name="add_new_entry" onclick="add_entry()"><?php _e('Add More Entry','hr_mgt'); ?>
				</button>
			</div>
		</div>
		
		
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Job','hr_mgt');}?>" name="save_job" class="btn btn-success"/>
        </div>
		</form>
</div>
<script>
   	var blank_salary_entry ='';
   	$(document).ready(function() { 
   		blank_salary_entry = $('#criere_entry').html();   		
   	}); 

   	function add_entry()
   	{
   		$("#criere_entry").append(blank_salary_entry);   		
   	}
   	
   	
   	function deleteParentElement(n){
   		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
   	}	
</script>