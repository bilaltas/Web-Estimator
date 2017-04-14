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
} elseif ( $this->stepSlug("results") ) {


	foreach ($this->steps as $stepNo => $step) {

		echo '<h3>'.$step['step_name'].'</h3>';

		foreach ($this->inputValues(null, $step['step_slug']) as $question => $answer) {

			if ($question != $step['step_slug']) echo "<h4 style='margin-bottom: -20px; margin-left: 20px;'>".$this->inputName($question)."</h4><br/>";

			echo "<ul>";
			if (is_array($answer)) {
				foreach ($answer as $ans) echo "<li>".$ans." -> ".$this->inputTime($ans)."<li/>"; // Separate times by type!!!
			} else {
				echo "<li>".$answer." -> ".$this->inputTime($question)."<li/>";
			}
			echo "</ul>";
		}

	}


/*
	foreach ($_GET as $question => $answer) {
		echo $question." => ".$answer."<br/><br/>";
	}
*/


} else {
?>

	<form role="form">
	<?php
	// BRING THE PREVIOUS DATA
	$this->bringData();
	?>

<?php
	// 1. Bring the fields belong to this step
	$temp_data = array('action');
	$inputNo = 0;
	$fields_query = $this->dbQuery("SELECT * FROM fields WHERE step_ID = ".$this->stepID());
	while ($field = $fields_query->fetch()) {
?>

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


				if ( $input['input_slug'] == $this->stepSlug() )
					$checked =  $this->inputValues($input['input_slug'])[0] == $input['input_value'] ? 'checked' : '';
				else {
					$checked = $this->inputValues($input['input_slug']) == $input['input_value'] ? 'checked' : '';
				}

		?>
				<label class="radio primary">
				    <input
                		type="<?=$input['input_type']?>"
				    	data-toggle="radio"
				    	name="t_<?=$input['input_slug']?>"
				    	value="<?=$input['input_value']?>"
				    	id="<?=$input['input_slug']?>"
				    	<?=$checked?>
				    	<?=$input['input_required'] ? 'required' : ''?>
				    >
				    <?=$input['input_name']?>
					<?=$input['input_description'] != "" ? '<a title="'.$input['input_description'].'" data-toggle="tooltip" data-placement="top">(?)</a>' : '' ?>
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


				if ( $input['input_slug'] == $this->stepSlug() )
					$checked =  $this->inputValues($input['input_slug']) && in_array($input['input_value'], $this->inputValues($input['input_slug'])) ? 'checked' : '';
				else {
					$checked = $this->inputValues($input['input_value']) == $input['input_slug'] ? 'checked' : '';
				}

			?>

				<label class="checkbox">
                	<input
                		type="<?=$input['input_type']?>"
                		data-toggle="checkbox"
				    	name="t_<?=$input['input_value']?>"
				    	value="<?=$input['input_slug']?>"
				    	id="<?=$input['input_slug']?>"
				    	<?=$checked?>
				    	<?=$input['input_disabled'] ? 'disabled '.($input['input_required'] ? 'checked' : '') : ''?>
                	>
					<?=$input['input_name']?>
					<?=$input['input_description'] != "" ? '<a title="'.$input['input_description'].'" data-toggle="tooltip" data-placement="top">(?)</a>' : '' ?>
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
				    	value="<?=$this->inputValues($input['input_slug']) ? $this->inputValues($input['input_slug'])[0] : $input['input_value']?>"
				    	min="0"
				    	id="<?=$input['input_slug']?>"
				    	<?=$input['input_disabled'] ? 'disabled' : ''?>
				    	<?=$input['input_required'] ? 'required' : ''?>
                	>
					<?=$input['input_description']?>
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
				    	id="<?=$input['input_slug']?>"
				    	<?=$this->inputValues($input['input_slug']) ? '' : 'disabled'?>
                	>
					<?=$input['input_description']?>
				</label>


			<?php

				$inputNo++;

			}
			?>



		<?php
		} // Input Loop
		?>


		</div>

<?php
	$inputNo++;

	} // Field Loop
?>

		<button type="submit" name="action" class="btn btn-sm btn-primary">Continue</button>


	</form>

<?php

	// Temporary Data sent?
	if ( isset($_GET['action']) ) {

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
		header('Location: '.$this->submitLink( $data_to_send, $this->nextStepSlug(), $temp_data ) );
		die();

	}




} // Main Choice Page Check
?>


	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->

<!-- Step Content End ================================================== -->


