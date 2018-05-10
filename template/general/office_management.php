<?php $obj_office=new HrmgtOfficeMgt; ?>
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>
		</div>
    </div> 
</div>
<div id="main-wrapper">
<?php 	
$schedule=get_option( 'hrmgt_time_Schedule');
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.timepicker').timepicker();
	} );
</script>
<div class="panel-body">
	 <?php if($role=="manager"){ ?>
	  <form name="schedule_form" action="" method="post" class="form-horizontal" id="schedule	form">
			<table class="table center" style="width:70%;">
			<thead>
				<tr>
					<th><?php _e("Working Days","hr_mgt")?></th>
					<th colspan="2" class="text-center"><?php _e("Working Hours","hr_mgt")?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php _e('Sunday','hr_mgt')?> </td>
					<td><input type="text" class="form-control timepicker" name="sunday_start" value="<?php echo isset($schedule['sunday']['start'])?$schedule['sunday']['start']:'9:00 AM';?>"></td>
					<td><input type="text" class="form-control timepicker" name="sunday_end"  value="<?php echo isset($schedule['sunday']['end'])?$schedule['sunday']['end']:'6:00 PM';?>"></td>
					<td><input type="checkbox" class="form-control" name="sunday_close" <?php if($schedule['sunday']['close']==1){ echo "checked";}?>  value="1"><?php _e('Check If Close','hr_mgt');?></td>
				</tr>
					<td><?php _e('Monday','hr_mgt')?></td>
					<td><input type="text" class="form-control timepicker" name="monday_start" value="<?php echo isset($schedule['monday']['start'])?$schedule['monday']['start']:'9:00 AM';?>"></td>
					<td><input type="text" class="form-control timepicker" name="monday_end" value="<?php echo isset($schedule['monday']['end'])?$schedule['monday']['end']:'6:00 PM';?>"></td>
					<td><input type="checkbox" class="form-control" name="monday_close" <?php if($schedule['monday']['close']==1){ echo "checked";}?> value="1"><?php _e('Check If Close','hr_mgt');?></td>
					</tr>
					<td><?php _e('Tuesday','hr_mgt')?></td>
					<td><input type="text" class="form-control timepicker" name="tuesday_start" value="<?php echo isset($schedule['tuesday']['start'])?$schedule['tuesday']['start']:'9:00 AM';?>"></td>
					<td><input type="text" class="form-control timepicker" name="tuesday_end" value="<?php echo isset($schedule['tuesday']['end'])?$schedule['tuesday']['end']:'6:00 PM';?>" ></td>
					<td><input type="checkbox" class="form-control" name="tuesday_close" <?php if($schedule['tuesday']['close']==1){ echo "checked";}?> value="1"><?php _e('Check If Close','hr_mgt');?></td>
					</tr>
					<td><?php _e('Wednesday','hr_mgt')?></td>
					<td><input type="text" class="form-control timepicker" name="wednesday_start" value="<?php echo isset($schedule['wednesday']['start'])?$schedule['wednesday']['start']:'9:00 AM';?>"></td>
					<td><input type="text" class="form-control timepicker" name="wednesday_end" value="<?php echo isset($schedule['wednesday']['end'])?$schedule['wednesday']['end']:'6:00 PM';?>"></td>
					<td><input type="checkbox" class="form-control" name="wednesday_close" <?php if($schedule['wednesday']['close']==1){ echo "checked";}?> value="1"><?php _e('Check If Close','hr_mgt');?></td>
					</tr>
					<td><?php _e('Thursday','hr_mgt')?></td>
					<td><input type="text" class="form-control timepicker" name="thursday_start" value="<?php echo isset($schedule['thursday']['start'])?$schedule['thursday']['start']:'9:00 AM';?>"></td>
					<td><input type="text" class="form-control timepicker" name="thursday_end" value="<?php echo isset($schedule['thursday']['end'])?$schedule['thursday']['end']:'6:00 PM';?>"></td>
					<td><input type="checkbox" class="form-control" name="thursday_close" <?php if($schedule['thursday']['close']==1){ echo "checked";}?> value="1"><?php _e('Check If Close','hr_mgt');?></td>
					</tr>
					<td><?php _e('Friday','hr_mgt')?></td>
					<td><input type="text" class="form-control timepicker" name="friday_start" value="<?php echo isset($schedule['friday']['start'])?$schedule['friday']['start']:'9:00 AM';?>"></td>
					<td><input type="text" class="form-control timepicker" name="friday_end" value="<?php echo isset($schedule['friday']['end'])?$schedule['friday']['end']:'6:00 PM';?>"></td>
					<td><input type="checkbox" class="form-control" name="friday_close" <?php if($schedule['friday']['close']==1){ echo "checked";}?> value="1"><?php _e('Check If Close','hr_mgt');?></td>
					</tr>
					<td><?php _e('Saturday','hr_mgt')?></td>
					<td><input type="text" class="form-control timepicker" name="saturday_start" value="<?php echo isset($schedule['saturday']['start'])?$schedule['saturday']['start']:'9:00 AM';?>"></td>
					<td><input type="text" class="form-control timepicker" name="saturday_end" value="<?php echo isset($schedule['saturday']['end'])?$schedule['saturday']['end']:'6:00 PM';?>"></td>
					<td><input type="checkbox" class="form-control" name="saturday_close" <?php if($schedule['saturday']['close']==1){ echo "checked";}?> value="1"><?php _e('Check If Close','hr_mgt');?></td>					
				</tr>
			</tbody>
			</table>
			<div class="col-sm-offset-2 col-sm-8">
        	<input  type="submit" value="<?php _e('Save Time Schedule','hr_mgt');?>" name="save_schedule" class="btn btn-success center"/>
			</div>
			</form>
			<?php } else{  ?> 
			<form name="schedule_form" action="" method="post" class="form-horizontal" id="schedule	form">
			<table class="table" style="width:100%;">
			<thead>
				<tr>
					<th><strong><?php _e("Working Days","hr_mgt")?></strong></th>
					<th colspan="2" class=""><strong><?php _e("Working Hours","hr_mgt")?></strong></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php 	 $today = strtolower( date("D")); ?>
			<?php if($today == "sun"){ ?>
				<tr class="today">
					<th><?php _e('Sunday','hr_mgt')?></th>					
					<?php if($schedule['sunday']['close']==0 ){ ?>
						<td><?php echo $schedule['sunday']['start'];?></td>
						<td><?php echo $schedule['sunday']['end'];?></td>
					<?php } 
						else{ 
							print "<td> Closed </td>";
						}
					?>
				</tr>
				<?php } else{ ?> 
				<tr>
					<th><?php _e('Sunday','hr_mgt')?></th>					
					<?php if($schedule['sunday']['close']==0 ){ ?>
						<td><?php echo $schedule['sunday']['start'];?></td>
						<td><?php echo $schedule['sunday']['end'];?></td>
					<?php } 
						else{ 
							print "<td colspan='2'> Closed </td>";
						}
					?>
				</tr>
				<?php } ?>				
			
				<?php if($today == "mon"){ ?>
					<tr class="today">
						<th><?php _e('Monday','hr_mgt')?></th>
						<?php if($schedule['monday']['close']==0 ){ ?>
							<td><?php echo $schedule['monday']['start'];?></td>
							<td><?php echo $schedule['monday']['end'];?></td>
						<?php } 
							else{ 
								print "<td colspan='2'> Closed </td>";
							}
						?>					
					</tr>
					<?php } else{ ?> 
					<tr>
						<th><?php _e('Monday','hr_mgt')?></th>
						<?php if($schedule['monday']['close']==0 ){ ?>
							<td><?php echo $schedule['monday']['start'];?></td>
							<td><?php echo $schedule['monday']['end'];?></td>
						<?php } 
							else{ 
								print "<td colspan='2'> Closed </td>";
							}
						?>					
					</tr>
					<?php } ?>
					
					
					
					
					<?php if($today == "tue"){ ?>
					<tr class="today">
						<th><?php _e('Tuesday','hr_mgt')?></th>
						<?php if($schedule['tuesday']['close']==0 ){ ?>
						<td><?php echo $schedule['tuesday']['start'];?></td>
						<td><?php echo $schedule['tuesday']['end'];?></td>
						<?php } 
						else{ 
							print "<td colspan='2'> Closed </td>";
						}
						?>
					</tr>
					<?php } else { ?>
					<tr>
						<th><?php _e('Tuesday','hr_mgt')?></th>
						<?php if($schedule['tuesday']['close']==0 ){ ?>
							<td><?php echo $schedule['tuesday']['start'];?></td>
							<td><?php echo $schedule['tuesday']['end'];?></td>
						<?php } 
						else{ 
							print "<td colspan='2'> Closed </td>";
						}
						?>
					</tr>
					<?php } ?>
					
					
					
					<?php if($today == "wed"){ ?>
					<tr class="today">
						<th><?php _e('Wednesday','hr_mgt')?></th>
						<?php if($schedule['wednesday']['close']==0 ){ ?>	
						<td><?php echo $schedule['wednesday']['start'];?></td>
						<td><?php echo $schedule['wednesday']['end'];?></td>
						<?php } 
						else{ 
							print "<td colspan='2'> Closed </td>";
						}
						?>
					</tr>
					<?php } else{ ?>
					<tr>
						<th><?php _e('Wednesday','hr_mgt')?></th>
						<?php if($schedule['wednesday']['close']==0 ){ ?>	
						<td><?php echo $schedule['wednesday']['start'];?></td>
						<td><?php echo $schedule['wednesday']['end'];?></td>
						<?php } 
						else{ 
							print "<td colspan='2'> Closed </td>";
						}
						?>
					</tr>					
					<?php } ?>				
					
					
					<?php if($today == "thu"){ ?>
					<tr class="today">							
						<th><?php _e('Thursday','hr_mgt')?></th>
						<?php if($schedule['thursday']['close']==0 ){ ?>
						<td><?php echo $schedule['thursday']['start'];?></td>
						<td><?php echo $schedule['thursday']['end'];?></td>
						<?php } 
						else{ 
							print "<td colspan='2'> Closed </td>";
						}
						?>
					</tr>
					<?php } else { ?>
					<tr>							
						<th><?php _e('Thursday','hr_mgt')?></th>
						<?php if($schedule['thursday']['close']==0 ){ ?>
						<td><?php echo $schedule['thursday']['start'];?></td>
						<td><?php echo $schedule['thursday']['end'];?></td>
						<?php } 
						else{ 
							print "<td colspan='2'> Closed </td>";
						}
						?>
					</tr>
					<?php } ?>
					
					<?php if($today == "fri"){ ?>
					<tr class="today">
						<th><?php _e('Friday','hr_mgt')?></th>
						<?php if($schedule['friday']['close']==0 ){ ?>
						<td><?php echo $schedule['friday']['start'];?></td>
						<td><?php echo $schedule['friday']['end'];?></td>
						<?php } 
						else{ 
							print "<td colspan='2'> Closed </td>";
						}
						?>
					</tr>
					<?php } else{ ?>
					<tr>
						<th><?php _e('Friday','hr_mgt')?></th>
						<?php if($schedule['friday']['close']==0 ){ ?>
						<td><?php echo $schedule['friday']['start'];?></td>
						<td><?php echo $schedule['friday']['end'];?></td>
						<?php } 
						else{ 
							print "<td colspan='2'> Closed </td>";
						}
						?>
					</tr>
					<?php } ?>
					
					<?php if($today == "sat"){ ?>
					<tr class="today">					
						<th><?php _e('Saturday','hr_mgt')?></th>
						<?php if($schedule['saturday']['close']==0 ){ ?>
						<td><?php echo $schedule['saturday']['start'];?></td>
						<td><?php echo $schedule['saturday']['end'];?></td>
						<?php } 
						else{ 
							print "<td colspan='2'>  Closed </td>";
						}
						?>					
					</tr>
					<?php } else{ ?>
					<tr>					
						<th><?php _e('Saturday','hr_mgt')?></th>
						<?php if($schedule['saturday']['close']==0 ){ ?>
						<td><?php echo $schedule['saturday']['start'];?></td>
						<td><?php echo $schedule['saturday']['end'];?></td>
						<?php } 
						else{ 
							print "<td colspan='2'> Closed </td>";
						}
						?>					
					</tr>						
				<?php } ?> 
			</tbody>
			</table>			
			</form>
	<?php } ?>
</div>