<h1 class="page-header">Stats Generalization Test</h1>
			
<div class="container-fluid">
	<div class="row-fluid rowbg content">
    <div><?php echo("AB Stat descript = ".lang("AB")."<br/ >"); ?></div>
    <div><?php echo("AVG formula = ".implode(",",$stats_list['offense']['HR'])."<br/ >"); ?></div>
    <div><?php echo("Batting SQL  = <br />".$batting_query."<br/ >"); ?></div>
    <div><?php echo("Pitching SQL  = <br />".$pitching_query."<br/ >"); ?></div>
	</div>
</div>