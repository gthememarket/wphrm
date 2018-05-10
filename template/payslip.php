<?php 
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'generate_payslip';
$obj_payslip=new HrmgtPayslip;
$u_role =hrmgt_get_user_role(get_current_user_id() );
if(isset($_REQUEST['print']) && $_REQUEST['print']=='pdf')
{
	require_once HRMS_PLUGIN_DIR .'/salary_slip/salary_slip.php';
}

if(isset($_POST['submit_payslip']))
{		
	global $wpdb;
	$tbl_generated_slip = $wpdb->prefix .'hrmgt_generated_salary_slip';	
	$Earning = array();
	if(!empty($_POST['earning_title']))
	{	
		$e=0;
		foreach($_POST['earning_title'] as $earning_key=>$earning_value)
		{			
			$Earning[$earning_value] = $_POST['earning_amount'][$e];			
			$e++;
		}
	}	
	$AllEarning = json_encode($Earning);	
	$Deduction = array();
	
	if(!empty($_POST['deduction_title']))
	{	
		$d=0;
		foreach($_POST['deduction_title'] as $deduction_key=>$deduction_value)
		{
			$Deduction[$deduction_value] = $_POST['deduction_amount'][$d];
			$d++;		
		}		
	}
		
	$AllDeduction = json_encode($Deduction);	
	$PayslipData['department_id']			=	$_POST['department_id'];
	$PayslipData['attendance_detail_id']	=	$_POST['attendance_detail_id'];
	$PayslipData['employee_id']				=	$_POST['employee_id'];
	$PayslipData['earning']					=	$AllEarning;
	$PayslipData['deduction']				=	$AllDeduction;
	$PayslipData['account_number']			=	$_POST['account_number'];
	$PayslipData['total_earning']			=	$_POST['total_earning'];
	$PayslipData['total_deduction']			=	$_POST['total_deduction'];
	$PayslipData['net_salary']				=	$_POST['net_salary'];
	$PayslipData['basic_salary']			=	$_POST['basic_salary'];
	$PayslipData['ctc_month']				=	$_POST['ctc_month'];
	$PayslipData['month']					=	$_POST['month'];	
	$PayslipData['year']					=	$_POST['year'];	
	$PayslipData['total_days']				=	$_POST['total_days'];	
	$PayslipData['payable_days']			=	$_POST['payable_days'];	
	$PayslipData['hours']					=	$_POST['hours'];	
	$result = $wpdb->insert($tbl_generated_slip,$PayslipData);	
	if($result)
	{
		wp_redirect('?hr-dashboard=user&page=payslip&tab=generate_payslip&message=generate_slip');
	}	
}
if(isset($_REQUEST['message']))
{	$message = $_REQUEST['message'];
	if($message=='generate_slip')
	{ ?>
		<div id="message" class="updated below-h2 msg "><p><?php _e('Payslip Record added successfully ','hr_mgt'); ?></p></div>
<?php } 
} 
?>



<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist" style="margin-bottom:20px">	  
	<li class="<?php if($active_tab=='generate_payslip'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=payslip&tab=generate_payslip" class="tab <?php echo $active_tab == 'generate_payslip' ? 'active' : ''; ?>">
			<i class="fa fa-align-justify"></i> <?php _e('Generate Payslip List', 'hr_mgt'); ?></a>
        </a>
	</li>
	<li class="<?php if($active_tab=='payslip_record'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=payslip&tab=payslip_record" class="tab <?php echo $active_tab == 'payslip_record' ? 'active' : ''; ?>">
			<i class="fa fa-align-justify"></i> <?php _e('Payslip Record', 'hr_mgt'); ?></a>
        </a>
	</li>
	<?php if($role != "employee"){ ?>
	<li class="<?php if($active_tab=='custom_slip'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=payslip&tab=custom_slip" class="tab <?php echo $active_tab == 'custom_slip' ? 'active' : ''; ?>">
			<i class="fa fa-align-justify"></i> <?php _e('Custom Payslip', 'hr_mgt'); ?></a>
        </a>
	</li>
	<?php } ?>
	<?php if($active_tab=='generate_slip'){ ?>
	<li class="<?php if($active_tab=='generate_slip'){?>active<?php }?>">
		<a href="?hr-dashboard=user&page=payslip&tab=generate_slip" class="tab <?php echo $active_tab == 'generate_slip' ? 'active' : ''; ?>">
			<i class="fa fa-align-justify"></i> <?php _e('Generate Slip', 'hr_mgt'); ?></a>
        </a>
	</li>
	<?php }  ?>
