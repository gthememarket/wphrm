<?php $active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'earning_deduction'; ?>
<script type="text/javascript">
	$(document).ready(function() {
		jQuery('#event_list').DataTable();
	} );
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#start_date').datepicker({dateFormat: "yy-mm-dd"}); 
	} );
</script>

<div class="popup-bg" style="display: none; height: 1251px;">
	<div class="overlay-content">
		<div class="category_list"></div>    
	</div> 
</div>
<?php 
if(isset($_REQUEST['message']) && $_REQUEST['message']=='1')
{ ?>
	<div id="message" class="updated below-h2 msg ">
		<p><?php  _e('Earning & Deduction update successfully','hr_mgt');?></p>
	</div>	
<?php } ?>

<div class="panel-body panel-white">
<ul class="nav nav-tabs panel_tabs" role="tablist">	  
	<li class="<?php if($active_tab=='earning_deduction'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=earning_deduction&tab=earning_deduction" class="tab <?php echo $active_tab == 'earning_deduction' ? 'active' : ''; ?>">
			<i class="fa fa-align-justify"></i> <?php _e('Add Earning Deduction', 'hr_mgt'); ?></a>		
	</li>		
</ul>

<div class="tab-content">
<?php if($active_tab == 'earning_deduction')
{
	if(isset($_POST['earning_deduction']))
	{	
		$new_earning = array_filter($_POST['earnings']);
		$str_earning = implode("/",$new_earning);
		$new_earning = explode("/",str_replace(" ","_",$str_earning));
		
		$new_dedution = array_filter($_POST['deduction']);
		$str_dedution = implode("/",$new_dedution);
		$new_dedution = explode("/",str_replace(" ","_",$str_dedution));
		
		$result1 = update_option('earning',$new_earning);
		$result2 = update_option('deduction',$new_dedution);
		if($result1 || $result2)
		{
			wp_redirect ('?hr-dashboard=user&page=earning_deduction&tab=earning_deduction&message=1');
		}
	}
?>
<div class="panel-body">
<form name="payslip_form" action="" method="post" class="form-horizontal" id="payslip_form">
<?php
	$earning = get_option('earning'); 	
	if(!empty($earning))
	{
		foreach($earning as $earnings)
		{ ?>
		<div class="form-group del_<?php print $earnings ?>">
			<label class="col-sm-2 control-label" for="earnings"><?php _e('Earnings','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-6">
				<input id="earnings" class="form-control validate[required] text-input" type="text" value="<?php print str_replace("_"," ",$earnings); ?>" name="earnings[]" >
			</div>
			<div class="col-sm-2">
				<button  class="btn btn-default delete-earning-deduction" type="button"  data-set="earning" value="<?php print $earnings; ?>"><?php _e('Delete','hr_mgt'); ?></button>
			</div>
		</div>	
		<?php }
	}
?>
<div id="earning_entry">
	<div class="form-group">
		<label class="col-sm-2 control-label" for="earnings"><?php _e('Earnings','hr_mgt');?><span class="require-field">*</span></label>
		<div class="col-sm-6">
			<input id="earnings" class="form-control validate[required] text-input" type="text" value="" name="earnings[]" >
		</div>
		<div class="col-sm-2">
			<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
				<i class="entypo-trash"><?php _e('Delete','hr_mgt');?></i>
			</button>
		</div>
	</div>	
</div>
					
<div class="form-group">
	<label class="col-sm-2 control-label" for="expense_entry"></label>
	<div class="col-sm-3">
		<button id="add_new_earnings_entry" class="btn btn-default btn-sm btn-icon icon-left" type="button"   name="add_new_earning" onclick="add_earning()"><?php _e('Add More Earnings','hr_mgt'); ?>
		</button>
	</div>
</div>
<?php 
	$deduction = get_option('deduction'); 	
	if(!empty($earning))
	{
		foreach($deduction as $deductions)
		{ ?>
		<div id="deduction_entry" class="del_ded_<?php print  $deductions ?>">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="deduction"><?php _e('Deduction','hr_mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-6">
					<input id="deduction" class="form-control validate[required] text-input" type="text" value="<?php print str_replace("_"," ",$deductions); ?>" name="deduction[]">
				</div>
				<div class="col-sm-2">
					<button  class="btn btn-default delete-earning-deduction" type="button"  data-set="deduction" value="<?php print $deductions; ?>"><?php _e('Delete','hr_mgt'); ?></button>
				</div>
			</div>	
		</div>	
	<?php } 
} ?>
<div id="deduction_entry">
	<div class="form-group">
		<label class="col-sm-2 control-label" for="deduction"><?php _e('Deduction','hr_mgt');?><span class="require-field">*</span></label>
		<div class="col-sm-6">
			<input id="deduction" class="form-control validate[required] text-input" type="text" value="" name="deduction[]">
		</div>
		<div class="col-sm-2">
			<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
				<i class="entypo-trash"><?php _e('Delete','hr_mgt');?></i>
			</button>
		</div>
	</div>	
</div>					
<div class="form-group">
	<label class="col-sm-2 control-label" for="expense_entry"></label>
	<div class="col-sm-3">
		<button id="add_new_deduction_entry" class="btn btn-default btn-sm btn-icon icon-left" type="button"   name="add_new_deduction" onclick="add_deduction()"><?php _e('Add More Deduction','hr_mgt'); ?>
		</button>
	</div>
</div>
<div class="col-sm-offset-2 col-sm-8">
    <input type="submit" value="<?php _e('Add Earning Deduction','hr_mgt') ?>" name="earning_deduction" class="btn btn-success" class="btn btn-primay" />
</div>				
</form>	
</div>
<script>	
	var blank_earning_entry ='';
   	$(document).ready(function() { 
   		blank_earning_entry = $('#earning_entry').html();   		
   	}); 

   	function add_earning()
   	{
   		$("#earning_entry").append(blank_earning_entry);   		
   	}
	
   	var blank_deduction_entry='';
	$(document).ready(function() { 
   		blank_deduction_entry = $('#deduction_entry').html();   		
   	}); 

   	function add_deduction()
   	{
   		$("#deduction_entry").append(blank_deduction_entry);   		
   	}
   	  
   	function deleteParentElement(n){
   		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
   	} 
</script>
<?php } ?>	
</div>
</div>