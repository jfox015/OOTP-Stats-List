<div>
	<h1 class="page-header"><?php echo lang('statslist_view_header'); ?></h1>
	<p><?php echo lang('statslist_view_notes'); ?></p>
</div>
<div style="float:right;width:55%;text-align:right;">
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

<div style="float:left; width:44%;">
<?php if (isset($team_details)) : ?>
	<div style="float:left; width:55px; margin-right:10px;">
	<img src="<?php echo $settings['ootp.asset_url'].'images/'.str_replace(".","_50.",$team_details->logo_file); ?>" width="50" height="50" border="0" alt="<?php echo $team_details->name." ".$team_details->nickname; ?>" title="<?php echo $team_details->name." ".$team_details->nickname; ?>" />
	</div>
	<div style="float:left; width:65%;">
	<h2><?php echo ($team_details->name." ".$team_details->nickname); ?></h2>
	</div>
    <br style="clear: both;" />
<?php 
endif;
?>
</div>
	
<?php if (isset($records) && is_array($records) && count($records)) :  ?>
    <br clear="all" />
	<div>
    <?php
	$types = array('Batting','Pitching');
	foreach ($types as $type) :
		if (isset($records[$type]) && is_array($records[$type]) && count($records[$type])) :
		echo ('<h3>'.$league_year." ".$type.' Stats</h3>');
        ?>
		<table class="table table-striped table-bordered">
		<thead>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>POS</th>
			<th>Age</th>
			<th>T</th>
			<th>B</th>
			<?php if ($type == 'Batting') : ?>
			<th>AVG</th>
			<th>G</th>
			<th>AB</th>
			<th>R</th>
			<th>H</th>
			<th>HR</th>
			<th>RBI</th>
			<th>BB</th>
			<th>K</th>
			<th>SB</th>
			<th>CS</th>
			<?php else: ?>
			<th>W</th>
			<th>L</th>
			<th>ERA</th>
			<th>G</th>
			<th>GS</th>
			<th>IP</th>
			<th>BB</th>
			<th>K</th>
			<th>HRA</th>
			<th>SV</th>
			<?php
			endif; ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($records[$type] as $player) : ?>
		<?php $player = (array)$player;?>
		<tr>
			<?php foreach($player as $field => $value) : ?>
				<?php if ($field != 'id' && $field != 'role') :
				switch ($field) :
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
				endswitch;
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