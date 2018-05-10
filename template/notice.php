<?php $active_tab = isset($_GET['tab'])?$_GET['tab']:'noticelist'; ?>
<?php
$role = hrmgt_get_user_role(get_current_user_id());

if(isset($_POST['save_notice']))
{
	if($_POST['action']=='edit')
	{
		$args = array(
			'ID'           => $_REQUEST['notice_id'],
			'post_title'   => $_REQUEST['notice_title'],
			'post_content' =>  $_REQUEST['notice_content'],
		);
		$result1=wp_update_post( $args );
		$result2=update_post_meta($_REQUEST['notice_id'], 'notice_for', $_REQUEST['notice_for']);
		$result3=update_post_meta($_REQUEST['notice_id'], 'start_date',$_REQUEST['notice_start_date']);
		$result3=update_post_meta($_REQUEST['notice_id'], 'end_date',$_REQUEST['notice_end_date']);
		if($result1)
		{
			wp_redirect ('?hr-dashboard=user&page=notice&tab=noticelist&message=2');
		}
	}
	else
	{		
		$args = array(
			'ID'           => $_POST['notice_id'],
			'post_title'   => $_POST['notice_title'],
			'post_type' => 'hrmgt_notice',
			'post_status' => 'publish',
			'post_content' => $_POST['notice_content'],
		);		
		
		$result1=wp_insert_post( $args );	
		$result2=add_post_meta($result1, 'notice_for', $_POST['notice_for']);			
		$result3=add_post_meta($result1, 'start_date',$_POST['notice_start_date']);			
		$result4=add_post_meta($result1, 'end_date',$_POST['notice_end_date']);		
		if($result1)
		{
			wp_redirect ('?hr-dashboard=user&page=notice&tab=noticelist&message=1');
		}
	}
}
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
{
	$result=wp_delete_post($_REQUEST['notice_id']);
	if($result)
	{ 
		wp_redirect ('?hr-dashboard=user&page=notice&tab=noticelist&message=3');
	}
}


if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == 1)
	{ ?>
		<div id="message" class="updated below-h2  msg ">
			<p><?php _e('Notice inserted successfully','hr_mgt');?></p>
		</div>
	<?php 
	}
	
	elseif($message == 2)
	{ ?> 
		<div id="message" class="updated below-h2 msg ">
			<p><?php _e("Notice updated successfully.",'hr_mgt');?></p>
		</div>
	<?php 
	}
	elseif($message == 3) { ?>
		<div id="message" class="updated below-h2 msg ">
			<p><?php _e('Notice deleted successfully','hr_mgt');?></div></p>
	<?php				
	}
	
}

?>	
<div class="popup-bg">
    <div class="overlay-content">   
    	<div class="notice_content"></div>    
    </div>     
</div>	
<div class="panel-body panel-white">
 
		<ul class="nav nav-tabs panel_tabs" role="tablist">	  
	 <li class="<?php if($active_tab=='noticelist'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=notice&tab=noticelist" class="tab <?php echo $active_tab == 'noticelist' ? 'active' : ''; ?>">
            <i class="fa fa-align-justify"></i> <?php _e('Notice List', 'hr_mgt'); ?></a>
        </a>
	</li>
	<?php if($role=="manager") { ?>	
	<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){ ?>
	<li class="<?php if($active_tab=='addnotice'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=notice&tab=addnotice" class="tab <?php echo $active_tab == 'addnotice' ? 'active' : ''; ?>"><?php _e('Edit Notice', 'hr_mgt'); ?></a>
      
	</li>
	<?php } else { ?>
		<li class="<?php if($active_tab=='addnotice'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=notice&tab=addnotice" class="tab <?php echo $active_tab == 'addnotice' ? 'active' : ''; ?>"> <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _e('Add Notice', 'hr_mgt'); ?>
			 </a>          
		</li>
			
	<?php } } ?>
