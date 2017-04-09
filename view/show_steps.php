<!-- Steps ================================================== -->

<h1 id="big-title"><?= $this->stepTitle() ?></h1>

<?php
	//print_r( $this->steps );
?>

<div class="progress" style="margin-bottom: 40px;">


<?php

foreach ($this->steps as $stepNo => $step) {

	// Color the bars
	if ( $this->stepStatus($step['step_slug']) == "current" )
		$stepStatus = "";
	elseif ( $this->stepStatus($step['step_slug']) == "skipped" )
		$stepStatus = "progress-bar-warning";
	elseif ( $this->stepStatus($step['step_slug']) == "done" )
		$stepStatus = "progress-bar-success";
	elseif ( $this->stepStatus($step['step_slug']) == "notyet" )
		$stepStatus = "progress-bar-info";
	else
		$stepStatus = "";



	echo '<div class="progress-bar '.$stepStatus.'">
			<a href="'.$this->stepLink($step['step_slug']).'" title="'.$step['step_name'].'" data-toggle="tooltip" data-placement="bottom">Step '.$stepNo.'</a>
		</div>';


}

	echo '<div class="progress-bar progress-bar-info">
			<a href="#finish_link" title="Results" data-toggle="tooltip" data-placement="bottom">Step '.++$stepNo.'</a>
		</div>';

?>


	<!--<div class="progress-bar progress-bar-info" style="width: 10%;" title="Default tooltip" data-toggle="tooltip" data-placement="bottom">Step 10</div>

	<div class="progress-bar progress-bar-warning" style="width: 10%;"></div>
	<div class="progress-bar progress-bar-danger" style="width: 10%;"></div>
	<div class="progress-bar progress-bar-success" style="width: 10%;"></div>
	<div class="progress-bar progress-bar-info" style="width: 10%;"></div> -->
</div>