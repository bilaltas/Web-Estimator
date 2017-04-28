<!-- Step Content ================================================== -->

<div class="row">
	<div class="col-xs-12">

<?php
if ( $this->stepSlug("concept") ) {
?>

		<div class="btn-group" style="width: 100%;">


			<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" style="width: 100%;">
			<?= !isset($_GET['concept']) ? "Chose the type of website you want us to build:" : "Selected: ". $this->mainChoiceTitle($_GET['concept']) ?><span class="caret"></span>
			</button>

			<ul role="menu" class="dropdown-menu" style="width: 100%;">
<?php

	$main_choices_cat_query = $this->dbQuery("SELECT * FROM main_choices WHERE main_choice_parent_ID = 0");
	while ($main_choice_cat = $main_choices_cat_query->fetch()) {

		// Choice Category
		echo '<li class="dropdown-header" role="presentation">'.$main_choice_cat['main_choice_name'].'</li>';

		$main_choice_query = $this->dbQuery("SELECT * FROM main_choices WHERE main_choice_parent_ID = ".$main_choice_cat['main_choice_ID'] );
		while ($main_choice = $main_choice_query->fetch()) {

			$isDisabled = $main_choice['main_choice_active'] ? false : true;

			echo '
			<li'.($isDisabled ? " class='disabled'" : "").'>
				<a href="'.( $isDisabled ? "#" : $this->submitLink($main_choice['main_choice_slug'], $this->nextStepSlug()) ).'" '.($isDisabled ? 'title="Coming Soon" data-toggle="tooltip" data-placement="left"' : "").'>'.$main_choice['main_choice_name'].'</a>
			</li>';

		}

		echo '<li class="divider" role="presentation"></li>';

	}

?>
			</ul>

		</div><!-- /btn-group -->


<?php
} elseif ( $this->stepSlug("results") ) { // RESULTS PAGE ============================================

	// IF ADMIN?
	$showTimes = $this->isAdmin() ? true : false;


	// STEPS QUERY
	$results = array();
	foreach ($this->steps as $stepNo => $step) {

		// FIELDS QUERY
		$fields_query = $this->dbQuery("SELECT * FROM fields WHERE step_ID = ".$this->stepID($step['step_slug']));
		while ($field = $fields_query->fetch()) {

			// INPUTS QUERY
			$inputs_query = $this->dbQuery("SELECT * FROM inputs WHERE field_ID = ".$field['field_ID']);
			while ($input = $inputs_query->fetch()) {

				$results[ $step['step_slug'] ][ $field['field_slug'] ][ $input['input_slug'] ]['result'] = $this->inputValues($input['input_slug'], $step['step_slug']);

			}

		}

	}


	// Big Title
	echo "<h2>Review Your Choices & Total</h2>";


	// Concept Step
	$editNote = ' <span class="fui-new"></span>';
	echo '<h3 class="result-steps"><a href="'.$this->stepLink('concept').'">1. '.$this->stepTitle('concept').$editNote.'</a></h3>';
	echo 'Website Concept: <b>'.$this->mainChoiceTitle( $this->mainChoice() ).'</b>';


	// Count total minutes
	$totalMinutes = 0;

	// 1. List the steps
	foreach ($results as $stepSlug => $fields) {

		// Show the step number and title
		echo '<h3 class="result-steps"><a href="'.$this->stepLink($stepSlug).'">'.$this->stepNo($stepSlug).'. '.$this->stepTitle($stepSlug).$editNote.'</a></h3>';


		// 2. List the fields in it
		foreach ($fields as $fieldSlug => $inputs) {


			// 3. List the inputs
			foreach ($inputs as $inputSlug => $inputValues) {


				// 4. List the results entered
				if ( is_array($inputValues['result']) ) {

					// Field Title
					echo $this->fieldShortName($fieldSlug).": ";

					echo "<b>";
					foreach ($inputValues['result'] as $inputValue) {

						echo $this->inputShortName($inputSlug, $inputValue);

						// Individual Hours
						if ($showTimes) echo " (".$this->beautifyMinutes( $this->inputTime($inputSlug, $inputValue) ).")";

						// Separators
						if ($inputValue != end($inputValues['result']))
							echo ", ";
						else
							echo "<br/>";

						// Count minutes
						$totalMinutes += $this->inputTime($inputSlug, $inputValue);

					}
					echo "</b>";

				} elseif ( is_numeric($inputValues['result']) ) {

					// Input Title
					echo $this->inputShortName($inputSlug).": ";
					echo "<b>".$this->inputShortName($inputSlug, $inputValues['result']);

					// Individual Hours
					if ($showTimes) echo " (".$this->beautifyMinutes( $this->inputTime($inputSlug, $inputValues['result']) ).")";

					// Separator
					echo "</b><br/>";

					// Count minutes
					$totalMinutes += $this->inputTime($inputSlug, $inputValues['result']);

				} elseif ( $inputValues['result'] != "" ) {

					// Field Title
					echo $this->fieldShortName($fieldSlug).": ";
					echo "<b>".$this->inputShortName($inputSlug, $inputValues['result']);

					// Individual Hours
					if ($showTimes) echo " (".$this->beautifyMinutes( $this->inputTime($inputSlug, $inputValues['result']) ).")";

					// Separator
					echo "</b><br/>";

					// Count minutes
					$totalMinutes += $this->inputTime($inputSlug, $inputValues['result']);

				} else {

					// Title
					if ($this->inputShortName($inputSlug))
						echo $this->inputShortName($inputSlug).": "; // Input Title
					else
						echo $this->fieldShortName($fieldSlug).": "; // Field Title

					// Separator
					echo "<b>-</b><br/>";

				}

			}


		}


	}


	echo "<br/><br/><br/><h1 style='text-align: center;'>TOTAL</h1><h2 class='results'>";


	echo "<b>".$this->beautifyMinutes( $totalMinutes )."</b> of work";

	if ( $this->isAdmin() )
		echo " (".$totalMinutes."m)";


	if ( $this->isLoggedIn() && $this->userInfo('hourly_rate_currency') != "" )
		$userID = "";
	else
		$userID = 1;


	if ( $this->userInfo('daily_work_hours', $userID) != "" )
		echo "<br/>Project will take <b>".(ceil(round( ($totalMinutes/60)/$this->userInfo('daily_work_hours', $userID), PHP_ROUND_HALF_UP)) + 1)." working days</b> to complete";


	echo "<br/>Your project rate is <b>".sprintf($this->userInfo('hourly_rate_currency', $userID), ($totalMinutes/60)*$this->userInfo('hourly_rate', $userID))."</b>";


	if ( $this->isAdmin() )
		echo " (".sprintf($this->userInfo('hourly_rate_currency', $userID), $this->userInfo('hourly_rate', $userID))."/h)";


	if ( $this->userInfo('discount_description', $userID) != "" )
		echo "<br/><span class='discount-description'>".$this->userInfo('discount_description', $userID)."</span>";

	echo "</h2><br/>";
?>

<div class="share-results">

	<h4>Share this project!</h4>

	<!-- Twitter (url, text, @mention) -->
	<a href="http://twitter.com/share?url=<?=urlencode( $this->currentPageURL() )?>&text=<?=urlencode("My Project's Deadline:")?>&via=bilaltas" target="_blank">
	    <span class="fui-twitter"></span>
	</a>

	<!-- Google Plus (url) -->
	<a href="https://plus.google.com/share?url=<?=urlencode( $this->currentPageURL() )?>" target="_blank">
	    <span class="fui-google-plus"></span>
	</a>

	<!-- Facebook (url) -->
	<a href="http://www.facebook.com/sharer/sharer.php?u=<?=urlencode( $this->currentPageURL() )?>" target="_blank">
	    <span class="fui-facebook"></span>
	</a>

	<!-- StumbleUpon (url, title) -->
	<a href="http://www.stumbleupon.com/submit?url=<?=urlencode( $this->currentPageURL() )?>&title=<?=urlencode("My Project's Deadline")?>" target="_blank">
	    <span class="fui-stumbleupon"></span>
	</a>

	<!-- LinkedIn (url, title, summary, source url) -->
	<a href="http://www.linkedin.com/shareArticle?url=<?=urlencode( $this->currentPageURL() )?>&title=<?=urlencode("My Project's Deadline")?>&summary=<?=urlencode("You can find it here!")?>&source=<?=$this->currentPageURL()?>" target="_blank">
	    <span class="fui-linkedin"></span>
	</a>

	<!-- Email (subject, body) -->
	<a href="mailto:?subject=My Project's Deadline&body=<?=urlencode( $this->currentPageURL() )?>">
	    <span class="fui-mail"></span>
	</a>

</div>
<?php

	// ALL ANSWERS FOR DEBUGGING
	//echo "<pre>".print_r($results, true)."</pre>";
/*
	foreach ($_GET as $question => $answer) {
		echo $question." => ".$answer."<br/><br/>";
	}
*/



} else { // SHOW THE QUESTIONS ====================================================================================================
?>

	<form role="form">
	<?php
	// BRING THE PREVIOUS DATA
	$this->bringData();
	?>

<?php
	// 1. Bring the fields belong to this step
	$temp_data = array('action', 'action-finish');
	$inputNo = 0;
	$fields_query = $this->dbQuery("SELECT * FROM fields WHERE step_ID = ".$this->stepID());
	while ($field = $fields_query->fetch()) {
?>

		<div class="field">
			<h3>
				<?php
				echo $field['field_name'];
				if (!$field['field_required']) echo '<br/><span style="color: #ECF0F1;">(Optional)</span>';
				?>
			</h3>

			<div class="form-group">

			<?php

			// 2. Bring the inputs belong to that field above
			$inputs_query = $this->dbQuery("SELECT * FROM inputs WHERE field_ID = ".$field['field_ID']);
			while ($input = $inputs_query->fetch()) {

				// Collect the temp data
				$temp_data[] = "t_".$input['input_slug'];



				// INPUT TYPES
				if ($input['input_type'] == "radio") { // RADIO =========

					// Check if chosen
					$checked = $this->inputValues($input['input_slug']) == $input['input_value'] ? 'checked' : '';
			?>
					<label class="radio primary">
					    <input
	                		type="<?=$input['input_type']?>"
					    	data-toggle="radio"
					    	name="t_<?=$input['input_slug']?>"
					    	value="<?=$input['input_value']?>"
					    	id="<?=$input['input_ID']?>"
					    	<?=$checked?>
					    	<?=$input['input_required'] ? 'required' : ''?>
					    >
					    <?=$input['input_name']?>
						<?=$input['input_description'] != "" ? '<a title="'.$input['input_description'].'" data-toggle="tooltip" data-placement="top"><span class="fui-question-circle"></span></a>' : '' ?>
						<?=$this->inputAdmin($input['input_ID'])?>
					</label>

				<?php
					// Don't increase because it's only one choice
					//$inputNo++;



				} elseif ($input['input_type'] == "checkbox") { // CHECKBOX =========



					// Collect the temp data
					$temp_data[] = "t_".$input['input_value'];

					// Send the disabled ones
					if ($input['input_disabled']) {
						if ($input['input_required']) echo '<input type="hidden" name="t_'.$input['input_value'].'" value="'.$input['input_slug'].'">';
						$inputNo--;
					}


					// Check if chosen
					if ( is_array($this->inputValues($input['input_slug'])) )
						$checked = $this->inputValues($input['input_slug']) && in_array($input['input_value'], $this->inputValues($input['input_slug'])) ? 'checked' : '';
					else
						$checked = $this->inputValues($input['input_value']) == $input['input_slug'] ? 'checked' : '';

				?>

					<label class="checkbox">
	                	<input
	                		type="<?=$input['input_type']?>"
	                		data-toggle="checkbox"
					    	name="t_<?=$input['input_value']?>"
					    	value="<?=$input['input_slug']?>"
					    	id="<?=$input['input_ID']?>"
					    	<?=$checked?>
					    	<?=$input['input_disabled'] ? 'disabled '.($input['input_required'] ? 'checked' : '') : ''?>
	                	>
						<?=$input['input_name']?>
						<?=$input['input_description'] != "" ? '<a title="'.$input['input_description'].'" data-toggle="tooltip" data-placement="top"><span class="fui-question-circle"></span></a>' : '' ?>
						<?=$this->inputAdmin($input['input_ID'])?>
					</label>


				<?php

					$inputNo++;

				} elseif ($input['input_type'] == "number") { // NUMBER =========

				?>

					<label>
						<?=$input['input_name']?>
	                	<input
	                		class="form-control input-hg"
	                		style="width: 100px;"
	                		type="<?=$input['input_type']?>"
					    	name="t_<?=$input['input_slug']?>"
					    	value="<?=$this->inputValues($input['input_slug']) ? $this->inputValues($input['input_slug']) : $input['input_value']?>"
					    	min="0"
					    	id="<?=$input['input_ID']?>"
					    	<?=$input['input_disabled'] ? 'disabled' : ''?>
					    	<?=$input['input_required'] ? 'required' : ''?>
	                	>
						<?=$input['input_description']?>
						<?=$this->inputAdmin($input['input_ID'])?>
					</label>


				<?php

					$inputNo++;

				} elseif ($input['input_type'] == "number-checktoshow") { // CHECK TO SHOW NUMBER =========
				?>

					<label class="checkbox checktoshow">
						<input type="checkbox" data-toggle="checkbox" <?=$this->inputValues($input['input_slug']) ? 'checked' : ''?>>
						<?=$input['input_checkbox_name']?>
					</label>

					<label style="<?=$this->inputValues($input['input_slug']) ? '' : 'display: none;'?>">
						<?=$input['input_name']?>
	                	<input
	                		class="form-control input-hg"
	                		style="width: 100px;"
	                		type="number"
					    	name="t_<?=$input['input_slug']?>"
					    	value="<?=$this->inputValues($input['input_slug']) ? $this->inputValues($input['input_slug']) : $input['input_value']?>"
					    	min="0"
					    	id="<?=$input['input_ID']?>"
					    	<?=$this->inputValues($input['input_slug']) ? '' : 'disabled'?>
	                	>
						<?=$input['input_description']?>
						<?=$this->inputAdmin($input['input_ID'])?>
					</label>


				<?php

					$inputNo++;

				}
				?>



			<?php
			} // Input Loop
			?>


			</div> <!-- div.form-group -->

		</div> <!-- div.field -->

<?php
	$inputNo++;

	} // Field Loop
?>

		<?php

			// BUTTONS
			if ( !$this->isLastStep($this->stepSlug()) )
				echo '<button type="submit" name="action" class="btn btn-sm btn-primary">Continue</button> ';

			if ( $this->stepStatus('results') == "skipped" || $this->isLastStep($this->stepSlug()) )
				echo '<button type="submit" name="action-finish" class="btn btn-sm btn-success">Save and Finish</button>';

		?>

	</form>

<?php

	// Temporary Data sent?
	if ( isset($_GET['action']) || isset($_GET['action-finish']) ) {

		$finish = isset($_GET['action-finish']);

		// Prepare the data
		$data_to_send = "";
		foreach ($_GET as $key => $value) {

			$correctKey = substr($key, 2);

			if ( in_array($key, $temp_data) && $value != "" ) {

				if ($correctKey != $this->stepSlug())
					$data_to_send .= $correctKey;

				if ($correctKey != $this->stepSlug() && $value != $this->stepSlug())
					$data_to_send .= "-";

				if ($value != $this->stepSlug())
					$data_to_send .= $value;
				$data_to_send .= "--";

			}

			if (end($_GET) == $value) $data_to_send = substr($data_to_send, 0, -2);

		}

		// If nothing entered
		if ($data_to_send == "") $data_to_send = "na";

		// Go to the next step
		header('Location: '.$this->submitLink( $data_to_send, $finish ? 'results' : $this->nextStepSlug(), $temp_data ) );
		die();

	}




} // Main Choice Page Check
?>


	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->

<!-- Step Content End ================================================== -->


