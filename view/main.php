<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Web Estimator <?= $_SERVER["QUERY_STRING"] == "" ? "- BETA" : ( $this->stepNo() == "" ? "" : "- ".$this->stepNo()."." )." ".$this->stepTitle() ?></title>
    <meta name="description" content="Web Estimator clearly calculates cost and time to build any website project for free in a few minutes."/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <!-- Loading Bootstrap -->
	    <link href="css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	    <!-- Loading Flat UI -->
	    <link href="css/flat-ui.css" rel="stylesheet">

	    <!-- Loading Additional Styles -->
	    <link href="css/custom.css" rel="stylesheet">

	    <link rel="shortcut icon" href="img/favicon.ico">

  </head>
  <body class="<?= $_SERVER["QUERY_STRING"] == "" ? 'home' : 'other' ?>">

	  <div class="container">


<?php
// HEADER
include('view/header.php');

// Show step contents
$this->showContent();
?>


		<!-- Put a little space -->
		<div class="row">
			<div class="col-xs-12">
				<br/><br/><br/><br/><br/>
			</div>
		</div>


	</div> <!-- /container -->



<?php
// FOOTER
include("view/footer.php");
?>

  </body>
</html>