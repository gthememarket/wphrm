<?php
	 $obj_HrmgtDepartment=new HrmgtDepartment;	 
	/*$obj_HrmgtAttendanceDetails=new HrmgtAttendanceDetails;
	$AttDetailID = $_REQUEST['detail_id'];	
	$AttData = $obj_HrmgtAttendanceDetails->get_single_attendance_deatail($AttDetailID);	
	$user = get_userdata($AttData[0]->employee_id);	
	$monthNum  = $AttData[0]->month;
	$dateObj   = DateTime::createFromFormat('!m', $monthNum);
	$monthName = $dateObj->format('F');	
	$tatal_month_day = get_days_in_month($AttData[0]->month,$AttData[0]->year);	 */
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#custom_slip').validationEngine();
	$('#month').datepicker({
		dateFormat:'mm',
		changeMonth: true,	
    }); 
	$('#year').datepicker({
		dateFormat:'yy',
		changeYear: true,	
    }); 
} );

</script>
<div class="col-md-12" style="background:#F0F8FF;">
	<div class="col-md-3 col-sm-6 col-xs-12">
		<img height="150px" src="<?php print get_option('hrmgt_system_logo'); ?>" />
	</div>
	<div class="col-md-9  col-sm-6 col-xs-12" style="text-align:center">
		<h1 class="salary_h1"><?php print get_option('hrmgt_system_name'); ?></h1> 
		<p style=" text-decoration: underline;"><?php print get_option('hrmgt_office_address') .','. get_option('hrmgt_contry').','.get_option('hrmgt_contact_number'); ?></p>		
	</div>	
<form method="post" name="generate_slip" id="custom_slip">	
	<h2 style="float:left; border-top:1px solid #ccc; padding:10px 0; width:100%; text-align:center"><?php _e('Payslip  For the month of ','hr_mgt')?><input type="text" id="month" size="2" class="validate[required]" name="month"><input type="text" id="year" class="validate[required]" size="2" name="year"></h2>		
	
	<input type="hidden" name="attendance_detail_id" value="">	
	<!--<input type="hidden" name="employee_id" value="<?php print $user->ID ?>">	
	<input type="hidden" name="department_id" value="<?php print get_user_meta($user->ID,'department',true); ?>">
	<input type="hidden" name="account_number" value="<?php print get_user_meta($user->ID,'account_number',true); ?>">
	<input type="hidden" name="month" value="<?php print $monthNum; ?>">-->
	<input type="hidden" name="custom_slip" value="custom_slip">
<div class="table-responsive custom_tbl">
	<table class="table" style="float: left;">
	<tr>        
		<th style="text-align:right" ><?php _e('Employee Name :','hr_mgt');?></th>
		<td>
			<?php $AllEmp = hrmgt_get_working_user('employee');  ?>
			<select name="employee_id" id="employee_id" class="validate[required]">
					<option><?php _e("Select Employee"); ?></option>
				<?php foreach($AllEmp as $Emp){ ?>
					<option value="<?php print $Emp->ID ?>"><?php print hrmgt_get_display_name($Emp->ID) ?></option>
				<?php } ?>
			</select>
		</td>
		<th style="text-align:right"><?php _e('Account No :','hr_mgt');?></th>
		<td style="width:150px"><input id="custom_slip_account_numner" type="text" name="account_number" value=""></td>		
	</tr>	  
	<tr>
		<th style="text-align:right"><?php _e('Joining Date :','hr_mgt');?></th>
		<td style="width:150px" id="custom_slip_join_date"></td>
		<th style="text-align:right"><?php _e('Contract End Date :','hr_mgt');?></th>
		<td style="width:150px" id="custom_slip_contract_end_date"><?php //print hrmgt_change_dateformat(get_user_meta($user->ID,'contract_end_date',true))  ?></td>
	</tr>
	<tr>
		<th style="text-align:right"><?php _e('Total Days :','hr_mgt');?></th>
		<td><input type="text" name="total_days" value=""> </td>
		<th style="text-align:right"><?php _e('Payable Day :','hr_mgt');?></th>
		<td><input type="text" name="payable_days" value=""></td>
	</tr> 
	<tr>
		<th style="text-align:right" ><?php _e('Department','hr_mgt');?></th>
		<td>
			<?php $AllDept = $obj_HrmgtDepartment->get_all_departments(); ?>
			<select name="department_id" class="validate[required]">			
				<option><?php _e('Select Department','hr_mgt'); ?></option>
				<?php 
					foreach($AllDept as $Dept)
					{ ?>
						<option value="<?php print $Dept->id ?>"><?php print hrmgt_get_department_name($Dept->id) ?></option>
					<?php }
				?>
			</select>
		</td> 
		<th style="text-align:right"><?php _e('Hours','hr_mgt');?></th>
		<td><input type="text" name="hours"></td>
	</tr>	  
</table>
</div>
 
