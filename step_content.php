<div class="row">
	<div class="col-xs-12">

<?php
if ( $this->stepSlug() == "concept" ) {
?>

		<div class="btn-group" style="width: 100%;">


<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" style="width: 100%;">
<?php

if ( !isset($_GET['go']) || $_GET['concept']=="current" ) {	echo "Chose the type of website you want us to build:";}
else {
	echo "Selected: ". $this->mainChoiceTitle($_GET['concept']);
}

?>
<span class="caret"></span></button>
	<ul role="menu" class="dropdown-menu" style="width: 100%;">
<?php


	$main_choices_cat_query = $this->dbQuery("SELECT * FROM main_choices WHERE main_choice_parent_ID = 0");
	while ($main_choice_cat = $main_choices_cat_query->fetch()) {

		echo '<li class="dropdown-header" role="presentation">'.$main_choice_cat['main_choice_name'].'</li>';

		$main_choice_query = $this->dbQuery("SELECT * FROM main_choices WHERE main_choice_parent_ID = ".$main_choice_cat['main_choice_ID'] );
		while ($main_choice = $main_choice_query->fetch()) {

			$isDisabled = ( $main_choice['main_choice_active'] ? false : true);

			echo '
			<li'.($isDisabled ? " class='disabled'" : "").'>
				<a href="'.($isDisabled ? "#" : $this->submitLink($main_choice['main_choice_slug'], 'domain')).'" '.($isDisabled ? 'title="Coming Soon" data-toggle="tooltip" data-placement="left"' : "").'>'.$main_choice['main_choice_name'].'</a>
			</li>';

		}

		echo '<li class="divider" role="presentation"></li>';

	}

?>
			</ul>

		</div><!-- /btn-group -->


<?php
} else {
?>

	<form role="form">
	<?php
	// BRING THE PREVIOUS DATA
	$this->bringdata();
	?>

<?php
	// 1. Bring the fields belong to this step
	$temp_data = array();
	$inputNo = 0;
	$fields_query = $this->dbQuery("SELECT * FROM fields WHERE step_ID = ".$this->stepID());
	while ($field = $fields_query->fetch()) {
?>

		<h3><?=$field['field_name']?></h3>

		<div class="form-group">

		<?php

		// 2. Bring the inputs belong to that field above
		$inputs_query = $this->dbQuery("SELECT * FROM inputs WHERE field_ID = ".$field['field_ID']);
		while ($input = $inputs_query->fetch()) {

			// Collect the temp data
			$temp_data[] = $input['input_slug'];

			if ($input['input_type'] == "radio") {

		?>
				<label class="radio primary">
				    <input
				    	type="radio"
				    	data-toggle="radio"
				    	name="<?=$input['input_slug']?>"
				    	value="<?=$input['input_value']?>"
				    	id="<?=$input['input_slug']?>"
				    	<?=$this->inputValue($inputNo) == $input['input_value'] ? 'checked' : ''?>
				    	<?=$input['input_required'] ? 'required' : ''?>
				    >
				    <?=$input['input_name']?>
				</label>

			<?php
				// Don't increase because it's only one choice
				//$inputNo++;

			} elseif ($input['input_type'] == "checkbox") {
			?>


			<?php

				$inputNo++;

			} elseif ($input['input_type'] == "numbers") {
			?>


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

		<button type="submit" class="btn btn-sm btn-primary">Continue</button>


	</form>

<?php

	// Temporary Data sent?
	$data_to_send = "";
	foreach ($_GET as $key => $value) {

		if ( in_array($key, $temp_data) ) {

			$data_to_send .= $value.",";

		}

	}

	if ( $data_to_send != "" ) {
		$data_to_send = substr($data_to_send, 0, -1);

		header('Location: '.$this->submitLink( $data_to_send, $this->nextStepSlug(), $temp_data ) );
		die();
	}




} // Main Choice Page Check
?>


	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->