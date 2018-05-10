<script type="text/javascript">
$(document).ready(function() {
	$('#holiday_form').validationEngine();
	$('#start_date').datepicker({
			changeMonth: true,
			dateFormat: 'yy-mm-dd',
	        changeYear: true,
	        yearRange:'-10:+10',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        },
			onSelect: function(selected) {
				$("#end_date").datepicker("option","minDate", selected)
			}
      }); 
	 $('#end_date').datepicker({
			changeMonth: true,
	        changeYear: true,
			dateFormat: 'yy-mm-dd',
	        yearRange:'-10:+10',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        },
			onSelect: function(selected) {
				$("#start_date").datepicker("option","maxDate", selected)
			}
      }); 
});
</script>
     <?php 	                                 
			$holiday_id=0;
			if(isset($_REQUEST['holiday_id']))
				$holiday_id=$_REQUEST['holiday_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$result = $obj_holiday->hrmgt_get_single_holidays($holiday_id);
					
				} ?>
		<div class="panel-body">
        <form name="holiday_form" action="" method="post" class="form-horizontal" id="holiday_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="holiday_id" value="<?php echo $holiday_id;?>"  />
		<div class="form-group">
			<label class="col-sm-2 control-label" for="holiday_title"><?php _e('Holiday Title','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="holiday_title" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $result->holiday_title;}elseif(isset($_POST['holiday_title'])) echo $_POST['holiday_title'];?>" name="holiday_title">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="start_date"><?php _e('Holiday Start Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="start_date" class="form-control validate[required]" type="text"  name="start_date" 
				value="<?php if($edit){ echo $result->start_date;}elseif(isset($_POST['start_date'])) echo $_POST['start_date'];?>">
			</div>
		</div>
		
		<?php 
			if($edit){ ?>
				<input id="hidden_start_date" class="form-control " type="hidden"  name="hidden_start_date" 
				value="<?php print  $result->start_date?>">
		<?php }	?>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date"><?php _e('Holiday End Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="end_date" class="form-control validate[required] " type="text"  name="end_date" 
				value="<?php if($edit){ echo $result->end_date;}elseif(isset($_POST['end_date'])) echo $_POST['end_date'];?>">
			</div>
		</div>
		<?php 
			if($edit){ ?>
				<input id="hidden_end_date" class="form-control " type="hidden"  name="hidden_end_date" 
				value="<?php print  $result->end_date?>">
		<?php }	?>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','hospital_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="description" class="form-control" name="description"><?php if($edit){echo $result->description; }elseif(isset($_POST['description'])) echo $_POST['description']; ?> </textarea>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Holiday','hr_mgt');}?>" name="save_holiday" class="btn btn-success"/>
        </div>
		</form>
</div>