</ul>

<?php if($active_tab == 'generate_payslip'){ ?>
<div class="tab-content">
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#generate_payslip').DataTable({
		"order": [[ 0, "asc" ]],
		"responsive": true,
		"aoColumns":[
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},	       
	        {"bSortable": false}]
	});
} );
</script>

<div class="table-responsive">
   <table id="generate_payslip" class="display" cellspacing="0" width="100%">
		<thead>
            <tr>				
				<th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Salary Month', 'hr_mgt' ) ;?></th>			
				<th><?php _e( 'Payable Days', 'hr_mgt' ) ;?></th>				
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
				<th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Salary Month', 'hr_mgt' ) ;?></th>				
				<th><?php _e( 'Payable Days', 'hr_mgt' ) ;?></th>				
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>           
        </tfoot> 
        <tbody>
        <?php 
		$SlipData=$obj_payslip->hrmgt_get_approve_attendace();		
		if(!empty($SlipData))
		{
		 	foreach ($SlipData as $retrieved_data){ ?>
            <tr>
				<td class="assign"><?php print hrmgt_get_display_name($retrieved_data->employee_id); ?></td>
				<td class="employee"><?php echo $retrieved_data->month .'-'.$retrieved_data->year;?></td>				
				<td class="end"><?php echo $retrieved_data->payable_days;?></td>			
				<td class="action">
					<?php if($role=="employee"){ 
						if($retrieved_data->employee_id==get_current_user_id())
						{ ?>
							<a href="??hr-dashboard=user&page=payslip&tab=generate_slip&action=generate_slip&detail_id=<?php echo $retrieved_data->id;?>" class="btn btn-primary" id="<?php echo $retrieved_data->id; ?>"> <?php _e('Generate Slip','hr_mgt');?></a>	
					<?php	}						
					 } else{ ?> 
						<a href="??hr-dashboard=user&page=payslip&tab=generate_slip&action=generate_slip&detail_id=<?php echo $retrieved_data->id;?>" class="btn btn-primary" id="<?php echo $retrieved_data->id; ?>"> <?php _e('Generate Slip','hr_mgt');?></a>
					<?php } ?>					
                </td>
             </tr>
        <?php } } ?>
		</tbody>
    </table>
