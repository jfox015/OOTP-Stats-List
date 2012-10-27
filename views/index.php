<h1 class="page-header"><?php echo lang('statslist_view_header'); ?></h1>
			
<div class="container-fluid">
	<div class="row-fluid rowbg content">
		<div class="span12">
			<p><?php echo lang('statslist_view_notes'); ?></p>
		</div>
	</div>
	<div class="row-fluid rowbg content">
		<div class="span6">
		<?php if (isset($team_details)) : ?>
			<div class="span2">
			<img src="<?php echo $settings['osp.team_logo_url'].str_replace(".","_50.",$team_details->logo_file); ?>" width="50" height="50" border="0" alt="<?php echo $team_details->name." ".$team_details->nickname; ?>" title="<?php echo $team_details->name." ".$team_details->nickname; ?>" />
			</div>
			<div class="span10">
			<h2><?php echo ($team_details->name." ".$team_details->nickname); ?></h2>
			</div>
		<?php 
		endif;
		?>
		</div>

		<div class="span6" style="text-align:right;">
		<?php
		echo form_open($this->uri->uri_string(), ' method="post" class="form-horizontal"');
		if (isset($years) && sizeof($years) > 0)
		{
			echo form_label("Select Season:", "year", array('style'=>'display: inline-block !important;'))."\n";
			echo '<select name="year" id="year" style="width:auto;">'."\n";
			foreach ($years as $year) 
			{
				echo '<option value="'.$year.'"';
				if (isset($league_year) && $year == $league_year) { echo " selected"; }
				echo '>'.$year.'</option>'."\n";
			}
			echo '</select>'."\n";
		}
		if (isset($teams) && sizeof($teams) > 0) 
		{
			echo form_label("Select Team:", "team_id", array('style'=>'display: inline-block !important;'));
			echo '<select id="team_id" name="team_id" style="width:auto;">'."\n";
			foreach($teams as $team) 
			{
				echo "\t".'<option value="'.$team['team_id'].'"';
				if (isset($team_id) && $team['team_id'] == $team_id) { echo " selected"; }
				echo '>'.str_replace(".","",$team['name']." ".$team['nickname']).'</option>'."\n";
			}
			echo '</select>'."\n";
			echo form_submit("submit","Go",' id="submitBtn"');
		}
		echo form_close()."\n"; 
		?>
		</div>
	</div>
	<div class="row-fluid rowbg content">
		<div class="span12">
		<!-- BATTING -->
		<?php
		if (isset($batting)) :
			echo($batting);
		endif;
		?>
		<!-- PITCHING -->
		<?php
		if (isset($pitching)) :
			echo($pitching);
		endif;
		?>
		</div>
    </div>
</div>