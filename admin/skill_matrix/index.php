<?php 		
$obj_skill=new hrmgtSkillMetrix;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'view_skill';?>
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
if(isset($_POST['save_skill'])){

	if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){
		$result = $obj_skill->hrmgt_add_skill_metrix($_POST);
		if($result){
			wp_redirect ( admin_url().'admin.php?page=hrmgt-skill_matrix&tab=view_skill&message=2');
		}
	}else{
		$result = $obj_skill->hrmgt_add_skill_metrix($_POST);
		if($result){
			wp_redirect ( admin_url().'admin.php?page=hrmgt-skill_matrix&tab=view_skill&message=1');
		}
	}
	
}


if(isset($_REQUEST['message'])){
	$message =$_REQUEST['message'];
	if($message == 1){ ?>
		<div id="message" class="updated below-h2 "><p>	<?php 	_e('Skill insert successfully','hr_mgt');?></p></div>
		<?php }	elseif($message == 2){ ?>
		<div id="message" class="updated below-h2 "><p><?php _e("Skill update successfully.",'hr_mgt');?></p></div>
		<?php } elseif($message == 3) { ?>
			<div id="message" class="updated below-h2"><p>	<?php _e('Skill delete successfully','hr_mgt');	?></div></p>
		<?php } } ?>
	
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
	<h2 class="nav-tab-wrapper">
    	<a href="?page=hrmgt-skill_matrix&tab=view_skill" class="nav-tab <?php echo $active_tab == 'view_skill' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('View Skill', 'hr_mgt'); ?></a>
    	
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{ ?>
        <a href="?page=hrmgt-skill_matrix&tab=add_skill&action=edit" class="nav-tab <?php echo $active_tab == 'add_skill' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Skill', 'hr_mgt'); ?></a>  
		<?php 
		}
		else 
		{ ?>
			<a href="?page=hrmgt-skill_matrix&tab=add_skill" class="nav-tab <?php echo $active_tab == 'add_skill' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Skill Matrix', 'hr_mgt'); ?></a>
		<?php  }?>
    </h2>
     <?php 
if($active_tab == 'view_skill'){ ?>	
<form name="activity_form" action="" method="post">
<div class="panel-body">
<div class="">			
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
			<th><?php _e('Action','hr_mgt'); ?></th>
		<?php }	?>
    </tr>
  </thead>
  <tbody>
  <?php 
	$result = $obj_skill->get_group_employee();
	foreach($result as $retrived_data){ 
		$achive_skiil = json_decode($retrived_data->skill,true);
	?>
    <tr>     
      <th><?php print hrmgt_get_display_name($retrived_data->employee_id); ?></th>      
	<?php	$activity_category=hrmgt_get_all_category('training_skill_cat'); 			
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
	<td><a href="?page=hrmgt-skill_matrix&tab=add_skill&action=edit&id=<?php print $retrived_data->id;?>" class="btn btn-primary"><?php _e('Edit','hr_mgt'); ?></a></td>
<?php } ?>
    </tr>   
  </tbody>
</table>		
</div>
</div>
</form>
<?php  } if($active_tab == 'add_skill')	 {
		require_once HRMS_PLUGIN_DIR.'/admin/skill_matrix/add_skill.php';
	 } ?>
</div>			
	</div>
	</div>
</div>
