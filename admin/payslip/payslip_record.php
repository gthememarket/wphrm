<div class="popup-bg">
    <div class="overlay-content">
		<div class="category_list"></div>    
    </div> 
</div>
<div class="panel panel-white">
<div class="panel-body">
<?php 
if($active_tab == 'payslip_record')
{
$obj_HrmgtPayslip = new HrmgtPayslip();
?>	
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#assets_list').DataTable({
		"bProcessing": true,
				 "bServerSide": true,
				 "sAjaxSource": ajaxurl+'?action=datatable_payslip_record_ajax_to_load',
				 "bDeferRender": true,	
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
				<th><?php _e( 'Action', 'hr_mgt' ) ;?></th>	
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
				<th><?php _e( 'Action', 'hr_mgt' ) ;?></th>				
            </tr>           
        </tfoot> 
    <!--    <tbody>
        <?php 
		$SlipData=$obj_HrmgtPayslip->hrmgt_get_generated_slip();		
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
				<td class="start"><a  href="?page=hrmgt-payslip&print=pdf&type=salary_slip&AttDetail_id=<?php echo $retrieved_data->id;?>" target="_blank"class="btn btn-success"><?php _e('PDF','hr_mgt');?></a></td>				
             </tr>
        <?php } } ?>
		</tbody>-->
    </table>
</div>
<?php
}
?>
</div>	
</div>