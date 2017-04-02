<?php

if ( $this->stepStatus("satisfaction") == "current" ) {

?>
<div class="row">
	<div class="col-xs-12">





	<form role="form">
<?php
// BRING THE OLD DATA
$this->bringdata();
?>

<?php
	if ( !isset($_GET['satisfact']) ) {
?>
<h3>Are you satisfied with your Linux server so far?</h3>
<div class="form-group">
 <label class="radio primary">
    <input type="radio" data-toggle="radio" name="satisfact" id="satisfactiony" value="yes" data-radiocheck-toggle="radio" <?=$_GET['satisfaction']=="yes" ? 'checked="" ' : ''?> required>
    Yes, it works good
  </label>
  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="satisfact" id="satisfactionn" value="no" data-radiocheck-toggle="radio" <?=$_GET['satisfaction']=="no" ? 'checked="" ' : ''?>>
    No, I'm having trouble with my hosting company
  </label>
</div>

<button type="submit" class="btn btn-sm btn-primary">Continue</button>
<?php
	} else {

		header('Location: '.$this->submit_link( $_GET['satisfact'], 'static_pages', array("satisfact") ) );
		die();

	}
?>


	</form>








	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->
<?php

}

?>