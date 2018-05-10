<?php
$active_tab = isset($_GET['tab'])?$_GET['tab']:'pl_list'; 
$Obj_PlManagement = new PlManagement();
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#pl_form').validationEngine();
	$('#year').datepicker({
		dateFormat:'yy',
		changeYear: true,
	    yearRange:'-10:+10',
	});
});
</script>
<div class="page-inner" style="min-height:1088px !important">
<div class="page-title">
	<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?>
	</h3>
</div>
<?php 
if(isset($_REQUEST['action']) && $_REQUEST['action']=="delete")
{
	$delete = $Obj_PlManagement->hrmgt_delete_pl($_REQUEST['pl_id']);
	if($delete)
	{
		wp_redirect(admin_url().'admin.php?page=hrmgt-pl&tab=pl_list&msg=2');
	}	
}
if(isset($_REQUEST['msg']))
{
	
	if($_REQUEST['msg']=="1")
	{ ?>
		<div id="message" class="updated below-h2 "><p><?php _e('Paid Leave Successfully Saved','hr_mgt');?></p></div>
	<?php }
	if($_REQUEST['msg']=="2")
	{ ?>
		<div id="message" class="updated below-h2 "><p><?php _e('Paid Leave Successfully Delete','hr_mgt');?></p></div>
	<?php }
}
?>

<div id="main-wrapper">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-white">
				<div class="panel-body">
					<h2 class="nav-tab-wrapper">
					
						<a href="?page=hrmgt-pl&tab=pl_list" class="nav-tab <?php echo $active_tab == 'pl_list' ? 'nav-tab-active' : ''; ?>">
						<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Paid Leave List', 'hr_mgt'); ?></a>
						
						<a href="?page=hrmgt-pl&tab=pl" class="nav-tab <?php echo $active_tab == 'pl' ? 'nav-tab-active' : ''; ?>">
						<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Paid Leave', 'hr_mgt'); ?></a>
						
					</h2>
					<?php if($active_tab=="pl"){ ?>
					<div class="panel-body">					
					<form method="post" id="pl_form">
						<div class="form-group col-md-3">
							<label for="emp_id"><?php _e('Select Employee','hr_mgt');?><span class="require-field">*</span></label>			
							<select name="emp_id"  id="emp_id"  class="form-control validate[required]">
								<option value=" "><?php _e('Select Employee ','hr_mgt');?></option>
								<?php 
								
								if(isset($_REQUEST['emp_id']))
									$employee =$_REQUEST['emp_id'];  
								else 
									$employee = "";					
									$employeedata=hrmgt_get_working_user('employee');
									if(!empty($employeedata))
									{
										foreach ($employeedata as $retrive_data)
										{ 
											echo '<option value="'.$retrive_data->ID.'" '.selected($employee,$retrive_data->ID).'>'.$retrive_data->display_name.'</option>';
										}
									}
								?>
							</select>			
						</div>
						<div class="form-group col-md-3">
							<label class="control-label" for="year"><?php _e('Year','hr_mgt');?><span class="require-field">*</span></label>			
							<input id="year" class="form-control validate[required]" type="text" value="<?php if(isset($_POST['year'])) print $_POST['year'] ?>" name="year">			
						</div>						
						<div class="form-group col-md-3 button-possition">
							<label for="subject_id">&nbsp;</label>
							<input type="submit" value="<?php _e('GO','hr_mgt');?>" name="pl_list"  class="btn btn-success"/>
						</div>       
					</form>
					</div>
					 <div class="clearfix"> </div>
					<?php
					if(isset($_POST['pl_list']))
					{ //var_dump($_POST); ?>
						<div class="panel-body">  
						<form method="post" class="form-horizontal">         
							<input type="hidden" name="emp_id" value="<?php print $_POST['emp_id'] ?> ">
							<input type="hidden" name="year" value="<?php print $_POST['year'] ?>">		
							 <div class="panel-heading">
								<h4 class="panel-title"><?php _e('Employee Name : ','hr_mgt');
									print hrmgt_get_display_name($_POST['emp_id']); 
								?>&nbsp;&nbsp;&nbsp;&nbsp;								 
									<?php _e('Year','hr_mgt'); ?> : <?php print $_POST['year']; ?></h4>
							 </div>            
					        <div class="col-md-12">
								<table class="table">
									<tbody>
										<tr>
											<th width="70px"><?php _e('Month','hr_mgt'); ?></th>
											<th width="250px"><?php _e('Leave','hr_mgt'); ?></th>
										</tr>
										<?php 
										$result = $Obj_PlManagement->hrmgt_get_pl_by_empid_year($_POST['emp_id'],$_POST['year']);										
										for($month=1;$month<=12;$month++)
										{
											$dateObj = DateTime::createFromFormat('!m', $month);
											$monthName = $dateObj->format('F');
											if($result)
											{
												$abc = "month_".$month;
												$value = $result->$abc;
											}
											else
											{
												$value="";
											}
											?>
											<tr>
												<td width="70px"><?php print __($monthName,'hr_mgt'); ?></td>
												<td width="250px"><input type="text" value="<?php print $value;  ?>" name="month_<?php print $month ?>" ></td>
											</tr> 
										<?php }	?>
										 
									</tbody>
								</table>
							</div>				
							<div class="form-group col-md-3 button-possition">
								<label for="subject_id">&nbsp;</label>
								<input type="submit" value="<?php _e('Save ','hr_mgt');?>" name="save_pl"  class="btn btn-success"/>
							</div>      
						</form>
					</div>
					<?php }
					if(isset($_POST['save_pl']))
					{
						$result = $Obj_PlManagement->hrmgt_manage_paidleave($_POST);
						if($result)
						{
							wp_redirect(admin_url().'admin.php?page=hrmgt-pl&tab=pl_list&msg=1');							
						}
					}
					?>					
				</div>
				<?php } 
				if($active_tab=="pl_list")
				{ ?>
					<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('#pl_list').DataTable({
							"bProcessing": true,
							 "bServerSide": true,
							 "sAjaxSource": ajaxurl+'?action=datatable_paid_leave_ajax_to_load',
							 "bDeferRender": true,
						});						
					} );
					</script>
					<div class="panel-body">
					<div class="table-responsive">
				<table id="pl_list" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>						 
							<th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'Year', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'January', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'February', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'March', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'April', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'May', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'June', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'July', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'August', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'September', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'October', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'November', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'December', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'Action', 'hr_mgt' ) ;?></th>											  		 
						</tr>
					</thead>
					<tfoot>
						<tr>							
							<th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'Year', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'January', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'February', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'March', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'April', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'May', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'June', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'July', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'August', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'September', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'October', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'November', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'December', 'hr_mgt' ) ;?></th>
							<th><?php _e( 'Action', 'hr_mgt' ) ;?></th>							
						</tr>           
					</tfoot> 
					<?php 
						$retrive_data = $Obj_PlManagement->hrmgt_get_all_pl();						
					?>
				</table>
				</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>