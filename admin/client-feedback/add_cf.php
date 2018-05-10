<?php 
$obj_project = new HrmgtProject();
$obj_feedback = new HrmgtCientFeedBack();
	
$cf_id=0;
if(isset($_REQUEST['cf_id']))
	$cf_id=$_REQUEST['cf_id'];
	$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
		$edit=1;
		$result = $obj_feedback->hrmgt_get_single_c_feedback($cf_id);
		$employee_project = $obj_feedback->hrmgt_get_cf_employee($cf_id);					
		$employees_id = array();
		foreach($employee_project as $key=>$value){
			$employees_id[] = $value->employee_id;
		}	
	} ?>

<script type="text/javascript">
$(document).ready(function() {
	$('#leave_form').validationEngine();
	$('#employees').multiselect();
});
$(function () {
<?php if($edit){ ?>		
$("#rateYo").rateYo({
	rating: <?php print $result->rate; ?>
});	
$("#rateYo").rateYo().on("rateyo.change", function (e, data) {
	var rating = data.rating;
	$("#star2_input").val(rating);
});
<?php }else { ?> 
$("#rateYo").rateYo().on("rateyo.change", function (e, data) {
	var rating = data.rating;
	$("#star2_input").val(rating);
});
<?php } ?>	
});
</script>
<div class="panel-body">
    <form name="leave_form" action="" method="post" class="form-horizontal" id="leave_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="cf_id" value="<?php echo $cf_id;?>"  />	
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="note"><?php _e('Client Name','hr_mgt');?></label>
			<div class="col-sm-8">					
				<input type='text'  class='form-control' name='client_name' value="<?php if($edit) print $result->client_name; ?>" id='client_name' />
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="parent_category_category"><?php _e('Project Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="project_id" id="project_id">
				<option value=""><?php _e('Select Project','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$result->project_id;
				elseif(isset($_REQUEST['project_id']))
					$category =$_REQUEST['project_id'];  
				else 
					$category = "";
					$projectdata=$obj_project->get_all_project();
				 if(!empty($projectdata)){
					foreach ($projectdata as $retrive_data){
						echo '<option value="'.$retrive_data->id.'" '.selected($category,$retrive_data->id).'>'.$retrive_data->project_title.'</option>';
					}
				} ?>
				</select>
			</div>		
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">	
				<select class="form-control validate[required] employee" id="employees" name="employee_id[]" Multiple="Multiple">
			<?php			
			if($edit)
			{
			    $employee = "";				
				$employeedata = get_employee_by_project_id($result->project_id);
				if(!empty($employeedata))
				{						
					foreach ($employeedata as $key=>$retrive_data)
					{ ?>
						<option  value="<?php print $retrive_data->employee_id; ?>"	<?php  if ($edit) { if(in_array($retrive_data->employee_id,$employees_id)){ print 'selected="selected"'; } } ?>> <?php print  hrmgt_get_display_name($retrive_data->employee_id); ?></option>
			<?php   }
				}
			}  ?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-2 control-label" for="note"><?php _e('comment','hr_mgt');?><span class="require-field">*</span></label>
		<div class="col-sm-8">
			<textarea id="reason" class="form-control validate[required]" name="comment"><?php if($edit){echo $result->comment; }elseif(isset($_POST['comment'])) echo $_POST['comment']; ?> </textarea>
		</div>
	</div>
	
	
	<div class="form-group">
		<label class="col-sm-2 control-label" for="note"><?php _e('Ratting','hr_mgt');?></label>
		<div class="col-sm-8">				
			<div id="rateYo"></div>
			<input type='hidden' name='rate' value="<?php if($edit) print $result->rate; ?>" id='star2_input' />
		</div>
	</div>
		
	<div class="col-sm-offset-2 col-sm-8">
       	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Client Feedback','hr_mgt');}?>" name="save_cf" class="btn btn-success"/>
    </div>
</form>
</div>