</div>
</div>
<?php 
}
if($active_tab=='payslip_record')
{ ?>
<div class="tab-content">
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#assets_list').DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
	        {"bSortable": true},
			{"bSortable": true},	            
	        {"bSortable": true},	        
	        {"bSortable": false}]
	});
} );
</script>
<div class="table-responsive">
   <table id="assets_list" class="display" cellspacing="0" width="100%">
		<thead>
            <tr>				
				<th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>				
				<th><?php _e( 'Account No.', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Total Earning Amount', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Total Deduction Amount', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'CTC(Month)', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Basic Salary', 'hr_mgt' ) ;?></th>				
				<th><?php _e( 'Net Salary', 'hr_mgt' ) ;?></th>				
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
				<th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>				
				<th><?php _e( 'Account No.', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Total Earning Amount', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Total Deduction Amount', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'CTC(Month)', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Basic Salary', 'hr_mgt' ) ;?></th>				
				<th><?php _e( 'Net Salary', 'hr_mgt' ) ;?></th>				
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>           
        </tfoot> 
        <tbody>
        <?php 
		$SlipData=$obj_payslip->hrmgt_get_generated_slip();		
		if(!empty($SlipData))
		{
		 	foreach ($SlipData as $retrieved_data){ ?>
            <tr>
				<td class="assign"><a href="#"><?php print hrmgt_get_display_name($retrieved_data->employee_id); ?></a></td>		
				<td class="start"><?php echo $retrieved_data->account_number;?></td>
				<td class="start"><?php echo $retrieved_data->total_earning;?></td>
				<td class="start"><?php echo $retrieved_data->total_deduction;?></td>
				<td class="start"><?php echo $retrieved_data->ctc_month;?></td>
				<td class="start"><?php echo $retrieved_data->basic_salary;?></td>
				<td class="start"><?php echo $retrieved_data->net_salary;?></td>				
				<td class="start"><a  href="?hr-dashboard=user&page=payslip&print=pdf&type=salary_slip&AttDetail_id=<?php echo $retrieved_data->id;?>" target="_blank" class="btn btn-success"><?php _e('PDF','hr_mgt');?></a></td>				
             </tr>
        <?php } } ?>
		</tbody>
    </table>
</div>
</div>
<?php 
}

if($active_tab =='generate_slip')
{
	$obj_HrmgtDepartment=new HrmgtDepartment;
	$obj_HrmgtAttendanceDetails=new HrmgtAttendanceDetails;
	$AttDetailID = $_REQUEST['detail_id'];	
	$AttData = $obj_HrmgtAttendanceDetails->get_single_attendance_deatail($AttDetailID);	
	$user = get_userdata($AttData[0]->employee_id);	
	$monthNum  = $AttData[0]->month;
	$dateObj   = DateTime::createFromFormat('!m', $monthNum);
	$monthName = $dateObj->format('F');	
	$tatal_month_day = get_days_in_month($AttData[0]->month,$AttData[0]->year);	
?>
<div class="col-md-12" style="background:#F0F8FF;">
	<div class="col-md-3 col-sm-6 col-xs-12">
		<img height="150px" class="img-responsive" src="<?php print get_option('hrmgt_system_logo'); ?>" />
	</div>
	<div class="col-md-9  col-sm-6 col-xs-12" style="text-align:center">
		<h1 class="salary_h1"><?php print get_option('hrmgt_system_name'); ?></h1> 
		<p style=" text-decoration: underline;"><?php print get_option('hrmgt_office_address') .','. get_option('hrmgt_contry').','.get_option('hrmgt_contact_number'); ?></p>		
	</div>	
	
	<h2 style="float:left; border-top:1px solid #ccc; padding:10px 0; width:100%; text-align:center"><?php _e('Payslip  For the month of','hr_mgt'). print ' '. $monthName .' '. $AttData[0]->year ?></h2>		
<form method="post" name="generate_slip" id="custom_slip">	
	<input type="hidden" name="employee_id" value="<?php print $user->ID ?>">
	<input type="hidden" name="attendance_detail_id" value="<?php print $AttDetailID ?>">
	<input type="hidden" name="department_id" value="<?php print get_user_meta($user->ID,'department',true); ?>">
	<input type="hidden" name="account_number" value="<?php print get_user_meta($user->ID,'account_number',true); ?>">
	<input type="hidden" name="month" value="<?php print $monthNum; ?>">
	<input type="hidden" name="year" value="<?php print $AttData[0]->year; ?>">
	<div class="table-responsive custom_tbl">	
<table class="table" style="float: left;">
	<tr>        
		<th style="text-align:right" ><?php _e('Employee Name :','hr_mgt');?></th>
		<td> <?php print hrmgt_get_display_name($user->ID);?> (<?php print (get_user_meta($user->ID,"employee_code",true));?>)</td>
		<th style="text-align:right"><?php _e('Account No :','hr_mgt');?></th>
	 <td>
		<?php $account_number = get_user_meta($user->ID,'account_number',true);	?>
		<?php if($account_number!='') print $account_number; else print 'NA'; ?>
	 </td>
	</tr>	  
	<tr>
		<th style="text-align:right"><?php _e('Joining Date :','hr_mgt');?></th>
		<td><?php print hrmgt_change_dateformat(get_user_meta($user->ID,'joining_date',true))  ?></td>
		<th style="text-align:right"><?php _e('Contract End Date :','hr_mgt');?></th>
		<td><?php print hrmgt_change_dateformat(get_user_meta($user->ID,'contract_end_date',true))  ?></td>
	</tr>
	<tr>
		<th style="text-align:right"><?php _e('Total Days :','hr_mgt');?></th>
		<td>
			<?php print $tatal_month_day ?>
			<input type="hidden" name="total_days" value="<?php print $tatal_month_day; ?>">
		</td>
		<th style="text-align:right"><?php _e('Payable Day :','hr_mgt');?></th>
		<td>
			<?php print $AttData[0]->payable_days .' Days' ?>
			<input type="hidden" name="payable_days" value="<?php print $AttData[0]->payable_days ?>">
		</td>
	</tr> 
	<tr>
		<th style="text-align:right" ><?php _e('Department','hr_mgt');?></th>
		<td>
			<?php print hrmgt_get_department_name(get_user_meta($user->ID,'department',true));?>
		</td> 
		<th style="text-align:right"><?php _e('Hours','hr_mgt');?></th>
		<td>
			<?php print   $obj_HrmgtAttendanceDetails->get_monthly_working_hour($user->ID,$AttData[0]->month,$AttData[0]->year). ' Hrs'  ?>
			<input type="hidden" name="hours" value="<?php print   $obj_HrmgtAttendanceDetails->get_monthly_working_hour($user->ID,$AttData[0]->month,$AttData[0]->year); ?>">
		</td>
	</tr>	  
</table>
</div>  
<div class="col-md-6">
	<table class="table">
		<tr style="background:#D99594; text-align: center;" > 
			<th colspan="3" style="text-transform: uppercase; text-align:center"><?php _e('Earnings','hr_mgt'); ?></th>
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">
			<th><?php _e('Salary Head','hr_mgt');?></th>
			<th style="text-align:center"><?php _e('CTC(Month)','hr_mgt');?></th>
			<th><?php _e('Amount','hr_mgt');?></th>
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white; " >			
			<td><?php _e('Basic Salary','hr_mgt'); ?></td>
			<?php $total_salary = get_user_meta($user->ID,'employee_salary',true); ?>
			<td style="text-align:center"><?php print  $total_salary; ?></td>			
			<td>
				<?php print  $total_earning = round(( $total_salary / $tatal_month_day ) * $AttData[0]->payable_days); ?>			
			</td>
			<input type="hidden" name="ctc_month" value="<?php print  $total_salary; ?>">
			<input type="hidden" name="basic_salary" value="<?php print  $total_earning; ?>">
		</tr>		
		<?php			
			$EarningData = json_decode(get_user_meta($user->ID,'other_earning_entry',true));			
			if(!empty($EarningData))
			{
				foreach($EarningData as $key=>$Earning)
				{
					if(isset($Earning->status) && $Earning->status=='visible' )
					{ ?>
						<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
							<td colspan="2"><?php print $Earning->title; ?></td>						
							<td><?php print $Earning->amount?></td>								
							<?php $total_earning +=$Earning->amount ?>
							<input type="hidden" name="earning_title[]" value="<?php print $Earning->title; ?>">
							<input type="hidden" name="earning_amount[]" value="<?php print $Earning->amount; ?>">
						</tr>
				<?php }
				}
			}			
			 ?>
		<tr style="background:#D99594; ">
			<th colspan="2" style="text-transform:uppercase"><?php _e('Total Earning','hr_mgt'); ?></th>
			<th><?php print $total_earning ?></th>
			<input name="total_earning" type="hidden" value="<?php print $total_earning ?>" >
		</tr>
	</table>
</div>

<div class="col-md-6">
	<table class="table">
		<tr style="background:#FABF8F" >
			<th colspan="2" style="text-transform: uppercase; text-align:center"><?php _e('Deduction','hr_mgt'); ?></th>
		</tr>
		<tr style="background:#FBD4B4; border-bottom:2px solid white;" > 			
			<th><?php _e('Salary Head','hr_mgt');?></th>
			<th><?php _e('Amount','hr_mgt');?></th>
		</tr>
		<?php
			$DeductionData = json_decode(get_user_meta($user->ID,'other_deduction_entry',true));
			$total_deduction =0;
			if(!empty($DeductionData))
			{			
				foreach($DeductionData as $key=>$Deduction)
				{
					if(isset($Deduction->status) && $Deduction->status=='visible' )
					{ ?>
						<tr style="background:rgb(251,212,180);border-bottom:2px solid white;">			
							<td><?php print $Deduction->title ?></td>						
							<td><?php print $Deduction->amount ?></td>
							<?php $total_deduction +=$Deduction->amount ?>
							<input type="hidden" name="deduction_title[]" value="<?php print $Deduction->title; ?>">
							<input type="hidden" name="deduction_amount[]" value="<?php print $Deduction->amount; ?>">
						</tr>
				<?php }
				} 
			}			
			 ?>
			<tr style="background:rgb(250,191,143)">
				<th style="text-transform:uppercase"><?php _e('Total Deduction','hr_mgt'); ?></th>
				<th><?php print $total_deduction ?></th>
				<input type="hidden" name="total_deduction" value="<?php print $total_deduction ?>">
			</tr>
	
		<tr style="background:#D99594" >		
			<th style="text-transform: uppercase;" ><?php _e('Net Salary','hr_mgt'); ?></th>
			<th><?php print $total_earning - $total_deduction; ?></th>
			<input type="hidden" name="net_salary" value="<?php print $total_earning - $total_deduction; ?>">
		</tr>			
	</table>
</div>
<div class="col-md-12">
<input type="submit" name="submit_payslip" value="Generate Salary Slip" class="btn btn-primary">
</div>
</form>
</div>
<?php }
if($active_tab=="custom_slip")
{
	require_once HRMS_PLUGIN_DIR. '/template/payslip/custom_slip.php'; 
}
?>
</div>
</div>