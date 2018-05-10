<?php 
  $args= array('post_type'=>'hrmgt_events','orderby'=>'post_title');
 $cat_result = get_posts( $args );
 $cal_array = array();
  $obj_holidy=new HrmgtHoliday();
 foreach($cat_result as $key=>$value){
	$post_id = $value->ID;
	$title = get_the_title($value->ID);
	$start_date = get_post_meta($post_id,'event_start_date',true);
	$end_date = get_post_meta($post_id,'event_end_date',true);
	$cal_array[] = array(	
		'title'=>$title,
		'start' =>mysql2date('Y-m-d',$start_date ) ,
		//'end' => mysql2date('Y-m-d', $end_date),
		'end' => date('Y-m-d', strtotime($end_date. ' + 1 days')),
		'background'=>'#1DB198',		
	);
 }
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#calendar').fullCalendar( {
			 header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
			editable: false	,						
			events:<?php echo json_encode($cal_array);?>		
		 } );
	});
</script>
<style>
.fc-content{
	text-align:center;
}
a:hover{
	text-decoration:none;
}
</style>
<div class="popup-bg">
    <div class="overlay-content">
		<div class="category_list"></div>    
    </div> 
</div>
<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3>
		<img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" />
		<?php echo get_option( 'hrmgt_system_name' );?></h3>
	</div>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
			<a href="<?php echo admin_url().'admin.php?page=hrmgt-user&tab=employee_list';?>">
				<div class="panel info-box panel-white">
					<div class="panel-body member">
				<img src="<?php echo HRMS_PLUGIN_URL."/assets/images/dashboard/employee.png"?>" class="dashboard_background">
						<div class="info-box-stats">
							<p class="counter"><?php echo sprintf("%02d", count(get_users(array('role'=>'employee'))));?></p>							
							<span class="info-box-title"><?php echo esc_html( __( 'Employee', 'hr_mgt' ) );?></span>
						</div>						
					</div>
				</div>
			</a>
		</div>
			
		<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
			<a href="<?php echo admin_url().'admin.php?page=hrmgt-department';?>">
				<div class="panel info-box panel-white">
					<div class="panel-body staff-member">
					<img src="<?php echo HRMS_PLUGIN_URL."/assets/images/dashboard/department.png"?>" class="dashboard_background">
						<div class="info-box-stats">
							<p class="counter"><?php $counter=get_count('hrmgt_department'); echo sprintf("%02d",$counter);?></p>
							<span class="info-box-title"><?php echo esc_html( __( 'Department', 'hr_mgt' ) );?></span>
						</div>                        
					</div>
				</div>
				</a>
		</div>
			<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
			<a href="<?php echo admin_url().'admin.php?page=hrmgt-general_settings&tab=holiday_list';?>">
				<div class="panel info-box panel-white">
					<div class="panel-body group">
					<img src="<?php echo HRMS_PLUGIN_URL."/assets/images/dashboard/holidays.png"?>" class="dashboard_background">
						<div class="info-box-stats">
							<p class="counter"><?php $counter=get_count('hrmgt_holiday'); echo sprintf("%02d",$counter);?></p>							
							<span class="info-box-title"><?php echo esc_html( __( 'Holidays', 'hr_mgt' ) );?></span>
						</div>					
					</div>
				</div>
				</a>
			</div>
			<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
				<a href="<?php echo admin_url().'admin.php?page=hrmgt-message';?>">
					<div class="panel info-box panel-white">
						<div class="panel-body message">
						<img src="<?php echo HRMS_PLUGIN_URL."/assets/images/dashboard/message.png"?>" class="dashboard_background_message">
							<div class="info-box-stats">
								<p class="counter"><?php $counter = count(hrmgt_count_inbox_item(get_current_user_id())); echo sprintf("%02d",$counter);?></p>								
								<span class="info-box-title"><?php echo esc_html( __( 'Message', 'hr_mgt' ) );?></span>
							</div>					
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4 membership-list">
				
			<div class="panel panel-white">
				<div class="panel-heading">
					<h3 class="panel-title"><?php _e('Birthdays','hr_mgt');?></h3>					
				</div>
				<div class="panel-body">
					<table class="table">
						<thead>
							<tr>
								<th><b><?php _e('Employee Name','hr_mgt');?></b></th>
							</tr>
						</thead>
						<tbody>									
							<?php 
							$birthday_emp =  get_employee_birthday(date('m'));
							if(!empty($birthday_emp))
							{									
								foreach($birthday_emp as $employee)
								{
									if(get_user_meta($employee->ID,'working_status',true)=="Working")
									{
										if($employee->hrmgt_user_avatar)
										{
											$profile = $employee->hrmgt_user_avatar;
										}
										else
										{
											$profile = get_option('hrmgt_system_logo');
										}
										?>
								<tr>
									<td><span class="bathday-profile"><img height="30px" width="30px" src="<?php print $profile ?>" /></span><?php print hrmgt_get_display_name($employee->ID) ?></td>
									<td style="vertical-align:middle"><?php print hrmgt_change_dateformat($employee->birth_date) ?></td>
								</tr>								
							<?php } } } 
							else
							{ ?>
								<tr>
									<td><?php  _e('None','hr_mgt'); ?></td>									
								</tr>									
							<?php } ?>
						</tbody>
					</table>						
					</div>
			</div>				
			<div class="panel panel-white">
				<div class="panel-heading">
					<h3 class="panel-title"><a href="<?php print admin_url().'admin.php?page=hrmgt-general_settings&tab=holiday_list' ?>"><?php _e('Holiday List','hr_mgt');?></a></h3>						
				</div>					
				<div class="panel-body">
					<table class="table">						
					<?php 
						$holidaydata = $obj_holidy->get_current_month_holidy(date('m'),date('Y'));
						if(!empty($holidaydata))
						{
							foreach($holidaydata as $holiday)
							{ ?>
							<tr class=" view-holiday" id="<?php print $holiday->id ?>" style="background:#FCF8E3">
								<td class="cursor view-holiday" ><?php _e($holiday->holiday_title,'hr_mgt') ?></td>
								<td class="cursor  text-right">
									<?php 
										$start_date = $holiday->start_date;
										$end_date = $holiday->end_date;
										if($start_date == $end_date)
										{
											echo date(get_option('date_format'),strtotime($start_date));
										}
										else
										{
											echo date(get_option('date_format'),strtotime($start_date)) ."<br>To<br> ".date(get_option('date_format'),strtotime($end_date));
										}
									?>
								</td>
							</tr>	
						<?php 	}
						}
						 else
						{
							_e('No Holiday','hr_mgt');
						}	?>										
					</table>					
				</div>
			</div>
				
			<div class="panel panel-white">
				<div class="panel-heading">
					<h3 class="panel-title"><a href="<?php print admin_url().'admin.php?page=hrmgt-event' ?>"><?php _e('Event List','hr_mgt');?></a></h3>						
				</div>					
				<div class="panel-body">
					<table class="table">						
					<?php 
						$EventData = get_current_month_event(date('m'),date('Y'));				
						
						
						if(!empty($EventData))
						{
							foreach($EventData as $event)
							{ 
								$ed1 = strtotime(get_post_meta($event->ID,'event_start_date',true));
								$ed2 = strtotime(get_post_meta($event->ID,'event_end_date',true));
								if($ed1==$ed2)
								{
									$EventDate = hrmgt_change_dateformat(get_post_meta($event->ID,'event_start_date',true));
								}
								else
								{
									$EventDate = hrmgt_change_dateformat(get_post_meta($event->ID,'event_start_date',true)) .' <br>To<br>'.hrmgt_change_dateformat(get_post_meta($event->ID,'event_end_date',true));
								}			
							
							?>
							<tr class="" style="background:#FCF8E3;">
								<td class="cursor view-event" id="<?php print $event->ID;?>" ><?php _e($event->post_title,'hr_mgt') ?></td>
								<td class="cursor view-event text-right" id="<?php print $event->ID;?>" ><?php print $EventDate ?></td>
							</tr>	
						<?php }
						} 
						else
						{
							 _e('No Event','hr_mgt');
						}
						?>										
					</table>					
				</div>
			</div>
			<div class="panel panel-white">
				<div class="panel-heading">
					<h3 class="panel-title"><a href="<?php print admin_url().'/admin.php?page=hrmgt-notice'?>"><?php _e('Notice List','hr_mgt');?></a></h3>	
				</div>					
				<div class="panel-body">
					<table class="table">						
					<?php 
						$NoticeData = get_admin_current_month_notice(date('m'),date('Y'));
						if(!empty($NoticeData))
						{
							foreach($NoticeData as $key=>$notice)
							{	
								$nd1 = strtotime(get_post_meta($notice->ID,'start_date',true));
								$nd2 = strtotime(get_post_meta($notice->ID,'end_date',true));
								if($nd1==$nd2)
								{
									$NoticeDate = hrmgt_change_dateformat(get_post_meta($notice->ID,'start_date',true));
								}
								else
								{
									$NoticeDate = hrmgt_change_dateformat(get_post_meta($notice->ID,'start_date',true)).' <br>To<br> '.hrmgt_change_dateformat(get_post_meta($notice->ID,'end_date',true));
								}
							?>
							<tr class="" style="background:#FCF8E3; color:grey">
								<td class="cursor view-notice" id="<?php print $notice->ID ?>" ><?php print $notice->post_title ?></td>
								<td class="cursor view-notice text-right" id="<?php print $notice->ID ?>" ><?php print $NoticeDate ?></td>
							</tr>	
						<?php }
						}
						else
						{
							_e('No Notice','hr_mgt');
						}
						 ?>										
					</table>					
				</div>
			</div>				
		</div>
		<div class="col-md-8">
			<div class="panel panel-white">
				<div class="panel-body">
					<div id="calendar"></div><br>
					<mark style="height:5px;width:10px; background:rgb(34,186,160)">&nbsp;&nbsp;&nbsp;</mark><span> &nbsp; <?php _e('Event','hr_mgt') ?><span>					
				</div>				
			</div>			
		</div>
	</div>		
	</div>
</div>