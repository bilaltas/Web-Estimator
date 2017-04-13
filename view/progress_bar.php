<!-- Progress Bar ================================================== -->

<h1 id="big-title"><?= $this->stepTitle() ?></h1>

<div class="progress" style="margin-bottom: 40px;">

	<?php

	foreach ($this->steps as $stepNo => $step) {

		// Color the bars
		if ( $this->stepStatus($step['step_slug']) == "current" )
			$stepStatus = $step['step_slug'] == "results" ? "progress-bar-danger" : "";
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

	?>

</div>

<!-- Progress Bar End ================================================== -->


