<?php 
$obj_user=new HrmgtEmployee;
$obj_department=new HrmgtDepartment;
	$id=0;
	$edit=0;
	if(isset($_REQUEST['id']))
		$id=$_REQUEST['id'];
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		$edit=1;
		$user_info = get_userdata($id);				
	}
	?>
		
<div class="panel-body" style="float:left; width:100%">
    <form name="" enctype="multipart/form-data" action="" method="post" class="form-horizontal" id="">		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="department"><?php _e('Department','hr_mgt');?></label>
			<div class="col-sm-8">
				<select class="form-control" name="department" id="department">
					<option value=""><?php _e('Select Department','hr_mgt');?></option>
					<?php 				
					if(isset($_REQUEST['department']))
						$category =$_REQUEST['department'];  
					else 
						$category = "";
					
					$departmentdata=$obj_department->get_all_departments();
					if(!empty($departmentdata))
					{
						foreach ($departmentdata as $retrive_data)
						{
							echo '<option value="'.$retrive_data->id.'" '.selected($category,$retrive_data->id).'>'.$retrive_data->department_name.'</option>';						
						}
					}
					?>
				</select>
			</div>			
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="csv"><?php _e('CSV','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="csv" class="" type="file" name="csv_file" value="">
			</div>
		</div>		
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php  _e('Import Employee','hr_mgt') ?>" name="import_employee" class="btn btn-success"/>
        </div>
    </form>
</div>