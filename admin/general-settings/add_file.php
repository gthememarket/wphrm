<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#file_form').validationEngine();
	$("#doc_for").multiselect();
	
	$('#added_date').datepicker({
		  changeMonth: true,
		  dateFormat: 'yy-mm-dd',
	        changeYear: true,
	        yearRange:'-65:+0',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	    }
	});
	
});
</script>
     <?php 	                                 
			$file_id=0;
			if(isset($_REQUEST['file_id']))
				$file_id=$_REQUEST['file_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$result = $obj_file->hrmgt_get_single_file($file_id);
					$filemeta =  $obj_file->hrmgt_get_single_file_data($file_id);
					
					foreach($filemeta as $key=>$val){
						$doc_for[] = $val->doc_for;
					}

					
				} ?>
		<div class="panel-body">
        <form name="file_form" id="file_form" action="" method="post" class="form-horizontal" enctype="multipart/form-data">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="file_id" value="<?php echo $file_id;?>"  />
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="holiday_title"><?php _e('Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="title" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $result->title;}elseif(isset($_POST['title'])) echo $_POST['title'];?>" name="title">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="holiday_title"><?php _e('Added Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="added_date" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $result->added_date;}elseif(isset($_POST['added_date'])) echo $_POST['added_date'];?>" name="added_date">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="class_name"><?php _e('Document For','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">                   
                <select name="doc_for[]"  class="form-control validate[required] " id="doc_for" multiple required > 					
					<option value="employee" <?php if($edit){ if(in_array('employee',$doc_for)){ print "selected";}} ?>><?php _e('Employee','hr_mgt');?></option>
					<option value="manager" <?php if($edit){ if(in_array('manager',$doc_for)){ print "selected";}} ?> ><?php _e('HR Manager','hr_mgt');?></option>							
					<option value="accountant" <?php if($edit){ if(in_array('accountant',$doc_for)){ print "selected";}} ?>><?php _e('Accountant','hr_mgt');?></option>							
                </select>				 
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="description" class="form-control" name="description"><?php if($edit){echo $result->description; }elseif(isset($_POST['description'])) echo $_POST['description']; ?> </textarea>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="document"><?php _e('File','hr_mgt');?></label>
			
			<div class="col-sm-6">
				<input type="file" class="form-control file" name="file" >
				<input type="hidden" name="hidden_file" value="<?php if($edit){ echo $result->file;}elseif(isset($_POST['file'])) echo $_POST['file'];?>">
				<p class="help-block"><?php _e('Upload document in PDF','hr_mgt');?></p> 
			</div>
			<div class="col-sm-2">
				<?php if(isset($result->file) && $result->file!=""){?>
				<a href="<?php echo content_url().'/uploads/hr_assets/'.$result->file;?>" class="btn btn-default"><i class="fa fa-download"></i> <?php _e('File','hr_mgt');?></a>
				<?php } ?>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add File','hr_mgt');}?>" name="save_file" class="btn btn-success"/>
        </div>
		</form>
</div>