<div class="popup-bg">
    <div class="overlay-content">
		<div class="category_list"></div>
    </div>
</div>
<?php 
$active_tab = isset($_GET['tab'])?$_GET['tab']:'assets_list'; 
$role=hrmgt_get_user_role(get_current_user_id() );
$obj_compansation = new HrmgtCompansation();
if(isset($_POST['assign_asset']))
{
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_compansation->hrmgt_assign_asset($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=asset_benefit&tab=assets_list&message=asset_edit');
		}
	}
	else
	{
		$result=$obj_compansation->hrmgt_assign_asset($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=asset_benefit&tab=assets_list&message=asset_add');
		}
	}
}

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	if(isset($_REQUEST['assign_id']))
	{
		$result=$obj_compansation->hrmgt_delete_assets($_REQUEST['assign_id']);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=asset_benefit&tab=assets_list&message=asset_del');
		}
	}					
}
?>
<?php 
if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == "asset_add")
	{
	?>
		<div id="message" class="updated below-h2 msg "><p><?php _e('Assets inserted successfully','hr_mgt'); ?></p></div>
	<?php 
	}
	elseif($message == "asset_edit")
	{ ?><div id="message" class="updated below-h2 msg "><p><?php _e("Assets updated successfully.",'hr_mgt');?></p></div>
	<?php 
	}
	elseif($message == "asset_del") 
	{ ?>
		<div id="message" class="updated below-h2 msg "><p><?php _e('Assets deleted successfully','hr_mgt');?></p></div>
	<?php
	}	
}
?>
<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">	  
	<li class="<?php if($active_tab=='assets_list'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=asset_benefit&tab=assets_list" class="tab <?php echo $active_tab == 'assets_list' ? 'active' : ''; ?>">
            <i class="fa fa-align-justify"></i> <?php _e('Asset List', 'hr_mgt'); ?></a>       
	</li>
	<?php if($role=="manager"){ ?>
	<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){ ?>
	<li class="<?php if($active_tab=='add_asset'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=asset_benefit&tab=add_asset" class="tab <?php echo $active_tab == 'add_asset' ? 'active' : ''; ?>">
		 <?php _e('Edit Asset', 'hr_mgt'); ?></a>
       </a>
	</li>	
	<?php } else { ?>
	<li class="<?php if($active_tab=='add_asset'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=asset_benefit&tab=add_asset" class="tab <?php echo $active_tab == 'add_asset' ? 'active' : ''; ?>">
		<i class="fa fa-plus-circle"></i> <?php _e('Add Asset', 'hr_mgt'); ?></a>
	</li>		
	<?php } ?>	
	<?php } ?>	 
</ul>
<div class="tab-content">
<?php if($active_tab == 'assets_list') { ?>
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#assets_list').DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
			<?php if($role=='manager'){ ?>{"bSortable": true}, <?php }?>
			
	        {"bSortable": false}]
		});
} );
</script>
<div class="panel-body">
		<div class="table-responsive">
        <table id="assets_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Assets', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Assigned Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Return Date', 'hr_mgt' ) ;?></th>
            <?php if($role=='manager'){ ?> <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th><?php }?>
            </tr>
        </thead>
		<tfoot>
            <tr>
			   <th><?php _e( 'Assets', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Assigned Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Return Date', 'hr_mgt' ) ;?></th>
            <?php if($role=='manager'){ ?> <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th><?php }?>
            </tr>
           
        </tfoot> 
        <tbody>
         <?php 
		$assetsdata=$obj_compansation->get_all_assets();
		if(!empty($assetsdata))
		{
		 	foreach ($assetsdata as $retrieved_data){ ?>
            <tr>
				<?php if($role=="manager"){ ?>
					<td class="assign"><a href="?hr-dashboard=user&page=asset_benefit&tab=add_asset&action=edit&assign_id=<?php echo $retrieved_data->id;?>"><?php echo get_the_title($retrieved_data->asset_id);?></a></td>
				<?php } else{ ?>
					<td class="assign"><?php echo get_the_title($retrieved_data->asset_id);?></td>
				<?php } ?>
				
				<td class="employee"><?php echo hrmgt_get_display_name($retrieved_data->employee_id);?></td>
				<td class="start"><?php echo hrmgt_change_dateformat($retrieved_data->assign_date);?></td>
				<td class="end"><?php echo hrmgt_change_dateformat($retrieved_data->return_date);?></td>
				<?php if($role=="manager"){ ?>
				<td class="action">
				<a href="?hr-dashboard=user&page=asset_benefit&tab=add_asset&action=edit&assign_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
                <a href="?hr-dashboard=user&page=asset_benefit&action=delete&assign_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
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
if($active_tab=="add_asset"){ ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#assets_form').validationEngine();
	 $('#start_date').datepicker({
			dateFormat:'yy-mm-dd',
			changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+0',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
      }); 
	  $('#end_date').datepicker({
			 dateFormat:'yy-mm-dd',
			changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+0',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
      }); 
});
</script>
<?php 	                                 
	$assign_id=0;
	if(isset($_REQUEST['assign_id']))
		$assign_id=$_REQUEST['assign_id'];
	$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		$edit=1;
		$result = $obj_compansation->hrmgt_get_single_assets($assign_id);
	}
?>
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
<?php } ?>

	</div>
</div>