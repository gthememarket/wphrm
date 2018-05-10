<script type="text/javascript">
$(document).ready(function() {
	 $('#notice_form').validationEngine();
	  $('#event_Start_date').datepicker({
		  dateFormat:'yy-mm-dd',		 
		  changeMonth: true,
		  changeYear: true,
		  onSelect: function(selected) {
				$("#event_end_date").datepicker("option","minDate", selected)
			}

	  });
	  $('#event_end_date').datepicker({
		  dateFormat:'yy-mm-dd',		  
		  changeMonth: true,
		  changeYear: true,
		  onSelect: function(selected) {
				$("#event_Start_date").datepicker("option","maxDate", selected)
		 }
	  });
} );
</script>
<?php 
 $event_id=0;
	if(isset($_REQUEST['event_id']))
		$event_id=$_REQUEST['event_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;					
					$postdata=get_post($event_id);
				} ?>
       <div class="panel-body"> 
		
	   <form name="class_form" action="" method="post" class="form-horizontal" id="notice_form">
          <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="event_id"   value="<?php if($edit){ echo $event_id;}?>"/> 
		<div class="form-group">
			<label class="col-sm-2 control-label" for="event_title"><?php _e('Event Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="event_title" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $postdata->post_title;}?>" name="event_title">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="notice_content"><?php _e('Event Start Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<input id="event_Start_date" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime(get_post_meta($postdata->ID,'event_start_date',true)));}?>" name="start_date">
				
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="notice_content"><?php _e('Event End Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<input id="event_end_date" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime(get_post_meta($postdata->ID,'event_end_date',true))) ;}?>" name="end_date">
				
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="event_place"><?php _e('Event Place','hr_mgt');?></label>
			<div class="col-sm-8">
			<input id="event_place" class="form-control text-input" type="text" value="<?php if($edit){ echo get_post_meta($postdata->ID,'event_place',true);}?>" name="event_place">
				
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','hr_mgt');?></label>
			<div class="col-sm-8">
			<textarea name="description" class="form-control" id="description"><?php if($edit){ echo $postdata->post_content;}?></textarea>
				
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">        	
        	<input type="submit" value="<?php if($edit){ _e('Save Event','hr_mgt'); }else{ _e('Add Event','hr_mgt');}?>" name="save_event" class="btn btn-success" />
        </div>
         </form>
       </div>
