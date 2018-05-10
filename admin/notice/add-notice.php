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