<?php ?>
<?php 
$obj_skill=new hrmgtSkillMetrix;
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#leave_form').validationEngine();

$('#skill_end').datepicker({
	dateFormat:'yy-mm-dd',
		  changeMonth: true,
	        changeYear: true,
	        yearRange:'-10:+0',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        },
			onSelect: function(selected) {
				$("#skill_start").datepicker("option","maxDate", selected)
			}
	}); 
	  
	$('#skill_start').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange:'-10:+0',
		onChangeMonthYear: function(year, month, inst) {
			$(this).val(month + "/" + year);
		},
		onSelect: function(selected) {
			$("#skill_end").datepicker("option","minDate", selected)
		}
    }); 	  
});
</script>
<style>
hr{
	margin:0px 0 16px;
}
</style>
     <?php 	                                 
			$id=0;
			if(isset($_REQUEST['id']))
			 $id=$_REQUEST['id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;				
					$result = $obj_skill->hrmgt_get_single_skill($id);				
				}
		
				?>
		<div class="panel-body">
        <form name="leave_form" action="" method="post" class="form-horizontal" id="leave_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="id" value="<?php echo $id;?>"  />		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<select class="form-control validate[required]" name="employee_id">
				<option value=""><?php _e('Select Employee','hr_mgt');?></option>
				<?php 
				if($edit)
					$employee =$result->employee_id;	
				elseif(isset($_REQUEST['emp_id']))
					$employee =$_REQUEST['emp_id'];  
				else 
					$employee = "";
					/* $get_employee = array('role' => 'employee');
					$employeedata=get_users($get_employee); */
					$employeedata=hrmgt_get_working_user('employee');
					if(!empty($employeedata))
					{
						foreach ($employeedata as $retrive_data){ 
							echo '<option value="'.$retrive_data->ID.'" '.selected($retrive_data->ID,$employee).'>'.$retrive_data->display_name.'</option>';
					}
				} ?>
				</select>
			</div>			
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="skill_start"><?php _e(' Skill Start Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="skill_start" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->skill_start)); } elseif(isset($_POST['skill_start'])) echo $_POST['skill_start'];?>" name="skill_start">
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="skill_end"><?php _e('Skill End Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="skill_end" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->skill_end )) ; } elseif(isset($_POST['skill_end'])) echo $_POST['skill_end'];?>" name="skill_end">
			</div>
		</div>
		
		
		
		
		<div class="row">
			<div class="col-md-2"></div>
		<div class="col-md-4">Skill<span class="require-field">*</span></div>
		<div class="col-md-2">Point</div>
		</div>
		<hr>
		<?php if($edit){ 
			$skill = (array)json_decode($result->skill);
			//$activity_category=hrmgt_get_all_category('training_skill_cat');
			//var_dump($activity_category);
						
			foreach($skill as $key=>$retrive_datas){ ?>
		<div id="add_skill">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="income_entry"></label>
					<div class="col-sm-4">
					<select class="form-control validate[required]" name="training_subject[]" id="training_skill_cat">
						<option value=""><?php _e('Select Training Subject','hr_mgt');?></option>
						<?php						
						$activity_category=hrmgt_get_all_category('training_skill_cat');
						
						
						if(!empty($activity_category)){
							foreach ($activity_category as $retrive_data){
								echo '<option value="'.$retrive_data->ID.'"'.selected($retrive_data->ID,$key).'>'.$retrive_data->post_title.'</option>';
							}
						} ?>
						
					</select>						
					</div>
					<div class="col-sm-2">
						<input id="" class="form-control text-input" value="<?php print  $retrive_datas; ?>" type="text"  name="point[]">
					</div>						
					<div class="col-sm-2">
						<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
							<i class="entypo-trash"><?php _e('Delete','hr_mgt');?></i>
						</button>
					</div>
				</div>
		</div>	
		<?php } }
		 else{ ?> 
			<div id="add_skill">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="income_entry"></label>
					<div class="col-sm-4">
						<select class="form-control validate[required]" name="training_subject[]" id="training_skill_cat">
						<option value=""><?php _e('Select Training Subject','hr_mgt');?></option>
						<?php
								
						$activity_category=hrmgt_get_all_category('training_skill_cat');
						if(!empty($activity_category))
						{
							foreach ($activity_category as $retrive_data)
							{
								echo '<option value="'.$retrive_data->ID.'">'.$retrive_data->post_title.'</option>';
							}
						} ?>
						
					</select>						
					</div>
					<div class="col-sm-2">
						<input id="" class="form-control text-input" type="text"  name="point[]">
					</div>						
					<div class="col-sm-2">
						<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
							<i class="entypo-trash"><?php _e('Delete','hr_mgt');?></i>
						</button>
					</div>
				</div>
		</div>	
		<?php  }?>			
		<div class="form-group">
			<label class="col-sm-2 control-label" for="expense_entry"></label>
			<div class="col-sm-3">
				<button id="add_new_entry" class="btn btn-default btn-sm btn-icon icon-left" type="button"   name="add_new_entry" onclick="add_entry()"><?php _e('Add More Entry','hr_mgt'); ?></button>
			</div>
		</div>
					
				
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Skill','hr_mgt');}?>" name="save_skill" class="btn btn-success"/>
        </div>
		</form>
</div>
<script>
 	var blank_skill_entry ='';
   	$(document).ready(function() { 
   		blank_skill_entry = $('#add_skill').html();
   		//alert("hello" + blank_invoice_entry);
   	}); 

   	function add_entry()
   	{
   		$("#add_skill").append(blank_skill_entry);
   		//alert("hellooo");
   	}
   	
   	// REMOVING INVOICE ENTRY
   	function deleteParentElement(n){
   		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
   	}

</script>