<?php

if ( $this->stepStatus("server") == "current" ) {

?>
<div class="row">
	<div class="col-xs-12">





	<form role="form">
<?php
// BRING THE OLD DATA
$this->bringdata();
?>

<?php
	if ( !isset($_GET['hosting']) ) {
?>
<h3>Do you have a hosting package to use on your project?</h3>
<div class="form-group">
  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="hosting" id="hostingl" value="linux" data-radiocheck-toggle="radio" <?=$_GET['server']=="linux" ? 'checked="" ' : ''?>required>
    Yes, It is a <b>Linux Hosting</b>
  </label>
  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="hosting" id="hostingw" value="windows" data-radiocheck-toggle="radio" <?=$_GET['server']=="windows" ? 'checked="" ' : ''?> required>
    Yes, It is a <b>Windows Hosting</b>
  </label>
  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="hosting" id="hostingo" value="othernotsure" data-radiocheck-toggle="radio" <?=$_GET['server']=="othernotsure" ? 'checked="" ' : ''?>>
    Other or not sure
  </label>
  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="hosting" id="hostingn" value="no" data-radiocheck-toggle="radio" <?=$_GET['server']=="no" ? 'checked="" ' : ''?>>
    No, we will buy a new hosting
  </label>
</div>

<button type="submit" class="btn btn-sm btn-primary">Continue</button>
<?php
	} elseif ( $_GET['hosting'] == "linux" ) {

		header('Location: '.$this->submit_link( $_GET['hosting'], 'satisfaction', array("hosting") ) );
		die();

	} elseif ( isset($_GET['hosting']) && $_GET['hosting'] != "linux" ) {

		header('Location: '.$this->submit_link( $_GET['hosting'], 'static_pages', array("hosting", "satisfaction") ) );
		die();

	}
?>


	</form>








	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->
<?php

}

?>