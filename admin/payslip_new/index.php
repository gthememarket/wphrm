<div class="popup-bg">
    <div class="overlay-content">
		<div class="category_list"></div>    
    </div> 
</div>	
<?php 		
$active_tab = isset($_GET['tab'])?$_GET['tab']:'generate_payslip';
$obj_payslip=new HrmgtPayslip;
?>
<div class="page-inner" style="min-height:1088px !important">
<div class="page-title">
	<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?></h3>
</div>
<?php
if(isset($_REQUEST['print']) && $_REQUEST['print']=='pdf')
{
	require_once HRMS_PLUGIN_DIR .'/salary_slip/salary_slip.php';
	
}	
if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete_payslip')
{
	$result=$obj_payslip->hrmgt_delete_paylisp($_REQUEST['AttDetail_id']);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=hrmgt-payslip&tab=payslip_record&message=1');
				}
	
}
if(isset($_REQUEST['message']) && $_REQUEST['message']== 1){
?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e('Payslip delete successfully','hr_mgt');?></p>
	</div>
	<?php 
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
		if(isset($_POST['custom_slip']))
		{
				wp_redirect(admin_url().'admin.php?page=hrmgt-payslip&tab=payslip_record&message=generate_slip');
		}
		else
		{
			wp_redirect(admin_url().'admin.php?page=hrmgt-payslip&tab=generate_payslip&message=generate_slip');
		}
	}	
}

if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];	
	if($message=='generate_slip') { ?>
		<div id="message" class="updated  below-h2"><p><?php _e('Payslip Record added successfully ','hr_mgt'); ?></div></p>
<?php }
} ?>
	
<div id="main-wrapper">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-white">
				<div class="panel-body">
		<h2 class="nav-tab-wrapper">	
			<a href="?page=hrmgt-payslip&tab=generate_payslip" class="nav-tab <?php echo $active_tab == 'generate_payslip' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Generate Payslip List', 'hr_mgt'); ?></a>
			
			<a href="?page=hrmgt-payslip&tab=payslip_record" class="nav-tab <?php echo $active_tab == 'payslip_record' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Payslip Record','hr_mgt'); ?></a>
			
			<a href="?page=hrmgt-payslip&tab=custom_slip" class="nav-tab <?php echo $active_tab == 'custom_slip' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Custom Payslip', 'hr_mgt'); ?></a>
			
			<?php if($active_tab=='generate_slip'){  ?>
			<a href="?page=hrmgt-payslip&tab=generate_slip" class="nav-tab <?php echo $active_tab == 'generate_slip' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Generate Slip', 'hr_mgt'); ?></a>
			<?php } ?>			
		</h2>
     <?php 
	//Report 1 
if($active_tab == 'generate_payslip')
{ ?>	

<script type="text/javascript">
$(document).ready(function() {
	jQuery('#generate_payslip').DataTable({
		"bProcessing": true,
				 "bServerSide": true,
				 "sAjaxSource": ajaxurl+'?action=datatable_payslip_ajax_to_load',
				 "bDeferRender": true,	
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
     </table>
</div>
<?php 
}
else
{
	if(isset($active_tab))
	{
		require_once HRMS_PLUGIN_DIR.'/admin/payslip/'.$active_tab.'.php';
	}
} ?>
</div>
</div>
</div>
</div>
</div>