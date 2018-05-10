<?php 		
$obj_skill=new hrmgtSkillMetrix;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'view_skill'; 
 if(isset($_POST['save_skill']))
 {
	 
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit")
	{
		$result = $obj_skill->hrmgt_add_skill_metrix($_POST);
		if($result)
		{
			wp_redirect ( '?hr-dashboard=user&page=skill_metrix&tab=view_skill&message=2');
		}
	}
	else
	{
		$result = $obj_skill->hrmgt_add_skill_metrix($_POST);		
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=skill_metrix&tab=view_skill&message=1');
		}
	}	
} 

if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == 1){ ?>
	<div id="message" class="updated below-h2  msg">
	<p>	<?php _e('Skill insert successfully','hr_mgt');	?></p></div>
	<?php 	} elseif($message == 2)	{ ?>
	<div id="message" class="updated below-h2  msg"><p><?php 	_e("Skill update successfully.",'hr_mgt');?></p></div>
<?php } } ?>

	
	<div class="panel-body panel-white">
		<ul class="nav nav-tabs panel_tabs" role="tablist" style="margin-bottom: 40px;">	 		
	  	<li class="<?php if($active_tab=='view_skill'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=skill_metrix&tab=view_skill" class="tab <?php echo $active_tab == 'view_skill' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Skill Matrix', 'hr_mgt'); ?></a>
          </a>
		</li>
		<?php if($role =="manager"){ ?> 
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){ ?>
		<li class="<?php if($active_tab=='add_skill'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=skill_metrix&tab=add_skill" class="tab <?php echo $active_tab == 'add_skill' ? 'active' : ''; ?>">
             <?php _e('Edit Skill Matrix ', 'hr_mgt'); ?></a>
          </a>
		</li>
		<?php } else { ?>
		<li class="<?php if($active_tab=='add_skill'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=skill_metrix&tab=add_skill" class="tab <?php echo $active_tab == 'add_skill' ? 'active' : ''; ?>">
             <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _e('Add Skill Matrix', 'hr_mgt'); ?></a>
          </a>
		</li>
		<?php } ?>	
		<?php }?>
		</ul>
	
	
    <?php 	
	if($active_tab == 'view_skill')
	{ ?>
    <form name="activity_form" action="" method="post">		
		<table class="table table-responsive">
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
				<?php if($role=="manager"){ ?>
					<th><?php _e('Action','hr_mgt'); ?></th>
					<?php }?>
				<?php }	?>
			</tr>
		  </thead>
		  <tbody>
		  <?php 
		  if($role=="manager"){
			  $result = $obj_skill->get_group_employee();
		  }else{
			   $result = $obj_skill->get_single_employee_skill(get_current_user_id());
		  }
			
			foreach($result as $retrived_data){ 
				$achive_skiil = json_decode($retrived_data->skill,true);
			?>
			<tr>     
			<th><?php print hrmgt_get_display_name($retrived_data->employee_id); ?></th>      
			<?php
				$activity_category=hrmgt_get_all_category('training_skill_cat'); 			
				foreach($title_array as $keys=>$val){	
					if(isset($achive_skiil[$val])){
						print '<td>' .$achive_skiil[$val].'</td>';
					}
					else
					{
						print '<td> - </td>';
					}
				}					
			?>	
			<?php if($role=="manager"){ ?> 
			<td><a href="?hr-dashboard=user&page=skill_metrix&tab=add_skill&action=edit&id=<?php print $retrived_data->id;?>" class="btn btn-primary"><?php _e('Edit','hr_mgt'); ?></a></td>
			<?php } } ?>
			</tr>   
		  </tbody>
		</table>			
			</div>
        </div>
</form>
     <?php 
}	
 if($active_tab == 'add_skill') {	
$obj_skill=new hrmgtSkillMetrix;
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#skill_form').validationEngine();

	$('#skill_end').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange:'-65:+0',
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
		yearRange:'-65:+0',
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
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
					$edit=1;
					$result = $obj_skill->hrmgt_get_single_skill($id);					
				}
			?>
		<div class="panel-body">
        <form name="leave_form" action="" method="post" class="form-horizontal" id="skill_form">
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
				elseif(isset($_REQUEST['id']))
					$employee =$_REQUEST['id'];  
				else 
					$employee = "";
					$employeedata = hrmgt_get_working_user('employee');
					if(!empty($employeedata))
					{
						foreach ($employeedata as $retrive_data){ 
							echo '<option value="'.$retrive_data->ID.'" '.selected($employee,$retrive_data->id).'>'.$retrive_data->display_name.'</option>';
					}
				} ?>
				</select>
			</div>			
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="skill_start"><?php _e(' Skill Start Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="skill_start" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->skill_start)); }elseif(isset($_POST['skill_start'])) echo $_POST['skill_start'];?>" name="skill_start">
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="skill_end"><?php _e('Skill End Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="skill_end" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->skill_end)); }elseif(isset($_POST['skill_end'])) echo $_POST['skill_end'];?>" name="skill_end">
			</div>
		</div>
		
		
		
		
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-4">Skill <span class="require-field">*</span></div>
			<div class="col-md-2">Point</div>
		</div>
		
		<hr>
		<?php if($edit){ 
			$skill =  json_decode($result->skill,true);			
			foreach($skill as $key=>$retrive_datas){	?>
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
						<input id="point" class="form-control text-input" value="<?php print  $retrive_datas; ?>" type="text"  name="point[]">
					</div>						
					<div class="col-sm-2">
						<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
							<i class="entypo-trash"><?php _e('Delete','hr_mgt');?></i>
						</button>
					</div>
				</div>
		</div>	
		
			<?php }
		} else{ ?> 
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
   	}); 

   	function add_entry()
   	{
   		$("#add_skill").append(blank_skill_entry);		
   	}   	
   
   	function deleteParentElement(n){
   		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
   	}
</script>
<?php  } ?>

