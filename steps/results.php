<?php

if ( $this->stepStatus("results") == "current" ) {

?>
<div class="row">
	<div class="col-xs-12">





	<form role="form">
<?php
// BRING THE OLD DATA
$this->bringdata();
?>

<?php
	if ( !isset($_GET['submit']) ) {
?>
<input type='text' name='submit' value='yes' hidden='true'>
<h3>Review your choices.</h3>

<?

foreach ($_GET as $question=>$answer) {
	echo $question." => ".$answer."<br/><br/>";
}


?>

<?php
	} elseif ( isset($_GET['submit']) ) {


$delete = array("submit", "blog", "portfolio", "blog_posts", "portfolio_items" );

$counted = $_GET['blog_posts'] + $_GET['portfolio_items']; // RECALCULATE HERE!!!


		header('Location: '.$this->submitLink( $counted, 'results', $delete ) );
		die();
	}
?>


	</form>








	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->
<?php

}

?>