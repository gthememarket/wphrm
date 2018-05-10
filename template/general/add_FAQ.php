<script type="text/javascript">
$(document).ready(function() {
	$('#FAQ_form').validationEngine();	
});
</script>
     <?php 	                                 
			$FAQ_id=0;
			if(isset($_REQUEST['FAQ_id']))
				$FAQ_id=$_REQUEST['FAQ_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$result = $obj_policy->hrmgt_get_single_faq($FAQ_id);
				} ?>
		<div class="panel-body">
        <form name="FAQ_form" action="" method="post" class="form-horizontal" id="FAQ_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="FAQ_id" value="<?php echo $FAQ_id;?>"  />
	
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="FAQ_title"><?php _e('FAQ Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="title" class="form-control validate[required]" type="text"  name="title" 
				value="<?php if($edit){ echo $result->title;}elseif(isset($_POST['title'])) echo $_POST['title'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<textarea id="description" class="form-control validate[required]" name="description"><?php if($edit){echo $result->description; }elseif(isset($_POST['description'])) echo $_POST['description']; ?> </textarea>
			</div>
		</div>
		
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add FAQ','hr_mgt');}?>" name="save_FAQ" class="btn btn-success"/>
        </div>
		</form>
</div>