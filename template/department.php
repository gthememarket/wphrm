<?php 
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'departmentlist';
$obj_department=new HrmgtDepartment;
$role=hrmgt_get_user_role(get_current_user_id() );
?>
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#department_list').DataTable({
		 responsive: true
	});		
} );
</script>
<?php 
if(isset($_POST['save_department']))
{
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_department->hrmgt_add_department($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=department&tab=departmentlist&message=2');
		}			
	}
	else
	{
		$result=$obj_department->hrmgt_add_department($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=department&tab=departmentlist&message=1');
		}
	}
}

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result=$obj_department->hrmgt_delete_department($_REQUEST['dept_id']);
	if($result)
	{
		wp_redirect ('?hr-dashboard=user&page=department&tab=departmentlist&message=3');
	}
}
if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == 1)
	{ ?>
		<div id="message" class="updated below-h2 msg"><p>
			<?php _e('Department inserted successfully','hr_mgt');?></p>
		</div>
		<?php 
				}
		elseif($message == 2)
		{?>
			<div id="message" class="updated below-h2 msg "><p>
				<?php _e("Department updated successfully.",'hr_mgt'); ?>
			</p></div>
		<?php 			
		}
		elseif($message == 3) 
		{ ?>
		<div id="message" class="updated below-h2 msg"><p>
			<?php _e('Department deleted successfully','hr_mgt'); ?></div></p>
		<?php }	} ?>
		
	<div class="panel-body panel-white">
		<ul class="nav nav-tabs panel_tabs" role="tablist">
			<li class="<?php if($active_tab == 'departmentlist') echo "active";?>">
				<a href="?hr-dashboard=user&page=department&tab=departmentlist">
					<i class="fa fa-align-justify"></i> <?php _e('Department', 'hr_mgt'); ?>
				</a>				
			</li>
	  <?php if($role=="manager"){ ?>
	  <?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){ ?>
			<li class="<?php if($active_tab == 'add_department') echo "active";?>">
			  <a href="?hr-dashboard=user&page=department&tab=add_department">
				 </i> <?php _e('Edit Department', 'hr_mgt'); ?></a>			 
			</li>
	 <?php } else {?>
		<li class="<?php if($active_tab == 'add_department') echo "active";?>">
          <a href="?hr-dashboard=user&page=department&tab=add_department">
             <i class="fa fa-plus-circle"></i> <?php _e('Add Department', 'hr_mgt'); ?></a>
          </a>
      </li>
	 <?php } ?>	   
	  <?php } ?>
	</li>
</ul>
	<div class="tab-content">
    	<?php if($active_tab == 'departmentlist')
		{ ?>
		<div class="panel-body">
        	<div class="table-responsive">
				<table id="department_list" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><?php _e( 'Department Name', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'Department Head', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'Parent Department', 'hr_mgt' ) ;?></th>			
							<?php if($role=="manager"){ ?>
								 <th><?php _e( 'Action', 'hr_mgt' ) ;?></th> 
							  <?php }?>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><?php _e( 'Department Name', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'Department Head', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'Parent Department', 'hr_mgt' ) ;?></th>
							<?php if($role=="manager"){ ?>
								 <th><?php _e( 'Action', 'hr_mgt' ) ;?></th> 
							  <?php }?>
						</tr>					   
					</tfoot>		 
				<tbody>
				 <?php 
				$departmentdata=$obj_department->get_all_departments();
				if(!empty($departmentdata))
				{
					foreach ($departmentdata as $retrieved_data)
					{ ?>
					<tr>
						<?php 
							if($role=="manager"){ ?>
								<td class="name"><a href="?hr-dashboard=user&page=department&tab=add_department&action=edit&dept_id=<?php echo $retrieved_data->id?>" ><?php echo $retrieved_data->department_name;?></a></td>
							<?php }else{ ?>
							 <td class="name"><?php echo $retrieved_data->department_name;?></td>
							<?php } ?>
					   
							<td class="department head">
								<?php  if( $retrieved_data->dept_head_id !=0 ){ 
									echo hrmgt_get_display_name( $retrieved_data->dept_head_id);
								}
								else{
									_e('No Head ',''); 
								}  ?>
							</td>
						<td class="parent head"><?php if($retrieved_data->parent_department_id!=0){	print $result = $obj_department->get_parent_department($retrieved_data->parent_department_id); }else{ _e("No Department","hr_mgt");	} ?></td>
					   
					   <?php if($role =="manager"){?>
					   <td class="action">
							<a href="?hr-dashboard=user&page=department&tab=add_department&action=edit&dept_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
							<a href="?hr-dashboard=user&page=department&tab=departmentlist&action=delete&dept_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
							onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
							<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
							  </td>
					   <?php } ?>					   
					</tr>
					<?php } 					
				} ?>
				</tbody>
				</table>
			</div>
        </div>
		<?php } 
		
if($active_tab=="add_department")
{ ?>
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
		<input type="hidden" name="dept_id" value="<?php echo $dept_id;?>"  />
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
				
					$employeedata = hrmgt_get_working_user('employee');
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

<?php } ?>		
	</div>
</div>