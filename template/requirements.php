<?php 
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'requirements_list';
$obj_requirements = new HrmgtRequirements();
if(isset($_POST['save_job']))
{
		
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_requirements->hrmgt_add_job($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=requirements&tab=requirements_list&message=edit_job');
		}
	}
	else
	{
		$result=$obj_requirements->hrmgt_add_job($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=requirements&tab=requirements_list&message=add_job');
		}
	}
}
	
	
if(isset($_POST['save_candidate']))
{
	if(isset($_FILES['bio_data']) && !empty($_FILES['bio_data']) && $_FILES['bio_data']['size'] !=0)
	{
		if($_FILES['bio_data']['size'] > 0)
			$upload_docs=hrmgt_load_documets($_FILES['bio_data'],'bio_data','doc1');
	}
	else
	{
		if(isset($_REQUEST['hidden_bio_data']))
			$upload_docs=$_REQUEST['hidden_bio_data'];
	}
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_requirements->hrmgt_apply_candidates($_POST,$upload_docs);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=requirements&tab=candidate_list&message=edit_can');
		}
	}
	else
	{
		$result=$obj_requirements->hrmgt_apply_candidates($_POST,$upload_docs);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=requirements&tab=candidate_list&message=add_can');
		}
	}
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	if(isset($_REQUEST['candidate_id']))
	{
		$result=$obj_requirements->hrmgt_delete_candidates($_REQUEST['candidate_id']);
		if($result)	{
			wp_redirect ('?hr-dashboard=user&page=requirements&tab=candidate_list&message=del_can');
		}
	}
	else
	{
		$result=$obj_requirements->hrmgt_delete_posted_job($_REQUEST['job_id']);
		if($result){
			wp_redirect ('?hr-dashboard=user&page=requirements&tab=requirements_list&message=del_job');
		}
	}
}
	if(isset($_REQUEST['message'])){
		$message =$_REQUEST['message'];
	if($message == "add_job"){ ?>
		<div id="message" class="updated below-h2 msg "><p>	<?php 	_e('Job inserted successfully','hr_mgt');?></p></div>
		<?php } ?>
		<?php if($message == "add_can") {?>
			<div id="message" class="updated below-h2 msg "><p><?php _e("Candidate insert  successfully.",'hr_mgt');?></p></div>
		<?php } ?>
		<?php if($message == "edit_job") { ?>
			<div id="message" class="updated below-h2 msg "><p><?php _e('Job updated successfully','hr_mgt');	?></div></p>
		<?php } ?>
		<?php if($message == "edit_can") { ?>
			<div id="message" class="updated below-h2 msg "><p><?php _e('Candidate updated  successfully','hr_mgt');	?></div></p>
		<?php } ?>
		<?php if($message == "del_can") { ?>
			<div id="message" class="updated below-h2 msg "><p><?php _e('Candidate deleted  successfully','hr_mgt');	?></div></p>
		<?php } ?>
		<?php if($message == "del_job") { ?>
			<div id="message" class="updated below-h2 msg "><p><?php _e('Job deleted  successfully','hr_mgt');	?></div></p>
		<?php } ?>
		
		<?php } ?>

 <script type="text/javascript">
$(document).ready(function() {
	jQuery('#job_list').DataTable({
		"responsive": true,
	});
} );
</script>
<div class="popup-bg" style="display: none; height: 1251px;">
	<div class="overlay-content">
	<div class="category_list"></div>    
	</div> 
</div>

