<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Web Estimator <?= $_SERVER["QUERY_STRING"] == "" ? "- BETA" : ( $this->stepNo() == "" ? "" : "- ".$this->stepNo()."." )." ".$this->stepTitle() ?></title>
    <meta name="description" content="Web Estimator clearly calculates cost and time to build any website project for free in a few minutes."/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <!-- Loading Bootstrap -->
	    <link href="css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	    <!-- Loading Fonts
	    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&amp;subset=latin-ext" rel="stylesheet"> -->

	    <!-- Loading Flat UI -->
	    <link href="css/vendor/flat-ui.css?v2" rel="stylesheet">

	    <!-- Loading Additional Styles -->
	    <link href="css/custom.css" rel="stylesheet">

	    <link rel="shortcut icon" href="img/favicon.ico">

  </head>
  <body class="<?= $_SERVER["QUERY_STRING"] == "" ? 'home' : 'other' ?>">

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-29465312-6', 'auto');
	  ga('send', 'pageview');

	</script>



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