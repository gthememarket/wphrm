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
	    yearRange:'-65:+65',
	});
});
</script>
<?php 
if(isset($_REQUEST['action']) && $_REQUEST['action']=="delete")
{
	$delete = $Obj_PlManagement->hrmgt_delete_pl($_REQUEST['pl_id']);
	if($delete)
	{
		wp_redirect ('?hr-dashboard=user&page=pl&tab=pl_list&msg=2');
	}	
}

if(isset($_REQUEST['msg']))
{
	$message =$_REQUEST['msg'];
	if($message == 1)
	{ ?>
		<div id="message" class="updated below-h2  msg ">
			<p><?php _e('Paid Leave Successfully Saved','hr_mgt');?></p>
		</div>
	<?php 
}
if($message == 2)
	{ ?>
		<div id="message" class="updated below-h2  msg ">
			<p><?php _e('Paid Leave Successfully Delete','hr_mgt');?></p>
		</div>
	<?php 
}
 }
	?>
<div class="panel-body panel-white">
	<ul class="nav nav-tabs panel_tabs" role="tablist">
		<li class="<?php if($active_tab == 'pl_list') echo "active";?>">
			<a href="?hr-dashboard=user&page=pl&tab=pl_list">
				<i class="fa fa-align-justify"></i> <?php _e('Paid Leave List', 'hr_mgt'); ?></a>
			</a>
		</li>
		
		<li class="<?php if($active_tab == 'pl') echo "active";?>">
			<a href="?hr-dashboard=user&page=pl&tab=pl">
				<i class="fa fa-plus-circle"></i> <?php _e('Paid Leave', 'hr_mgt'); ?></a>
			</a>
		</li>
		
	</ul>
	<div class="tab-content">
    
<?php 
if($active_tab=="pl"){ ?>
<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#department_form').validationEngine();
} );
</script>
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
												<td width="250px"><input type="text" value="<?php print $value;  ?>" name="month_<?php print $month ?>" <?php if($role !="manager"){ print "readonly='readonly'";}?>></td>
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
							wp_redirect ('?hr-dashboard=user&page=pl&tab=pl_list&msg=1');							
						}
					}
					?>
				</div>
			<?php } if($active_tab=="pl_list")
			{ ?>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('#pl_list').DataTable({	
							"responsive": true,
							"aoColumns":[								
								{"bSortable": true},
								{"bSortable": true},
								{"bSortable": true},
								{"bSortable": true},
								{"bSortable": true},
								{"bSortable": true},							
								{"bSortable": true},							
								{"bSortable": true},							
								{"bSortable": true},							
								{"bSortable": true},							
								{"bSortable": true},														
								{"bSortable": true},														
								{"bSortable": true},
							<?php if($role=="manager"){ ?>											
								{"bSortable": true},								
							<?php } ?>										
								{"bSortable": false}]
								
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
							<?php if($role=="manager"){ ?>	
							<th><?php _e( 'Action', 'hr_mgt' ) ;?></th>
							<?php } ?>
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
							<?php if($role=="manager"){ ?>	
							<th><?php _e( 'Action', 'hr_mgt' ) ;?></th>	
							<?php } ?>
						</tr>           
					</tfoot> 
					<?php 
						if($role=="manager")
						{
							$retrive_data = $Obj_PlManagement->hrmgt_get_all_pl();	
						}
						else
						{
							$retrive_data = $Obj_PlManagement->hrmgt_get_employee_pl(get_current_user_id());	
						}
											
					?>
					<tbody>
					<?php
					
						if($retrive_data){
						foreach($retrive_data as $result) 
						{ ?>
						<tr>
							<td><?php print hrmgt_get_display_name($result->employee_id); ?></td>							
							<td><?php print $result->year; ?></td>							
							<td><?php print $result->month_1; ?></td>							
							<td><?php print $result->month_2; ?></td>							
							<td><?php print $result->month_3; ?></td>							
							<td><?php print $result->month_4; ?></td>							
							<td><?php print $result->month_5; ?></td>							
							<td><?php print $result->month_6; ?></td>							
							<td><?php print $result->month_7; ?></td>							
							<td><?php print $result->month_8; ?></td>							
							<td><?php print $result->month_9; ?></td>							
							<td><?php print $result->month_10; ?></td>							
							<td><?php print $result->month_11; ?></td>							
							<td><?php print $result->month_12; ?></td>	
							<?php if($role=="manager"){ ?>								
							<td><a href="<?php print "?hr-dashboard=user&page=pl&tab=pl_list&action=delete&pl_id=".$result->id?>" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');" class="btn btn-danger"><?php _e('Delete','hr_mgt')?></a></td>							
							<?php } ?>
						</tr>
						<?php } } ?>
					</tbody>
				</table>
				</div>
				</div>
			<?php } ?>		
	</div>
</div>