<?php 
$AttDetail_id = $_GET['AttDetail_id'];
$system_name = get_option('hrmgt_system_name');
$address = "";
$address .= get_option('hrmgt_office_address');
$address .= ",".get_option('hrmgt_contry');
$address .= ",".get_option('hrmgt_contact_number');

$obj_HrmgtPayslip = new HrmgtPayslip;
$AttData = $obj_HrmgtPayslip->hrmgt_get_single_generated_slip($AttDetail_id);
$user = get_userdata($AttData->employee_id);
$display_name = hrmgt_get_display_name($AttData->employee_id);
$monthNum  = $AttData->month;
$yearNum  = $AttData->year;
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F');
$tatal_month_day = $AttData->total_days;	

$account_number = $AttData->account_number;
if($account_number!='')  $account_number = $account_number; else  $account_number='NA';
$joining_date = hrmgt_change_dateformat(get_user_meta($user->ID,'joining_date',true));
$contract_end_date = hrmgt_change_dateformat(get_user_meta($user->ID,'contract_end_date',true));
 $payable_days = $AttData->payable_days; 

$department = hrmgt_get_department_name($AttData->department_id);

$Hrs =$AttData->hours;
$total_salary = get_user_meta($user->ID,'employee_salary',true);
$total_earning = round(( $total_salary / $tatal_month_day ) * $payable_days);

$system_logo = get_option('hrmgt_system_logo');

$SalaryDate = $dateObj->format('F') .' '. $yearNum;

$Total_Deduction =	"";
$DeductionDatas  =	"";
$EarningDatas    =	"";
$EarningData = json_decode($AttData->earning);
$EarningData = object_to_array($EarningData);
$Earningkeys = array_keys($EarningData);
$Earningvalues = array_values($EarningData);


$employee_code = get_user_meta($user->ID,'employee_code',true);

if(!empty($Earningkeys))
{
	foreach($Earningkeys as $key=>$Earning)
	{		
		$total_earning += $Earningvalues[$key];
		$EarningDatas .= '<tr><td>'.$Earning.'</td><td align="center"></td><td align="center">'.$Earningvalues[$key].'</td></tr>';			
	}
}

$DeductionData = json_decode($AttData->deduction);
$DeductionData = object_to_array($DeductionData);

$Deductionkeys = array_keys($DeductionData);
$Deductionvalues = array_values($DeductionData);
if(!empty($Deductionkeys))
{
	foreach($Deductionkeys as $key=>$Deduction)
	{		
		$Total_Deduction += $Deductionvalues[$key];
		$DeductionDatas .='<tr><td colspan=2>'.$Deduction.'</td><td></td><td align="center">'.$Deductionvalues[$key].'</td></tr>';		
	}
}


$Net_Salary = $total_earning - $Total_Deduction;