<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">	  
	  	<li class="<?php if($active_tab=='requirements_list'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=requirements&tab=requirements_list" class="tab <?php echo $active_tab == 'requirements_list' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Job List', 'hr_mgt'); ?></a>
          </a>
		</li>
		<?php if($role=="manager"){ ?> 		
		<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['job_id'])) {?>
			<li class="<?php if($active_tab=='add_job'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=requirements&tab=add_jobaction=edit&job_id=<?php print $_REQUEST['job_id']; ?>" class="tab <?php echo $active_tab == 'add_job' ? 'active' : ''; ?>">
              <i class="fa fa-plus-circle"></i> <?php _e('Edit Job', 'hr_mgt'); ?></a>
			</a>
			</li>
		<?php } else{ ?> 
			<li class="<?php if($active_tab=='add_job'){?>active<?php }?>">
				<a href="?hr-dashboard=user&page=requirements&tab=add_job" class="tab <?php echo $active_tab == 'add_job' ? 'active' : ''; ?>">
				  <i class="fa fa-plus-circle"></i> <?php _e('Add  Job', 'hr_mgt'); ?></a>
				</a>
			</li>
		<?php }  ?>
		
		<li class="<?php if($active_tab=='candidate_list'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=requirements&tab=candidate_list" class="tab <?php echo $active_tab == 'candidate_list' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Candidate List', 'hr_mgt'); ?></a>
          </a>
		</li>
		
		
		
		
		<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['candidate_id'])) {?>
		<li class="<?php if($active_tab=='add_candidate'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=requirements&tab=add_candidateaction=edit&candidate_id=<?php print $_REQUEST['candidate_id'] ?>" class="tab <?php echo $active_tab == 'add_candidate' ? 'active' : ''; ?>">
             <?php _e('Edit Candidate', 'hr_mgt'); ?></a>
          </a>
		</li>
		<?php } else{ ?> 
			
		<li class="<?php if($active_tab=='add_candidate'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=requirements&tab=add_candidate" class="tab <?php echo $active_tab == 'add_candidate' ? 'active' : ''; ?>">
             <i class="fa fa-plus-circle"></i> <?php _e('Add Candidate', 'hr_mgt'); ?></a>
          </a>
		</li>
		<?php }  ?>
			
		<?php } ?>
	 
</ul>

	<div class="">
    	<?php if($active_tab == 'requirements_list')
		{ ?>
		<div class="">
		    <form name="activity_form" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="job_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Job Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Department', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Designation', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'No of Positions', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Job Post Closing Date', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			  <th><?php _e( 'Job Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Department', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Designation', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'No of Positions', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Job Post Closing Date', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </tfoot>
 
        <tbody>
         <?php 
			$psotedjobdata=$obj_requirements->get_all_posted_job();
		 if(!empty($psotedjobdata))
		 {
		 	foreach ($psotedjobdata as $retrieved_data){ ?>
            <tr>
				<?php if($role=="manager"){  ?>
					<td class="title"><a href="?hr-dashboard=user&page=requirements&tab=add_job&action=edit&job_id=<?php echo $retrieved_data->id;?> "><?php echo $retrieved_data->job_title; ?></a></td>
				<?php }else { ?>
					<td class="title"><?php echo $retrieved_data->job_title;?></td>				
				<?php } ?>
				
				<td class="purpose"><?php echo hrmgt_get_department_name($retrieved_data->department_id);?></td>
				<td class="start"><?php echo get_the_title($retrieved_data->designation);?></td>
				<td class="start"><?php echo $retrieved_data->positions;?></td>
				<td class="end"><?php echo hrmgt_change_dateformat($retrieved_data->closing_date);?></td>
				<td class="end"><?php $retrieved_data->status=='1'?print 'Open': print 'Close';?></td>
				<td class="action">
					<a href="#" id="<?php print $retrieved_data->id ?>" class="btn btn-primary view-requirements" >View</a>
                <?php if($role=="manager"){?> 
					<a href="?hr-dashboard=user&page=requirements&tab=add_job&action=edit&job_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
					<a href="?hr-dashboard=user&page=requirements&tab=requirements_list&action=delete&job_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
					onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
					<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
				<?php } ?>
				</td>
             </tr>
            <?php } 
			
		} ?>
		</tbody>
        </table>
        </div>
        </div>
</form>
        </div>
        </div>
		<?php } ?>	
<?php if($active_tab=="add_job"){ ?>
<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#job_form').validationEngine();
		$('#closing_date').datepicker({
			dateFormat:'yy-mm-dd',
			changeMonth: true,
	        changeYear: true,
			minDate:0,
	        yearRange:'-65:+65',
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
				$obj_department = new HrmgtDepartment();
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
				if($edit)
				{
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
				<input id="closing_date" class="form-control text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->closing_date));}elseif(isset($_POST['closing_date'])) echo $_POST['closing_date'];?>" name="closing_date">
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
			if(!empty($all_criere)){
				foreach($all_criere as $criere){ ?>
				<div id="criere_entry">
			<div class="form-group">
			<label class="col-sm-2 control-label" for="income_entry"><?php _e('Crierearea ','hr_mgt');?><span class="require-field">*</span></label>
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
<?php } ?>
<?php 
if($active_tab=="candidate_list"){
	require_once HRMS_PLUGIN_DIR.'/template/requirment/'.$active_tab.'.php';
}
if($active_tab=="add_candidate"){
	require_once HRMS_PLUGIN_DIR.'/template/requirment/'.$active_tab.'.php';
}
if($active_tab=="shortlist_candidates"){
	require_once HRMS_PLUGIN_DIR.'/template/requirment/'.$active_tab.'.php';
}
?>
</div>