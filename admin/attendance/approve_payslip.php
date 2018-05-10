<?php	
	$obj_HrmgtAttendanceDetails=new HrmgtAttendanceDetails;
	$AttDetailID = $_REQUEST['detail_id'];	
	$AttData = $obj_HrmgtAttendanceDetails->get_single_attendance_deatail($AttDetailID);	
	$user = get_userdata($AttData[0]->employee_id);	
	$monthNum  = $AttData[0]->month;
	$dateObj   = DateTime::createFromFormat('!m', $monthNum);
	$monthName = $dateObj->format('F');	
	$tatal_month_day = get_days_in_month($AttData[0]->month,$AttData[0]->year);
?>
<div class="col-md-12">
	<div class="col-md-12">
		<img style=" margin: auto;" src="<?php print get_option('hrmgt_system_logo'); ?>" class="img-responsive slip_logo" />			
	</div>
	<h4 style="float:left; width:100%; text-align:center"><?php _e('Payslip  For the month of','hr_mgt'). print ' '. $monthName .' '. $AttData[0]->year ?></h4>	
	
	<table class="table" style="margin: 50px 0;  float: left;">
		<tr>        
			<th><?php _e('Employee Name','hr_mgt');?></th>
			<td><?php print hrmgt_get_display_name($user->ID);?></td>
			 <th><?php _e('Bank Account No','hr_mgt');?></th>
         <td>
			<?php 
				$account_number = get_user_meta($user->ID,'account_number',true);				
				print empty($account_number)?$account_number :'NA';
			?>
		 </td>
		</tr>	  
		<tr>
			<th><?php _e('Joining Date','hr_mgt');?></th>
			<td><?php print hrmgt_change_dateformat(get_user_meta($user->ID,'joining_date',true))  ?></td>
			<th><?php _e('Contract End Date','hr_mgt');?></th>
			<td><?php print hrmgt_change_dateformat(get_user_meta($user->ID,'contract_end_date',true))  ?></td>
		</tr>
		<tr>
			<th><?php _e('Total Days','hr_mgt');?></th>
			<td><?php print $tatal_month_day  ?></td>
			<th><?php _e('Payable Day','hr_mgt');?></th>
			<td> <?php print $AttData[0]->payable_days .' Days' ?></td>
		</tr> 
		<tr>
			<th><?php _e('Department','hr_mgt');?></th>
			<td><?php print hrmgt_get_department_name(get_user_meta($user->ID,'department',true)) ?></td> 
			<th><?php _e('Hours','hr_mgt');?></th>
			<td> <?php print   $obj_HrmgtAttendanceDetails->get_monthly_working_hour($user->ID,$AttData[0]->month,$AttData[0]->year). ' Hrs'  ?></td>
		</tr>	  
  </table>
  
<div class="col-md-6">
	<table class="table table-bordered">
		<tr style="background:#D99594; text-align: center;" > 
			<th colspan="3" style="text-transform: uppercase; text-align:center"><?php _e('Earnings','hr_mgt'); ?></th>
		</tr>
		<tr style="background:#F2DBDB">
			<th><?php _e('Salary Head','hr_mgt');?></th>
			<th><?php _e('CTC(Month)','hr_mgt');?></th>
			<th><?php _e('Amount','hr_mgt');?></th>
		</tr>
		<tr style="background:#F2DBDB" >			
			<td><?php _e('Basic Salary','hr_mgt'); ?></td>
			<td><?php print  $total_salary = get_user_meta($user->ID,'employee_salary',true); ?></td>
			<td>
				<?php
					$total_salary = get_user_meta($user->ID,'employee_salary',true);
					print $total_earning = round(( $total_salary / $tatal_month_day ) * $AttData[0]->payable_days);
				?>
			</td>
		</tr>
		<?php 
			$earnings= get_monthly_emoployee_earning($user->ID,$AttData[0]->month,$AttData[0]->year);			
			if(!empty($earnings))
			{
				$m=0;
				foreach($earnings as $earning)
				{	
					$exatrasalay[] = json_decode($earning->extra_salary_entry);					
				}
				foreach($exatrasalay as $salarys)
				{
					foreach($salarys as $entrys)
					{
					?>
						<tr style="background:#F2DBDB">
							<td><?php print $entrys->entry; ?></td>
							<td><?php print "0"; ?></td>
							<td><?php print  $entrys->amount; ?></td>
						</tr>
						<?php 						
						$total_earning = $total_earning + $entrys->amount;
					}
				}
			}
		?>	
		<tr style="background:#D99594">			
			<th colspan="2" style="text-transform: uppercase;" ><?php _e('Total Earnings','hr_mgt'); ?></th>
			<th><?php print  $total_earning ?></th>
		</tr>		
	</table>
</div>

<div class="col-md-6">
	<table class="table table-bordered">
		<tr style="background:#FABF8F" >
			<th colspan="2" style="text-transform: uppercase; text-align:center"><?php _e('Deduction','hr_mgt'); ?></th>
		</tr>
		<tr style="background:#FBD4B4" > 			
			<th><?php _e('Salary Head','hr_mgt');?></th>
			<th><?php _e('Amount','hr_mgt');?></th>
		</tr>
		<?php 
			$deductions= get_monthly_emoployee_earning($user->ID,$AttData[0]->month,$AttData[0]->year);
			if(!empty($deductions))
			{
				$m=0;
				foreach($deductions as $deduction)
				{	
					$DeductionAmount[] = json_decode($deduction->extra_deduction_entry);					
				}
				
				$total_deduction = 0;
				foreach($DeductionAmount as $deductionSalary)
				{					
					foreach($deductionSalary as $deductionsal)
					{
					?>
						<tr style="background:#FBD4B4">							
							<td><?php print $deductionsal->entry; ?></td>
							<td><?php print  $deductionsal->amount; ?></td>
						</tr>
					<?php 
						$total_deduction = $total_deduction+ $deductionsal->amount;
					}
				}
			}
		?>
		<tr style="background:#FABF8F" >		
			<th colspan="1" style="text-transform: uppercase;" ><?php _e('Total Deduction','hr_mgt'); ?></th>
			<th><?php print  $total_deduction ?></th>
		</tr>
		<tr style="background:#D99594" >		
			<th style="text-transform: uppercase;" ><?php _e('Net Salary','hr_mgt'); ?></th>
			<th><?php print $total_earning - $total_deduction; ?></th>
		</tr>
		
	</table>
</div>			

<div class="print-button pull-left">
	<a  href="?page=hrmgt-attendance&print=print&type=salary_slip&AttDetail_id=<?php echo $AttDetailID;?>" target="_blank"class="btn btn-success"><?php _e('Print','hr_mgt');?></a>
</div>  
</div>