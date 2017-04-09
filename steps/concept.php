<?php

if ( $this->stepStatus("concept") == "current" ) {

?>
<div class="row">
	<div class="col-xs-12">


<h3><?php


?></h3>

		<div class="btn-group" style="width: 100%;">

			<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" style="width: 100%;"><?php

if ( !isset($_GET['go']) || $_GET['website']=="current" ) {	echo "Chose the type of website you want us to build:";}
elseif ($_GET['website']=="ecommerce") { echo "Selected: E-Commerce"; }
elseif ($_GET['website']=="news") { echo "Selected: News"; }
elseif ($_GET['website']=="blog") { echo "Selected: Blog"; }
elseif ($_GET['website']=="portfolio") { echo "Selected: Portfolio"; }
elseif ($_GET['website']=="promotion") { echo "Selected: Promotion"; }
elseif ($_GET['website']=="security") { echo "Selected: Security"; }
elseif ($_GET['website']=="speed") { echo "Selected: Speed"; }

?><span class="caret"></span></button>
			<ul role="menu" class="dropdown-menu" style="width: 100%;">
<?php

foreach ($this->mainChoices as $mainChoiceTitleID => $mainChoiceTitle) {

	echo '<li class="dropdown-header" role="presentation">'.$mainChoiceTitle[0].'</li>';

	foreach ($mainChoiceTitle[1] as $choiceID => $choiceName) {
		$isDisabled = ( substr($choiceID, 0, 1) == "_" ? true : false);

		echo '
		<li'.($isDisabled ? " class='disabled'" : "").'>
			<a href="'.($isDisabled ? "#" : $this->submitLink($choiceID, 'domain')).'" '.($isDisabled ? 'title="Coming Soon" data-toggle="tooltip" data-placement="left"' : "").'>'.$choiceName.'</a>
		</li>';

	}

	echo '<li class="divider" role="presentation"></li>';

}

?>
			</ul>

		</div><!-- /btn-group -->


	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->
<?php

}

?>