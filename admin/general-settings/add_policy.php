<script type="text/javascript">
$(document).ready(function() {
	$('#policy_form').validationEngine();	
});
</script>
     <?php 	                                 
		$policy_id=0;
		if(isset($_REQUEST['policy_id']))
			$policy_id=$_REQUEST['policy_id'];
		$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
				$edit=1;
				$result = $obj_policy->hrmgt_get_single_police($policy_id);
			} ?>
		<div class="panel-body">
        <form name="policy_form" action="" method="post" class="form-horizontal" id="policy_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="policy_id" value="<?php echo $policy_id;?>"  />
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="policy_category"><?php _e('Policy Type','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="policy_type_id" id="policy_cat">
				<option value=""><?php _e('Select Policy Type','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$result->policy_type_id;
				elseif(isset($_REQUEST['policy_type_id']))
					$category =$_REQUEST['policy_type_id'];  
				else 
					$category = "";
				
				$activity_category=hrmgt_get_all_category('policy_cat');
				if(!empty($activity_category))
				{
					foreach ($activity_category as $retrive_data)
					{
						echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
					}
				} ?>
				</select>
			</div>
			<div class="col-sm-2"><button id="addremove" model="policy_cat"><?php _e('Add Or Remove','hr_mgt');?></button></div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="policy_title"><?php _e('Policy Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="policy_title" class="form-control validate[required]" type="text"  name="policy_title" 
				value="<?php if($edit){ echo $result->policy_title;}elseif(isset($_POST['policy_title'])) echo $_POST['policy_title'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<textarea id="description" class="form-control validate[required]" name="description"><?php if($edit){echo $result->description; }elseif(isset($_POST['description'])) echo $_POST['description']; ?> </textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="status"><?php _e('Status','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php $statusval = "1"; if($edit){ $statusval=$result->status; }elseif(isset($_POST['status'])) {$statusval=$_POST['status'];}?>
				<label class="radio-inline">
					<input type="radio" value="1" class="tog" name="status"  <?php  checked( '1', $statusval);  ?>/><?php _e('Active','hr_mgt');?>
			    </label>
			    <label class="radio-inline">
					<input type="radio" value="0" class="tog" name="status"  <?php  checked( '0', $statusval);  ?>/><?php _e('Deactive','hr_mgt');?> 
			    </label>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Policy','hr_mgt');}?>" name="save_policy" class="btn btn-success"/>
        </div>
		</form>
</div>