</ul>
<?php	
if($active_tab == 'noticelist')
{	
?>	  
<div class="panel-body">
<script>
jQuery(document).ready(function() {
	var table =  jQuery('#notice_list').DataTable({
        responsive: true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[	                  
	         {"bSortable": false},	                 
	         {"bSortable": true},
	         {"bSortable": true},
	         {"bSortable": true},	        
	       <?php if($role=='manager'){ ?>  {"bSortable": true},<?php } ?>	                 
	         {"bSortable": false}],		
	});
});
</script>
<div class="table-responsive">
	<form id="frm-example" name="frm-example" method="post">	
        <table id="notice_list" class="display" cellspacing="0" width="100%">
        <thead>
            <tr> 			   
                <th width="190px"><?php _e('Notice Title','hr_mgt');?></th>
                <th><?php _e('Notice Comment','hr_mgt');?></th>
                <th><?php _e('Notice Start Date','hr_mgt');?></th>
				<th><?php _e('Notice End Date','hr_mgt');?></th>               
                <th><?php _e('Notice For','hr_mgt');?></th>
               <?php if($role=='manager'){ ?> <th width="185px"><?php _e('Action','hr_mgt');?></th><?php } ?>               
            </tr>
        </thead> 
        <tfoot>
            <tr>				
            	<th><?php _e('Notice Title','hr_mgt');?></th>
                <th><?php _e('Notice Comment','hr_mgt');?></th>
                <th><?php _e('Notice Start Date','hr_mgt');?></th>
				<th><?php _e('Notice End Date','hr_mgt');?></th>
                <th><?php _e('Notice For','hr_mgt');?></th>                
              <?php if($role=='manager'){ ?>  <th><?php _e('Action','hr_mgt');?></th>  <?php } ?>      
            </tr>
        </tfoot>
			<?php $NoticeData  = get_role_wise_notice($role);	?>
		<tbody>
			<?php 
			if(!empty($NoticeData)){
				foreach($NoticeData as $notice)
				{   ?>
			<tr>
				<td><?php _e($notice->post_title	 ,'hr_mgt');?></td>
				<td><?php _e($notice->post_content,'hr_mgt');?></td>
				<td><?php print hrmgt_change_dateformat(get_post_meta($notice->ID,'start_date',true));?></td>
				<td><?php print hrmgt_change_dateformat(get_post_meta($notice->ID,'end_date',true));?></td>
				<td><?php print ucwords(str_replace("_",' ',get_post_meta($notice->ID,'notice_for',true)));?></td>			
				<?php if($role=='manager'){ ?>
				<td>
					<!--<a href="#" class="btn btn-primary view-event" id="<?php echo $notice->ID;?>"> <?php _e('View','hr_mgt');?></a>-->
					<a href="?hr-dashboard=user&page=notice&tab=addnotice&action=edit&notice_id=<?php echo $notice->ID?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
					<a href="?hr-dashboard=user&page=notice&tab=noticelist&action=delete&notice_id=<?php echo $notice->ID;?>" class="btn btn-danger" 
					onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
					<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
				
				</td>  
				<?php } ?>
			</tr>
			<?php } } ?>					
        </tbody>
     </table>
	</form>
</div>
</div>
<?php  }
if($active_tab == 'addnotice')
{ ?>
<script type="text/javascript">
$(document).ready(function() {
	 $('#notice_form').validationEngine();
	 $('#notice_start_date').datepicker({
		 dateFormat:'yy-mm-dd',
		 changeYear: true,
		 changeMonth: true,
		 onSelect: function(selected) {
			$("#notice_end_date").datepicker("option","minDate", selected)
		}
	});
	$('#notice_end_date').datepicker({
		dateFormat:'yy-mm-dd',
		changeYear: true,
		changeMonth: true,
		 onSelect: function(selected) {
			$("#notice_start_date").datepicker("option","maxDate", selected)
		}
	});
} );
</script>
<?php  
	$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		$edit=1;
		$post = get_post($_REQUEST['notice_id']);
	}
?>
   <div class="panel-body"> 
    <form name="class_form" action="" method="post" class="form-horizontal" id="notice_form">
    <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
	<input type="hidden" name="action" value="<?php echo $action;?>">
    <div class="form-group">
		<label class="col-sm-2 control-label" for="notice_title"><?php _e('Notice Title','hr_mgt');?><span class="require-field">*</span></label>
		<div class="col-sm-8">
			<input id="notice_title" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $post->post_title;}?>" name="notice_title">
			<input type="hidden" name="notice_id"   value="<?php if($edit){ echo $post->ID;}?>"/> 
		</div>
	</div>
	
	 <div class="form-group">
		<label class="col-sm-2 control-label" for="notice_start_date"><?php _e('Start Date','hr_mgt');?><span class="require-field">*</span></label>
		<div class="col-sm-8">
			<input id="notice_start_date" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo get_post_meta($post->ID,'start_date',true); }?>" name="notice_start_date">			
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="notice_end_date"><?php _e('End Date','hr_mgt');?><span class="require-field">*</span></label>
		<div class="col-sm-8">
			<input id="notice_end_date" class="form-control  validate[required] text-input" type="text" value="<?php if($edit){ echo get_post_meta($post->ID,'end_date',true);}?>" name="notice_end_date">			
		</div>
	</div>
	
	
		<div class="form-group">
			<label class="col-sm-2 control-label" for="notice_for"><?php _e('Notice For','hr_mgt');?></label>
			<div class="col-sm-8">
			 <select name="notice_for" id="notice_for" class="form-control">
                 <option value = "all"><?php _e('All','hr_mgt');?></option>
                  <option value="employee" <?php if($edit) echo selected(get_post_meta( $post->ID, 'notice_for',true),'employee');?>><?php _e('Employee','hr_mgt');?></option>
                  <option value="hr_manager" <?php if($edit) echo selected(get_post_meta( $post->ID, 'notice_for',true),'hr_manager');?>><?php _e('HR Manager','hr_mgt');?></option>
                 <option value="accountant" <?php if($edit) echo selected(get_post_meta( $post->ID, 'notice_for',true),'accountant');?>><?php _e('Accountant','hr_mgt');?></option>                
            </select>
			</div>
		</div>	
		<div class="form-group">
			<label class="col-sm-2 control-label" for="notice_content"><?php _e('Notice Comment','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea name="notice_content" class="form-control" id="notice_content"><?php if($edit){ echo $post->post_content;}?></textarea>				
			</div>
		</div>
	
		
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php if($edit){ _e('Save Notice','hr_mgt'); }else{ _e('Add Notice','hr_mgt');}?>" name="save_notice" class="btn btn-success" />
        </div>
    
        </form>
       </div>
<?php }
?>
</div>