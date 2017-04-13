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


	foreach ($_GET as $question => $answer) {
		echo $question." => ".$answer."<br/><br/>";
	}


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
			if ($input['input_type'] == "radio") {

				if ( $input['input_send_separate'] )
					$checked = isset($_GET[ $input['input_slug'] ]) && $_GET[ $input['input_slug'] ] == $input['input_value'] ? 'checked' : '';
				else
					$checked = $this->inputValues($inputNo) && $this->inputValues($inputNo) == $input['input_value'] ? 'checked' : '';

		?>
				<label class="radio primary">
				    <input
                		type="<?=$input['input_type']?>"
				    	data-toggle="radio"
				    	name="<?=$input['input_send_separate'] ? '' : 't_'?><?=$input['input_slug']?>"
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

			} elseif ($input['input_type'] == "checkbox") {

				// For disabled ones
				if ($input['input_disabled']) $inputNo--;

			?>

				<label class="checkbox">
                	<input
                		type="<?=$input['input_type']?>"
                		data-toggle="checkbox"
				    	name="<?=$input['input_send_separate'] ? '' : 't_'?><?=$input['input_slug']?>"
				    	value="<?=$input['input_value']?>"
				    	id="<?=$input['input_slug']?>"
				    	<?=in_array($input['input_value'], $this->inputValues()) ? 'checked' : ''?>
				    	<?=$input['input_disabled'] ? 'disabled '.($input['input_required'] ? 'checked' : '') : ''?>
                	>
					<?=$input['input_name']?>
					<?=$input['input_description'] != "" ? '<a title="'.$input['input_description'].'" data-toggle="tooltip" data-placement="top">(?)</a>' : '' ?>
				</label>


			<?php

				$inputNo++;

			} elseif ($input['input_type'] == "number") {

				if ( $input['input_send_separate'] )
					$value = isset($_GET[ $input['input_slug'] ]) ? $_GET[ $input['input_slug'] ] : $input['input_value'];
				else
					$value = $this->inputValues($inputNo) ? $this->inputValues($inputNo) : $input['input_value'];
			?>


				<label>
					<?=$input['input_name']?>
                	<input
                		class="form-control input-hg"
                		style="width: 100px;"
                		type="<?=$input['input_type']?>"
				    	name="<?=$input['input_send_separate'] ? '' : 't_'?><?=$input['input_slug']?>"
				    	value="<?=$value?>"
				    	min="0"
				    	id="<?=$input['input_slug']?>"
				    	<?=$input['input_disabled'] ? 'disabled' : ''?>
				    	<?=$input['input_required'] ? 'required' : ''?>
                	>
					<?=$input['input_description']?>
					<?=$input['input_description'] != "" ? '<a title="'.$input['input_description'].'" data-toggle="tooltip" data-placement="top">(?)</a>' : '' ?>
				</label>


			<?php

				$inputNo++;

			} elseif ($input['input_type'] == "number-checktoshow") {
			?>

				<label class="checkbox checktoshow">
					<input type="checkbox" data-toggle="checkbox" <?=$this->inputValues($inputNo) ? 'checked' : ''?>>
					<?=$input['input_checkbox_name']?>
					<?=$input['input_description'] != "" ? '<a title="'.$input['input_description'].'" data-toggle="tooltip" data-placement="top">(?)</a>' : '' ?>
				</label>

				<label style="<?=$this->inputValues($inputNo) ? '' : 'display: none;'?>">
					<?=$input['input_name']?>
                	<input
                		class="form-control input-hg"
                		style="width: 100px;"
                		type="number"
				    	name="t_<?=$input['input_slug']?>"
				    	value="<?=$this->inputValues($inputNo) ? $this->inputValues($inputNo) : $input['input_value']?>"
				    	min="0"
				    	id="<?=$inputNo?>"
				    	<?=$this->inputValues($inputNo) ? '' : 'disabled'?>
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

			if ( in_array($key, $temp_data) && $value != "" ) $data_to_send .= $value."-";

			if (end($_GET) == $value) $data_to_send = substr($data_to_send, 0, -1);

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


