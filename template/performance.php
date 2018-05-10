<?php 
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'performance_list';
$obj_par_mark = new HrmgtParfomanceMark();
$obj_project=new HrmgtProject;
$role=hrmgt_get_user_role(get_current_user_id() );
?>
 <script type="text/javascript">
$(document).ready(function() {
	jQuery('#performance_mark_list').DataTable({
		"responsive": true,
	});
		$('#employees').multiselect({
		includeSelectAllOption: true,
		disableIfEmpty: true
		
	});	
	
	$('#period_start').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange:'-65:+0',
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
	        yearRange:'-65:+0',
			dateFormat: 'yy-mm-dd',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        },
			onSelect: function(selected) {
				$("#period_start").datepicker("option","maxDate", selected)
			}
	  });
} );
</script>
<?php 
if(isset($_POST['save_perfomance_marks']))
{
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_par_mark->hrmgt_add_parfomance_marks($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=performance&tab=performance_list&message=2');
		}
	}
	else{
		
		$result=$obj_par_mark->hrmgt_add_parfomance_marks($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=performance&tab=performance_list&message=1');
		}
	}
}
	
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result=$obj_par_mark->hrmgt_delete_parfomance_marks($_REQUEST['parfomance_id']);
	if($result)
	{
		wp_redirect ('?hr-dashboard=user&page=performance&tab=performance_list&message=3');
	}
}
	if(isset($_REQUEST['message']))	{
		$message =$_REQUEST['message'];
		if($message == 1)
		{ ?>
			<div id="message" class="updated below-h2 msg ">
				<p><?php _e('Perfomance Marks insert successfully','hr_mgt');?></p>
			</div>
		<?php 
		}
		elseif($message == 2){ ?>
			<div id="message" class="updated below-h2 msg ">
				<p><?php _e("Perfomance Marks update successfully.",'hr_mgt');?></p></div>
			<?php 				
			}
			elseif($message == 3) 
			{ ?>
				<div id="message" class="updated below-h2 msg ">
					<p><?php _e('Perfomance Marks delete successfully','hr_mgt');?></div></p>
			<?php					
			}
		}
?>
<div class="popup-bg" style="display: none; height: 1251px;">
	<div class="overlay-content">
		<div class="category_list"></div>    
	</div> 
</div>

<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">	  
	  	<li class="<?php if($active_tab=='performance_list'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=performance&tab=performance_list" class="tab <?php echo $active_tab == 'performance_list' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Performance Marks List', 'hr_mgt'); ?></a>
          </a>
		</li>
		<?php 
		if($role=="manager"){ ?>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){ ?>
		<li class="<?php if($active_tab=='add_performance'){?>active<?php }?>">		
			<a href="?hr-dashboard=user&page=performance&tab=add_performance" class="tab <?php echo $active_tab == 'add_performance' ? 'active' : ''; ?>">
            <?php _e('Edit performance Marks ', 'hr_mgt'); ?></a>
          </a>
		</li>	
		<?php } else { ?>
		<li class="<?php if($active_tab=='add_performance'){?>active<?php }?>">		
			<a href="?hr-dashboard=user&page=performance&tab=add_performance" class="tab <?php echo $active_tab == 'add_performance' ? 'active' : ''; ?>">
             <i class="fa fa-plus-circle"></i> <?php _e('Add Performance Marks ', 'hr_mgt'); ?></a>
          </a>
		</li>		
			
		<?php }?>
		
		<?php }	?>
</ul>

	<div class="tab-content">
    	<?php if($active_tab == 'performance_list')
		{ ?>
		<div class="">
		<form name="activity_form" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="performance_mark_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Project', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Title', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Marks', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			 <th><?php _e( 'Project', 'hr_mgt' ) ;?></th>			  
			 <th><?php _e( 'Title', 'hr_mgt' ) ;?></th>			  
			   <th><?php _e( 'Marks', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
           
        </tfoot>
 
        <tbody>
         <?php 
		 if($role=="manager"){
			$parfomancedata=$obj_par_mark->get_all_parfomance_marks(); 
		 }
		 else{
			$id = get_current_user_id();
		    $parfomancedata=$obj_par_mark->get_all_parfomance_marks_of_user($id);
		 }
		  
		 if(!empty($parfomancedata)){
		 	foreach ($parfomancedata as $retrieved_data){ ?>
            <tr>
			<td class="title"><?php echo hrmgt_get_project_title($retrieved_data->project_id);?></td>
			<?php 
			if($role=="manager"){ ?>
				<td class="title"><a href="?hr-dashboard=user&page=performance&tab=add_performance&action=edit&parfomance_id=<?php echo $retrieved_data->id?>"><?php echo $retrieved_data->title;?></a></td>
			<?php } else{ ?>
				<td class="title"><?php echo $retrieved_data->title;?></td>
			<?php } ?>
				<td class="employee"><?php echo $retrieved_data->mark;?></td>
				<td class="description"><?php echo wp_trim_words($retrieved_data->description,3,'...');?></td>
				<td class="action">
					<a href="#" class="btn btn-primary view-perfomance-mark" id="<?php echo $retrieved_data->id;?>"> <?php _e('View','apartment_mgt');?></a>             	
					<?php if($role=="manager"){ ?> 
					<a href="?hr-dashboard=user&page=performance&tab=add_performance&action=edit&parfomance_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
					<a href="?hr-dashboard=user&page=performance&tab=performance_list&action=delete&parfomance_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
					onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
					<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
					<?php } ?>
                 </td>
             </tr>
            <?php } } ?>
		</tbody>
        </table>
        </div>
        </div>
</form>
        </div>
        </div>
		<?php } ?>	
<?php if($active_tab=="add_performance"){ ?> 
<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#perfomance_form').validationEngine();
	
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
			<select class="form-control  employees" id="employees" name="employee_id[]" Multiple required="required">				
				<?php
				if ($edit)
				{
					$employee = "";				
					$employeedata = hrmgt_get_working_user('employee');
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
				<input id="mark" class="form-control  text-input" type="text" value="<?php if($edit){ echo $result->mark;}elseif(isset($_POST['mark'])) echo $_POST['mark'];?>" name="mark">
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
<?php }?>
	</div>
</div>