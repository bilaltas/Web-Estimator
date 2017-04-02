<!-- Steps ================================================== -->

<h1 id="big-title"><?= $this->stepTitle() ?></h1>

<div class="progress" style="margin-bottom: 40px;">


<?php

$count = 1;
$stepStatus = "";
foreach($this->steps[$this->selectedMainChoice()] as $stepCats) {
	foreach ($stepCats as $stepCatID => $stepCat) {

		// Color the bars
		if ( $this->stepStatus($stepCatID) == "current" )
			$stepStatus = "";
		elseif ( $this->stepStatus($stepCatID) == "skipped" )
			$stepStatus = "progress-bar-warning";
		elseif ( $this->stepStatus($stepCatID) == "done" )
			$stepStatus = "progress-bar-success";
		elseif ( $this->stepStatus($stepCatID) == "notyet" )
			$stepStatus = "progress-bar-info";

		// Print
		echo '<div class="progress-bar '.$stepStatus.'">
				<a href="'.$this->stepLink($stepCatID).'" title="'.$stepCat.'" data-toggle="tooltip" data-placement="bottom">Step '.$count.'</a>
			</div>';

		$count++;

	}
}

?>


	<!--<div class="progress-bar progress-bar-info" style="width: 10%;" title="Default tooltip" data-toggle="tooltip" data-placement="bottom">Step 10</div>

	<div class="progress-bar progress-bar-warning" style="width: 10%;"></div>
	<div class="progress-bar progress-bar-danger" style="width: 10%;"></div>
	<div class="progress-bar progress-bar-success" style="width: 10%;"></div>
	<div class="progress-bar progress-bar-info" style="width: 10%;"></div> -->
</div>