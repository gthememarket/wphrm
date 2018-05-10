<?php 		
$active_tab = isset($_GET['tab'])?$_GET['tab']:'add_e_d';
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
		wp_redirect ( admin_url().'admin.php?page=hrmgt-earning_deduction&tab=add_e_d&message=1');
	}
}
?>
<div class="page-inner" style="min-height:1088px !important">
<div class="page-title">
	<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?></h3>
</div>
<?php
if(isset($_REQUEST['message']) && $_REQUEST['message']=='1')
{ ?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e('Earning & Deduction update successfully','hr_mgt');?></p>
	</div>
<?php } ?>
	
<div id="main-wrapper">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-white">
			<div class="panel-body">
		<h2 class="nav-tab-wrapper">			
			<a href="?page=hrmgt-earning_deduction&tab=add_e_d" class="nav-tab <?php echo $active_tab == 'add_e_d' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Earnings & Deduction', 'hr_mgt'); ?></a>		
		</h2>
<?php 	
if($active_tab == 'add_e_d')
{ ?>	

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
		<?php } ?>
<?php } ?>
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
    <input type="submit" value="Add Earning Deduction" name="earning_deduction" class="btn btn-success" class="btn btn-primay" />
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
</div>
</div>