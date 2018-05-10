<?php 		
$obj_department=new HrmgtDepartment;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'department_list';?>
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>
		</div>
    </div> 
</div>

<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?>
		</h3>
	</div>
<?php 
	if(isset($_POST['save_department']))		
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{				
			$result=$obj_department->hrmgt_add_department($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-department&tab=department_list&message=2');
			}			
		}
		else
		{		
			$result=$obj_department->hrmgt_add_department($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-department&tab=department_list&message=1');
			}
		}
	}
	
		
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			$result=$obj_department->hrmgt_delete_department($_REQUEST['dept_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-department&tab=department_list&message=3');
			} 
		}
		
		if(isset($_REQUEST['message']))
		{
			$message =$_REQUEST['message'];
			if($message == 1){ ?>
				<div id="message" class="updated below-h2 "><p>	<?php _e('Department successfully inserted ','hr_mgt');	?></p></div>
		<?php 			
		}
		elseif($message == 2){ ?>
			<div id="message" class="updated below-h2 "><p><?php _e("Department updated successfully.",'hr_mgt'); ?></p></div>
		<?php 			
		}
		elseif($message == 3){ ?>
			<div id="message" class="updated below-h2"><p><?php _e('Department deleted successfully','hr_mgt');	?></div></p><?php				
		}
	}
	?>
	
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
	<h2 class="nav-tab-wrapper">
    	<a href="?page=hrmgt-department&tab=department_list" class="nav-tab <?php echo $active_tab == 'department_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Department List', 'hr_mgt'); ?></a>
    	
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{ ?>
        <a href="?page=hrmgt-department&tab=add_department&action=edit&dept_id=<?php echo $_REQUEST['dept_id'];?>" class="nav-tab <?php echo $active_tab == 'add_department' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Department', 'hr_mgt'); ?></a>  
		<?php 
		}
		else 
		{ ?>
			<a href="?page=hrmgt-department&tab=add_department" class="nav-tab <?php echo $active_tab == 'add_department' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Department', 'hr_mgt'); ?></a>
		<?php  }?>
    </h2>
     <?php 
	
	if($active_tab == 'department_list')
	{ ?>	
    <script type="text/javascript">
	$(document).ready(function() {
		jQuery('#department_list').DataTable({
			"responsive": true,
			"order": [[ 0, "asc" ]],
			/* "bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": ajaxurl+'?action=datatable_department_ajax_to_load',
			"bDeferRender": true, */
			"aoColumns":[
			  {"bSortable": true},
			  {"bSortable": true},
			  {"bSortable": true},
			  {"bSortable": false}]
			});
	} );
	</script>
    <form name="activity_form" action="" method="post">
    
    <div class="panel-body">
       <div class="table-responsive">
        <table id="department_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
				<th><?php _e( 'Department Name', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Department Head', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Parent Department', 'hr_mgt' ) ;?></th>
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
				<th><?php _e( 'Department Name', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Department Head', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Parent Department', 'hr_mgt' ) ;?></th>
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>           
        </tfoot> 
      <tbody>
         <?php 
		$departmentdata=$obj_department->get_all_departments();
		if(!empty($departmentdata))
		{
		 	foreach ($departmentdata as $retrieved_data){ ?>
            <tr>				
                <td class="name"><a href="?page=hrmgt-department&tab=add_department&action=edit&dept_id=<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->department_name;?></a></td>
				<td class="department head"><?php if($retrieved_data->dept_head_id!=0){ echo hrmgt_get_display_name($retrieved_data->dept_head_id);} else{ _e('No Head ','hr_mgt'); }?></td>
				<td class="parent head"><?php if($retrieved_data->parent_department_id!=0){ echo get_parent_dept_name($retrieved_data->parent_department_id);}else{ _e("No Department","hr_mgt"); }?></td>
                <td class="action">
              	<a href="?page=hrmgt-department&tab=add_department&action=edit&dept_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
                <a href="?page=hrmgt-department&tab=department_list&action=delete&dept_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
                <?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
                 </td>               
            </tr>
            <?php } 			
		} ?>
		</tbody>
        </table>
        </div>
        </div>
</form>
     <?php 
	 }
	
	if($active_tab == 'add_department')
	 {
		require_once HRMS_PLUGIN_DIR.'/admin/department/add_department.php';
	 }
	 ?>
</div>			
	</div>
	</div>
</div>