<div class="col-md-6">
<div class="table-responsive ">
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
			<td style="text-align:center"><input type="text" id="custom_slip_ctc_month" name="ctc_month" value=""></td>			
			<td>
				<input type="text" name="basic_salary" value="">						
			</td>			
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td colspan="2"><?php _e('Dearness Allowance (D.A.)','hr_mgt'); ?></td>
			<td><input type="text" name="earning_amount[]" value=""></td>	
			<input type="hidden" name="earning_title[]" value="Dearness_Allowance (D.A.)">			
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td colspan="2"><?php _e('House Rent Allowance (H.R.A.)','hr_mgt'); ?></td>
			<td><input type="text" name="earning_amount[]" value=""></td>	
			<input type="hidden" name="earning_title[]" value="House Rent Allowance (H.R.A.)">			
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td colspan="2"><?php _e('Conveyance Allowance','hr_mgt'); ?></td>
			<td><input type="text" name="earning_amount[]" value=""></td>	
			<input type="hidden" name="earning_title[]" value="Conveyance Allowance">			
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td colspan="2"><?php _e('Travel Allowance (T.A.)','hr_mgt'); ?></td>
			<td><input type="text" name="earning_amount[]" value=""></td>	
			<input type="hidden" name="earning_title[]" value="Travel Allowance (T.A.)">			
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td colspan="2"><?php _e('Medical Allowance','hr_mgt'); ?></td>
			<td><input type="text" name="earning_amount[]" value=""></td>	
			<input type="hidden" name="earning_title[]" value="Medical Allowance">			
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td colspan="2"><?php _e('Food Allowance','hr_mgt'); ?></td>
			<td><input type="text" name="earning_amount[]" value=""></td>	
			<input type="hidden" name="earning_title[]" value="Food Allowance">			
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td colspan="2"><?php _e('Mobile Allowance','hr_mgt'); ?></td>
			<td><input type="text" name="earning_amount[]" value=""></td>	
			<input type="hidden" name="earning_title[]" value="Mobile Allowance">			
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td colspan="2"><?php _e('Performance Incentives','hr_mgt'); ?></td>
			<td><input type="text" name="earning_amount[]" value=""></td>	
			<input type="hidden" name="earning_title[]" value="Perfomance Incentives">			
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td colspan="2"><?php _e('Salary Difference','hr_mgt'); ?></td>
			<td><input type="text" name="earning_amount[]" value=""></td>	
			<input type="hidden" name="earning_title[]" value="Salary Difference">			
		</tr>
		<?php
			$Earnings = get_option('earning');
			if($Earnings)
			foreach($Earnings as $earning)
			{ { ?>
				<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
					<td colspan="2"><?php print str_replace("_"," ",$earning)  ?></td>
					<td><input type="text" name="earning_amount[]" value=""></td>	
					<input type="hidden" name="earning_title[]" value="<?php print str_replace("_"," ",$earning); ?>">			
				</tr>
			<?php } }
		?>
		<tr style="background:#D99594; ">
			<th colspan="2" style="text-transform:uppercase"><?php _e('Total Earning','hr_mgt'); ?></th>
			<th><input name="total_earning" type="text" value="" ></th>			
		</tr>
		
	</table>
</div>
</div>

<div class="col-md-6">
<div class="table-responsive">
	<table class="table">
		<tr style="background:#FABF8F" >
			<th colspan="2" style="text-transform: uppercase; text-align:center"><?php _e('Deduction','hr_mgt'); ?></th>
		</tr>
		<tr style="background:#FBD4B4; border-bottom:2px solid white;" > 			
			<th><?php _e('Salary Head','hr_mgt');?></th>
			<th><?php _e('Amount','hr_mgt');?></th>
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td><?php _e('Professional Tax','hr_mgt'); ?></td>
			<td><input type="text" name="deduction_amount[]" value=""></td>	
			<input type="hidden" name="deduction_title[]" value="Professional Tax">			
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td><?php _e('Loan Repayment / Advance','hr_mgt'); ?></td>
			<td><input type="text" name="deduction_amount[]" value=""></td>	
			<input type="hidden" name="deduction_title[]" value="Loan Repayment / Advance">			
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td><?php _e('Mobile Bill Recovery','hr_mgt'); ?></td>
			<td><input type="text" name="deduction_amount[]" value=""></td>	
			<input type="hidden" name="deduction_title[]" value="Mobile Bill Recovery">			
		</tr>
		<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
			<td><?php _e('Tax Deducted at Source (T.D.S.)','hr_mgt'); ?></td>
			<td><input type="text" name="deduction_amount[]" value=""></td>	
			<input type="hidden" name="deduction_title[]" value="Tax Deducted at Source (T.D.S.)">			
		</tr>
		<?php
			$Deduction = get_option('deduction');
			if($Deduction)
			foreach($Deduction as $deduction)
			{ { ?>
				<tr style="background:#F2DBDB; border-bottom:2px solid white;">			
					<td colspan=""><?php print str_replace("_"," ",$deduction) ?></td>
					<input type="hidden" name="deduction_title[]" value="<?php print str_replace("_"," ",$deduction); ?>">			
					<td><input type="text" name="deduction_amount[]" value=""></td>	
				</tr>
			<?php } }
		?>
		<tr style="background:rgb(250,191,143)">
			<th style="text-transform:uppercase"><?php _e('Total Deduction','hr_mgt'); ?></th>
			<th><input type="text" name="total_deduction" value=""></th>
			
		</tr>	
		<tr style="background:#D99594" >		
			<th style="text-transform: uppercase;" ><?php _e('Net Salary','hr_mgt'); ?></th>
			<th><input type="text" name="net_salary" value=""></th>
			
		</tr>
		
	</table>
</div>
</div>
 
<div class="col-md-12">
<input type="submit" name="submit_payslip" value="Generate Salary Slip" class="btn btn-primary">
<!--<a  href="?page=hrmgt-payslip&print=pdf&type=salary_slip&AttDetail_id=<?php echo $AttDetailID;?>" target="_blank"class="btn btn-success"><?php _e('PDF','hr_mgt');?></a>-->
</div>
</form>
<div class="print-button pull-left">	
</div>  
</div>