ob_clean();
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="salary_records.pdf"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');	
require_once HRMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';	
/* $mpdf	=	new mPDF('c','A4','','' , 5 , 5 , 5 , 0 , 0 , 0); */
$mpdf	=	new mPDF('c','A4','','' , 5 , 5 , 0 , 0 , 0 , 0);
// $mpdf -> SetFont('customfont');
/* ob_start(); */
	$mpdf->debug = true;
	$mpdf->WriteHTML('<html>');
	$mpdf->WriteHTML('<head>');
	$mpdf->WriteHTML('<style>
		table{
			font-family: sans-serif;
			font-size : 12px;	
			color : #444;
		}
		.count td, .count th{
		 
		 border-bottom : 1px solid #d5d5d5;
		 height:40px;
		}
		
		
		#t1{					
			border :0;
			border-color :gray;
			border-collapse:collapse;
		}
		#t1 td{					
			padding : 6px;
		}
		strong{
			color :#333;
		}
		#bold{
			font-weight:bold;
			padding:5px 0;
			
		}
		#tr{
			border-bottom:1px solid #ccc;
		}
		
	</style>');
	$mpdf->WriteHTML('</head>');
	$mpdf->WriteHTML('<body style=font-family:"Open Sans", sans-serif;>');	
	$mpdf->SetTitle('Salary Slip');
	
	$mpdf->WriteHTML('<table width=100%>');
		$mpdf->WriteHTML("<tr>");
			$mpdf->WriteHTML("<td><img height=100 width=100 src={$system_logo} /></td>");	
			$mpdf->WriteHTML("<td align=center><h3>{$system_name}</h3> <br> <strong>Address : </strong> {$address}");		
		$mpdf->WriteHTML("</tr>");		
	$mpdf->WriteHTML('</table>');	
	$mpdf->WriteHTML('<hr/>');
	$mpdf->WriteHTML('<table width=100%>');
	$mpdf->WriteHTML("<tr>");
			$mpdf->WriteHTML("<td align=center><h3>Payslip For the month of {$SalaryDate}</h3></td>");		
		$mpdf->WriteHTML("</tr>");
	$mpdf->WriteHTML('</table>');	
	
	$mpdf->WriteHTML('<hr/>');
	
	$mpdf->WriteHTML('<table width=100%>');
		$mpdf->WriteHTML("<tr>");
		$mpdf->WriteHTML("<td width=100px id=bold >Full Name :</td><td align=left>{$display_name} ({$employee_code})</td>");
			$mpdf->WriteHTML("<td width=120px id=bold>Account No. :</td><td align=left> {$account_number}</td>");
		$mpdf->WriteHTML("</tr>");
		
		$mpdf->WriteHTML("<tr>");
			$mpdf->WriteHTML("<td id=bold>Joining Date :</td><td align=left>{$joining_date}</td>");
			$mpdf->WriteHTML("<td width=150px id=bold>Contract End Date :</td><td align=left>{$contract_end_date}</td>");
		$mpdf->WriteHTML("</tr>");
	
		$mpdf->WriteHTML("<tr>");
			$mpdf->WriteHTML("<td id=bold >Total Days :</td><td align=left>{$tatal_month_day}</td>");
			$mpdf->WriteHTML("<td id=bold >Payable Day :</td><td align=left>{$payable_days} Days</td>");
		$mpdf->WriteHTML("</tr>");
		
		$mpdf->WriteHTML("<tr>");
			$mpdf->WriteHTML("<td id=bold >Department : </td><td align=left>{$department}</td>");
			$mpdf->WriteHTML("<td id=bold >Hours :</td><td align=left>{$Hrs} Hrs</td>");	
		$mpdf->WriteHTML("</tr>");	
	
	$mpdf->WriteHTML('</table>');
	
	$mpdf->WriteHTML('<hr/>');
	
	
	$mpdf->WriteHTML('<div style="float:left; width: 100%;">	
	<div style="float:left; width: 50%;">
	<table width=100% class="count" style="background:#F2DBDB">
		<thead>
			<tr>
				<th colspan=3 style="background: #D99594;border-bottom:0">EARNINGS</th>
			</tr>
			<tr>
				<th align=left>Salary Head</th>
				<th class="text-center" >CTC (Month)</th>
				<th align="center" >Amount</th>
			</tr>
			<tr>
				<td align=left>Basic Salary</td>
				<td class="text-center" >'.$AttData->ctc_month .'</td>
				<td align="center" >'. $AttData->basic_salary .'</td>
			</tr>
		</thead>
		<tbody>'.$EarningDatas.'<tbody>
		<tfoot>
			<tr>
				<th align="left" colspan=2 style="background:#D99493;border-bottom:0">TOTAL EARNING</th>
				<th style="background:#D99493;"><span style="float:right" id="net_pay">'.$AttData->total_earning .'</span></th>
			</tr>				
		</tfoot>
	</table>
		</div>		
		<div style="float: right; width: 50%;">
		<div style="border-left:1px solid #dedede">
			<table width=100% class="count" style="background:#FBD4B4">
			<thead>
				<tr style="background:#FABF8F">
					<th colspan=4 style="border-bottom:0">DEDUCTIONS</th>					
				</tr>
				<tr>
					<th align="left">Salary Head</th>					
					<th></th>
					<th></th>
					<th align="center">Amount</th>
				</tr>
			</thead>
			<tbody>'.$DeductionDatas.'</tbody>
			<tfoot>
				<tr>
					<th align="left" colspan=3 style="background:#FABF8F;border-bottom:0">TOTAL DEDUCTIONS</th>
					<th style="background:#FABF8F;"><span style="float:right" id="net_pay">'.$AttData->total_deduction .'</span></th>
				</tr>
				<tr>
					<th align="left" colspan=3 style="background:#D99493;border-bottom:0">NET SALARY</th>
					<th style="background:#D99493;"><span style="float:right" id="net_pay">'.$AttData->net_salary .'</span></th>
				</tr>
			</tfoot>
			</table>	
		  </div>	
		</div>');
		$mpdf->WriteHTML('<table width=100% style=margin-top:100>');
			
			$mpdf->WriteHTML('<tr>');
				$mpdf->WriteHTML('<td align=left><hr /></td>');							
				$mpdf->WriteHTML('<td width=200></td>');							
				$mpdf->WriteHTML('<td align=right><hr /></td>');									
			$mpdf->WriteHTML('</tr>');
			
			$mpdf->WriteHTML('<tr>');
				$mpdf->WriteHTML('<td align=left>HR Manager</td>');				
				$mpdf->WriteHTML('<td width=200></td>');				
				$mpdf->WriteHTML('<td align=right> Authorized Signature</td>');							
			$mpdf->WriteHTML('</tr>');			
		$mpdf->WriteHTML('</table>'); 
	
		
		$mpdf->WriteHTML("</body>");
	$mpdf->WriteHTML("</html>");
	
	$mpdf->Output();	
	ob_end_flush();
	unset($mpdf);
	exit();
die; 	
?>