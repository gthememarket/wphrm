<?php 
$class='change_status';
$obj_HrmgtAttendanceDetails=new HrmgtAttendanceDetails;
$obj_PlManagement = new PlManagement;
if(isset($_POST['appove_payslip']))
{
	global $wpdb;
	$tbl_approve_salary_slip = $wpdb->prefix.'hrmgt_attendance_details';
	$updatedata['approval_status']=1;
	$whereID['id']= $_POST['att_Detail_id'];
	$result = $wpdb->update($tbl_approve_salary_slip,$updatedata,$whereID);	
}

if(isset($_POST['update_attendance']))
{
	$obj_HrmgtAttendanceDetails->update_attendance_details($_POST); 
}

if(isset($_REQUEST['AttendanceDetails_id']))
{	
	$EditAll =0;
	$Attrecord = $obj_HrmgtAttendanceDetails->get_single_attendance_deatail($_GET['AttendanceDetails_id']);
}
else
{	
	$EditAll =1;
	$Attrecord = $obj_HrmgtAttendanceDetails->get_all_attendance_deatail($_REQUEST);
}

?>
<script>
$(function (){
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<style>
a strong 
{
	color:white;
}
a:hover
{
	text-decoration:none;
}
hr,br
{
	margin:0;
	padding:0;
}
</style>
<div class="popup-bg">
    <div class="overlay-content" style="margin: 0 0 0 -10%; top: 10%; left:30%; width: 70%; }">
		<div class="modal-content">
			<div class="category_list"></div>
		</div>
    </div> 
</div>
<?php foreach($Attrecord as $key=>$record){ ?>
<div class="row" style="min-height:50px; line-height:60px">	
	<div class="col-sm-4">
		<strong><?php _e('Name','hr_mgt') ?> :</strong> <?php echo hrmgt_get_display_name($record->employee_id);?>
	</div>
	<div class="col-sm-4">
		<strong><?php _e('Designation','hr_mgt') ?> :</strong> <?php echo get_the_title( get_user_meta($record->employee_id,'designation',true)) ?>
	</div>	
</div>
<?php
	global $wpdb;
	$dates 		= 	array();
	$month 		= 	$record->month;
	$year 		= 	$record->year;
	$user_id 	= 	$record->employee_id;
	$start_date = 	"01-".$month."-".$year;
	$start_time = 	strtotime($start_date);		
	$end_time 	= 	strtotime("+1 month", $start_time);
	$tbl_name 	= 	$wpdb->prefix.'hrmgt_attendance';			
	$days 		= 	cal_days_in_month(CAL_GREGORIAN, $month, $year);
	for($i=$start_time; $i<$end_time; $i+=86400)
	{
	   $dates[] = date('Y-m-d D', $i);
	}	
if($EditAll==0)
{  ?>
<div class="row">
	<div class="col-md-8">	
		<div class="calender">
		<div class="calender-header"><h4><?php echo date('F', mktime(0, 0, 0, $record->month, 10)); ?> - <?php echo $record->year ?></h4></div>
		<?php			
			print '<div class="dayname_sel">Sun</div>';
			print '<div class="dayname_sel">Mon</div>';
			print '<div class="dayname_sel">Tue</div>';
			print '<div class="dayname_sel">Wed</div>';
			print '<div class="dayname_sel">Thu</div>';
			print '<div class="dayname_sel">Fri</div>';
			print '<div class="dayname_sel">Sat</div>';
			
				$PreviewsMonth =  get_days_in_month($month-1,$year);				
				$premon =  $month-1;				
				$firstday = day_name_by_month_year(1,$month,$year);				
				if($firstday=="Mon")
				{					
					$a = $PreviewsMonth - 1;
					for($i=1; $i<=1; $i++)
					{
						$days = $a+$i;
						print '<div class="cal_sel">
							<div class=" cel_inner blanck_sel">
								<div class="grey attendence_padding" style="background:lightblue">'.$days.'</div>
								<hr><div class="att-status"><b>'.get_attendance_status_by_date($year.'-'.$premon.'-'.$days,$record->employee_id).'</b></div>
							</div></div>';
					}
				}

				elseif($firstday=="Tue")
				{
					$a = $PreviewsMonth - 2;
					for($i=1; $i<=2; $i++)
					{
						$days = $a+$i;
						print '<div class="cal_sel">
							<div class=" cel_inner blanck_sel">
								<div class="grey attendence_padding" style="background:lightblue">'.$days.'</div>
								<hr><div class="att-status"><b>'.get_attendance_status_by_date($year.'-'.$premon.'-'.$days,$record->employee_id).'</b></div>
							</div></div>';
					}
				}

				elseif($firstday=="Wed")
				{
					$a = $PreviewsMonth -3 ;
					for($i=1; $i<=3; $i++)
					{
						$days = $a+$i;
						print '<div class="cal_sel">
							<div class=" cel_inner blanck_sel">
								<div class="grey attendence_padding" style="background:lightblue">'.$days.'</div>
								<hr><div class="att-status"><b>'.get_attendance_status_by_date($year.'-'.$premon.'-'.$days,$record->employee_id).'</b></div>
							</div></div>';
					}
				}

				elseif($firstday=="Thu")
				{
					$a = $PreviewsMonth - 4;
					for($i=1; $i<=4; $i++)
					{
						$days = $a+$i;
						print '<div class="cal_sel">
							<div class=" cel_inner blanck_sel">
								<div class="grey attendence_padding" style="background:lightblue">'.$days.'</div>
								<hr><div class="att-status"><b>'.get_attendance_status_by_date($year.'-'.$premon.'-'.$days,$record->employee_id).'</b></div>
							</div></div>';
					}				
				}

				elseif($firstday=="Fri")
				{					
					$a = $PreviewsMonth - 5;
					for($i=1; $i<=5; $i++)
					{
						$days = $a+$i;
						print '<div class="cal_sel">
							<div class=" cel_inner blanck_sel">
								<div class="grey attendence_padding" style="background:lightblue">'.$days.'</div>
								<hr><div class="att-status"><b>'.get_attendance_status_by_date($year.'-'.$premon.'-'.$days,$record->employee_id).'</b></div>
							</div></div>';
					}					
				}

				elseif($firstday=="Sat")
				{
					$a = $PreviewsMonth - 6;
					for($i=1; $i<=6; $i++)
					{
						$days = $a+$i;
						 print '<div class="cal_sel">
							<div class=" cel_inner blanck_sel">
								<div class="grey attendence_padding" style="background:lightblue">'.$days.'</div>
								<hr><div class="att-status"><b>'.get_attendance_status_by_date($year.'-'.$premon.'-'.$days,$record->employee_id).'</b></div>
							</div></div>';
					}
				}
				
				
			foreach($dates as $date)
			{
				$print_d = date("d",strtotime($date));			

			?>				
			<div class="cal_sel">
			<?php
				$curr_d = date("d");				
				if($curr_d==$print_d){ $classs="current-day cel_inner"; }else{ $classs="cel_inner"; }
				$print_d = date("d",strtotime($date));?>
				<b><?php 
				$date = date("Y-m-d",strtotime($date));
				$year = date("Y",strtotime($date));
				$month = date("m",strtotime($date));
				$day = date("j",strtotime($date));				
				$attadata = $wpdb->get_row("SELECT * FROM {$tbl_name} WHERE employee_id={$record->employee_id} AND attendance_date='{$year}-{$month}-{$day}'");
				
				$manual_before= "<div class='{$classs} ' style='color:white'> <div class='grey attendence_padding'>$print_d</div><hr><div class='att-status'>";
					$manual_after= "</div></div>";
					$defult_befor= "<div class=' {$classs}' style='color:grey' > <div class='grey attendence_padding'>$print_d</div><hr><div class='att-status'>";
					$defult_after ="</div></div>";
						echo "<td>";			
						$myday= 'day_'.$day;
						switch($record->$myday)
						{ 
							CASE "AA" :						
								echo "<a href='#' class='$class' day='$day' status='AA' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'>$defult_befor <span class='text-warning'>AA</span> $defult_after</a>";									
							break;
								
								CASE "manual_AA" :						
									echo "<a href='#' class='$class x_{$day}' day='$day' status='AA' id='x_{$day}' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'><div style='background:#F0AD4E'> $manual_before AA $manual_after</div></a>";
									break;
									
								CASE "A" :	
									echo "<a href='#' class='$class' status='A' detail_id='".$record->id."' day='$day' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'>$defult_befor <span class='	text-danger'>" ?>
									<?php																	
										$next_day = $day +1;									
										if($day < $next_day)
										{
											print "A";
										}
										elseif($day >$next_day && $month < date('m') && $year==date('Y'))
										{
											print "A";
										}
										else
										{
											print "-";
										}
								?>
								<?php print "</span> $defult_after</a>";
								break;
								
								CASE "manual_A" :						
									echo "<a href='#' class='$class x_{$day}' status='A' detail_id='{$record->id}' id='x_$day' data='$user_id/$day/$month/$year' date='{$day}/{$month}/{$year}'><div style='background:#D9534F'>$manual_before A $manual_after </div></a>";
									break;
									
								CASE "P" :
									echo "<a href='#' data-toggle='tooltip'  title='Working Hrs : $attadata->working_hours' 
									day='$day' class='$class' status='P' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}' >$defult_befor <span class='text-success'>P</span>$defult_after</a>";
								break;
								
								CASE "manual_P" :						
									echo "<a href='#' data-toggle='tooltip'  class='$class x_{$day}' status='P' day='$day' id='x_$day' detail_id='$record->id' data='$user_id/$day/$month/$year' date='{$day}/{$month}/{$year}'> <div style='background:#5CB85C'>$manual_before P $manual_after</div></a>";
									break;
									
								CASE "H" :						
									echo "<a href='#' class='$class'day='$day' data-toggle='tooltip'  title='Holiday'  status='H' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'>$defult_befor<span class='text-primary'>H</span>$defult_after</a>";
								break;
								
								CASE "manual_H" :						
									echo "<a href='#' data-toggle='tooltip'  title='Holiday'  class='$class x_{$day}' day='$day' status='H' id='x_{$day}' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'><div style='background:#9594D1'>$manual_before H $manual_after</div></a>";								
								break;
								
								CASE "HL" :					
								?>
									<a href="#" data-toggle="tooltip" <?php	 if(isset($attadata->working_hours)){ print "title='Working Hrs : $attadata->working_hours '";  } ?> 
									class="<?php print $class ?>" day="<?php print $day ?>" status="HL" detail_id="<?php print $record->id ?> " data="<?php print $user_id.'/'.$day.'/'.$month.'/'.$year?>" date="<?php print $day.'/'.$month.'/'.$year?> "><?php print $defult_befor ?><span class='text-info'>P/2</span><?php print $defult_after ?></a>
							<?php 
								break;								
								CASE "manual_HL" :						
									echo "<a href='#' class='$class x_{$day}' status='HL' id='x_{$day}' day='$day' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'><div style='background:#428BCA'>$manual_before P/2 $manual_after </div></a>";									
								break;
							
								CASE "P.5" :						
									echo "<a href='#' data-toggle='tooltip'  title='Working Hrs : $attadata->working_hours' class='$class ' status='P.5' day='$day' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'>$defult_befor <span style='color:#0275D8'>P.5</span>$defult_after </a>";
								break;
								
								CASE "manual_P.5" :					
									echo "<a href='#' class='$class x_{$day}' day='$day' status='P.5' id='x_{$day}' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'><div style='background:#0275D8'>$manual_before P.5 $manual_after </div></a>";									
								break;
								CASE "-" :						
									echo "<a href='#' class='$class ' status='-' day='$day' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'>$defult_befor<span style='color:red'>-</span>$defult_after</a>";
								break;							
							}							
					?></b>				
			</div>
		<?php }   ?>
		</div>
		<?php 			
		if($month < date("n") && $year <= date("Y")){ ?>			
			<form method="post" style="float:left">				
				<input type="hidden" name="att_Detail_id" value="<?php print $record->id ?>"><br>
				<?php if($record->approval_status=='0'){ ?>
					<input class="btn btn-primary"  value="<?php _e('Approve','hr_mgt') ?>" type="submit" name="appove_payslip">
				<?php } else{ ?>				
					<input class="btn btn-primary" style="color:white"  value="<?php _e('Approved','hr_mgt') ?>" type="submit" name="appove_payslip" disabled>
				<?php } ?>				
			</form>			
		<?php } ?>
	</div>
	
	<div class="col-md-4">		
		<table class="table-bordered table">
			<tr>
				<th style="text-align: center;font-weight: bold;" colspan="7"><?php _e('Total','hr_mgt');?></th>
			</tr>
			<tr>
				<th class="label-success" style='color:#fff; font-weight: bold;'><?php _e('P','hr_mgt')?></th>
				<th class="label-danger" style='color:#fff; font-weight: bold;'><?php _e('A','hr_mgt')?></th>
				<th class="label-primary" style='color:#fff; font-weight: bold;' ><?php _e('H','hr_mgt')?></th>
				<th class="label-success" style='color:#fff; font-weight: bold;' ><?php _e('HL','hr_mgt')?></th>
				<th class="label-warning" style='color:#fff; font-weight: bold;' ><?php _e('AA','hr_mgt')?></th>
				<th style='color:#fff; background:#0275D8; font-weight: bold;' ><?php _e('P.5','hr_mgt')?></th>
				<th style="color:#fff; background:#F45C42; font-weight: bold;"><?php _e('Total Hrs / Out Of Hrs ','hr_mgt')?></th>
			</tr>
			<tr>
				<td align="center"><?php print $record->tatal_present; ?></td>
				<td align="center"><?php print $obj_HrmgtAttendanceDetails->hrmgt_get_absent(date("d"),$month,$year,$record->employee_id); //if($record->tatal_absent=='') print 0; else print $record->tatal_absent ?></td>
				<td align="center"><?php echo $record->tatal_holidy ; ?></td>
				<td align="center"><?php echo $record->total_hl; ?></td>
				<td align="center"><?php echo $record->total_aa; ?></td>
				<td align="center"><?php echo $record->total_p_p; ?></td>
				<td align="center"><?php echo $obj_HrmgtAttendanceDetails->get_monthly_working_hour($record->employee_id,$record->month,$record->year).'/'. $obj_HrmgtAttendanceDetails->get_outof_working_hour($record->employee_id,$record->month,$record->year); ?></td>
			</tr>			
		</table>	
		
		<table class="table-bordered table">
			<tr>
				<th style="text-align: center;font-weight: bold;" colspan="4">PL</th>
				<th style="text-align: center;font-weight: bold;"><?php _e('Pay.<br>Days','hr_mgt'); ?></th>
			</tr>
			<tr>
				<td><?php _e('Opening','hr_mgt')?></td>
				<td><?php _e('New','hr_mgt')?></td>
				<td><?php _e('Used','hr_mgt')?></td>
				<td><?php _e('Remaining','hr_mgt')?></td>
				<td rowspan="2" align="center" style="vertical-align: middle;" ><?php echo $record->payable_days ; ?></td>
			</tr>
			<tr>
				<td align="center"><?php echo $record->opening_pl ; ?></td>
				<td><?php print $obj_PlManagement->hrmgt_get_emp_pl($record->employee_id,$month,$year);	?></td>
				<td align="center"><?php echo $record->used_pl ; ?></td>
				<td align="center"><?php echo $record->remaining_pl ; ?></td>				
			</tr>			
		</table>	
	</div>		
	</div>
<?php  } 
if($EditAll==1)
{

?>	
<div style="overflow-x:auto;">
	<table class='table table-bordered'>
		<thead>
			<tr class="active">
			<?php
			global $wpdb;
			$tbl_name = $wpdb->prefix.'hrmgt_attendance';				
			foreach($dates as $date)
			{
				$curr_d = date("d");
				$print_d = date("d",strtotime($date));
				$highlight = ($curr_d === $print_d) ? "danger" : "";
				echo "<th rowspan='2' style='border:1px solid !important' class='text-center {$highlight}'>".substr(day_name_by_month_year($print_d,$month,$year),0,1)."<br><br>".$print_d."</th>";
			}
			?>
				<th colspan="7" class='text-center' style='border:1px solid !important'><?php _e('TOTAL','hr_mgt')?></th>
				<th colspan="4" class='text-center' style='border:1px solid !important'><?php _e('PL','hr_mgt')?></th>
				<th rowspan="2" class='text-center' style='border:1px solid !important'><?php _e('Pay.<br> Days','hr_mgt')?></th>
			</tr>
			<tr>
				<td class="label-success" style='color:#fff;'><strong>&nbsp;<?php _e('P','hr_mgt')?></strong></td>
				<td class="label-danger" style='color:#fff;'><strong>&nbsp;<?php _e('A','hr_mgt')?></strong></td>
				<td class="label-primary" style='color:#fff;'><strong><?php _e('H','hr_mgt')?></strong></td>
				<td class="label-success" style='color:#fff;'><strong><?php _e('HL','hr_mgt')?></strong></td>
				<td class="label-warning" style='color:#fff;'><strong><?php _e('AA','hr_mgt')?></strong></td>
				<td style='color:#fff; background:orange'><strong><?php _e('P.5','hr_mgt')?></strong></td>
				<td style='color:#fff; background:#F45C42'><strong><?php _e('Total Hrs / Out Of Hrs ','hr_mgt')?></strong></td>
				<td><?php _e('Opening','hr_mgt')?></td>
				<td><?php _e('New','hr_mgt')?></td>
				<td><?php _e('Used','hr_mgt')?></td>
				<td><?php _e('Remaining','hr_mgt')?></td>
			</tr>
		</thead>		
		<tbody>			
			<tr>
			<?php
			foreach($dates as $date)
			{
				$date 	= 	date("Y-m-d",strtotime($date));
				$year 	= 	date("Y",strtotime($date));
				$month 	=	date("m",strtotime($date));
				$day 	= 	date("j",strtotime($date));				
				$attadata 	= 	$wpdb->get_row("SELECT * FROM {$tbl_name} WHERE employee_id={$record->employee_id} AND attendance_date='{$year}-{$month}-{$day}'");
						
				echo "<td>";			
				$myday= 'day_'.$day;
				switch($record->$myday)
				{
					CASE "AA" :
						echo "<a href='#' class='$class' day='$day' status='AA' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}' ><strong><span class='text-warning'>AA</span></strong></a>";
					break;
					CASE "manual_AA" :						
						echo "<a href='#' class='$class x_{$day}' day='$day' status='AA' id='x_{$day}' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'><strong>AA</strong></a>";
						echo "<script>$('.x_{$day}').parents('td').css({'background':'#F0AD4E'});</script>";
						break;
					CASE "A" :
						echo "<a href='#' class='$class' status='A' detail_id='".$record->id."' day='$day' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'><strong><span  class='text-danger'>" ?>
						<?php 
						$next_day = $day +1;						
						if($day < $next_day)
						{
							print "A";
						}
						elseif($day > $next_day && $month < date('m') && $year==date('Y'))
						{							
							print "A";
						}
						else
						{
							print "-";
						}
						?>
						<?php print "</span></strong></a>";
					break;
					CASE "manual_A" :
						echo "<a href='#' class='$class x_{$day}' status='A' detail_id='{$record->id}' id='x_$day' data='$user_id/$day/$month/$year' date='{$day}/{$month}/{$year}'><strong>&nbsp;A</strong></a>";
						echo "<script>$('.x_$day').parents('td').css({'background':'#D9534F','color':'white'});</script>";
					break;
					CASE "P" :
						echo "<a href='#' data-toggle='tooltip'  title='Working Hrs : $attadata->working_hours' 
						day='$day' class='$class' status='P' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}' ><strong><span class='text-success'>&nbsp;P</span></strong></a>";
					break;
					CASE "manual_P" :
						echo "<a href='#' class='$class x_{$day}' status='P' day='$day' id='x_$day' detail_id='$record->id' data='$user_id/$day/$month/$year' date='{$day}/{$month}/{$year}'><strong>&nbsp;P</strong></a>";
						echo "<script>$('.x_$day').parents('td').css({'background':'#5CB85C'});</script>";
					break;
					CASE "H" :
						echo "<a href='#' class='$class'day='$day' data-toggle='tooltip'  title='Holiday'  status='H' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'><strong><span class='text-primary'>&nbsp;H</span></strong></a>";
					break;
					CASE "manual_H" :
						echo "<a href='#' data-toggle='tooltip'  title='Holiday'  class='$class x_{$day}' day='$day' status='H' id='x_{$day}' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'><strong>&nbsp;H</strong></a>";
						echo "<script>$('.x_{$day}').parents('td').css({'background':'#9594D1'});</script>";
					break;
					CASE "HL" :	 ?>
						<a href="#" data-toggle="tooltip" <?php	 if(isset($attadata->working_hours)){ print "title='Working Hrs : $attadata->working_hours '";  } ?> 
						class="<?php print $class ?>" day="<?php print $day ?>" status="HL" detail_id="<?php print $record->id ?> " data="<?php print $user_id.'/'.$day.'/'.$month.'/'.$year?>" date="<?php print $day.'/'.$month.'/'.$year?> "><strong><span class='text-info'>P/2</span></strong></a>
					<?php 					
					break;
					CASE "manual_HL" :
						echo "<a href='#' class='$class x_{$day}' status='HL' id='x_{$day}' day='$day' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'><strong>P/2</strong></a>";
						echo "<script>$('.x_{$day}').parents('td').css({'background':'#428BCA','color':'white'});</script>";
					break;
				
					CASE "P.5" :
						echo "<a href='#' data-toggle='tooltip'  title='Working Hrs : $attadata->working_hours' class='$class ' status='P.5' day='$day' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'><strong><span style='color:orange'>P.5</span></strong></a>";
					break;
					
					CASE "manual_P.5" :
						echo "<a href='#' class='$class x_{$day}' day='$day' status='P.5' id='x_{$day}' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'><strong>P.5</strong></a>";
						echo "<script>$('.x_{$day}').parents('td').css({'background':'orange'});</script>";
					break;
					CASE "-" :
						echo "<a href='#' class='$class ' status='-' day='$day' detail_id='{$record->id}' data='{$user_id}/{$day}/{$month}/{$year}' date='{$day}/{$month}/{$year}'><strong><span style='color:red'>-</span></strong></a>";
					break;					
				}
				echo "</td>";
			}
			?>	
				<td align="center"><?php print $record->tatal_present; ?></td>
				<td align="center"><?php print $obj_HrmgtAttendanceDetails->hrmgt_get_absent(date("d"),$month,$year,$record->employee_id); //if($record->tatal_absent=='') print 0; else print $record->tatal_absent ?></td>
				<td align="center"><?php echo $record->tatal_holidy ; ?></td>
				<td align="center"><?php echo $record->total_hl; ?></td>
				<td align="center"><?php echo $record->total_aa; ?></td>
				<td align="center"><?php echo $record->total_p_p; ?></td>
				<td align="center"><?php echo $obj_HrmgtAttendanceDetails->get_monthly_working_hour($record->employee_id,$record->month,$record->year).'/'. $obj_HrmgtAttendanceDetails->get_outof_working_hour($record->employee_id,$record->month,$record->year); ?></td>
				<td align="center"><?php echo $record->opening_pl ; ?></td>
				<td><?php print $obj_PlManagement->hrmgt_get_emp_pl($record->employee_id,$month,$year);	?></td>
				<td align="center"><?php echo $record->used_pl ; ?></td>
				<td align="center"><?php echo $record->remaining_pl ; ?></td>
				<td align="center"><?php echo $record->payable_days ; ?></td>
			</tr>			
		</tbody>
	</table>
	<br/>
	<br/>
	<br/>
<?php 
	if($month < date("n") && $year <= date("Y"))
	{ ?>
		<form method="post" style="float:left">				
			<input type="hidden" name="att_Detail_id" value="<?php print $record->id ?>"><br>
			<?php if($record->approval_status=='0'){ ?>
				<input class="btn btn-primary"  value="<?php _e('Approve','hr_mgt') ?>" type="submit" name="appove_payslip">
			<?php } else{ ?>				
				<input class="btn btn-primary" style="color:white"  value="<?php _e('Approved','hr_mgt') ?>" type="submit" name="appove_payslip" disabled>
			<?php } ?>				
		</form>	
<?php
	} }
?>
</div>		
<?php } ?>