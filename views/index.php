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
			<img src="<?php echo $settings['ootp.asset_url'].'images/'.str_replace(".","_50.",$team_details->logo_file); ?>" width="50" height="50" border="0" alt="<?php echo $team_details->name." ".$team_details->nickname; ?>" title="<?php echo $team_details->name." ".$team_details->nickname; ?>" />
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
		<?php if (isset($records) && is_array($records) && count($records)) :  ?>
    <br clear="all" />
    <!--div class="span12"><?php //echo("Batting SQL  = <br />".$batting_query."<br/ >"); ?></div>
    <div class="span12"><?php //echo("Pitching SQL  = <br />".$pitching_query."<br/ >"); ?></div-->
	<div class="span12">
	<?php
	$types = array('Batting','Pitching');
	foreach ($types as $type) :
		if (isset($records[$type]) && is_array($records[$type]) && count($records[$type])) :
		echo ('<h3>'.$league_year." ".$type.' Stats</h3>');
        ?>
		<table class="table table-striped table-bordered">
		<thead>
		<tr>
			<?php 
			foreach ($headers[$type] as $header) :
				echo (' <th>'.lang($header."acyn").'</th> '."\n");
			endforeach;
			?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($records[$type] as $player) : ?>
		<?php $player = (array)$player;?>
		<tr>
			<?php foreach($player as $field => $value) : ?>
				<?php if ($field != 'id' && $field != 'role') :
				/*switch ($field) :
					case 'position':
						if ($value==1) $value = $player['role'];
						$value = get_pos($value);
						break;
					case 'throws':
					case 'bats':
						$value = get_hand($value);
						break;
					case 'avg':
						$value = sprintf("%.3f",$value);
						break;
				   case 'era':
						$value = sprintf("%.2f",$value);
						break;
				   case 'ip':
						$value = sprintf("%.1f",$value);
						break;
					default:
						break;
				endswitch;*/
				?>
				<td><?php echo $value; ?></td>
				<?php endif; ?>
			<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
		<?php 
		endif;
	endforeach;  ?>
    </div>
<?php
endif; ?>
	</div>
</div>