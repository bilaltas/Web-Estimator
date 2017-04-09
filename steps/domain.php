<?php

if ( $this->stepStatus("domain") == "current" ) {

?>
<div class="row">
	<div class="col-xs-12">





	<form role="form">
<?php
// BRING THE OLD DATA
$this->bringdata();
?>

<?php
	if ( !isset($_GET['domaininf']) ) {
?>
<h3>Will you provide us a domain to use on your project?</h3>



<div class="form-group">
 <label class="radio primary">
    <input type="radio" data-toggle="radio" name="domaininf" id="domainy" value="yes" data-radiocheck-toggle="radio" <?=$_GET['domain']=="yes" ? 'checked="" ' : ''?> required>
    Yes, I already have my website's domain
  </label>
  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="domaininf" id="domainn" value="no" data-radiocheck-toggle="radio" <?=$_GET['domain']=="no" ? 'checked="" ' : ''?>>
    No, we will buy a new domain
  </label>
</div>

<button type="submit" class="btn btn-sm btn-primary">Continue</button>
<?php
	} else {

		header('Location: '.$this->submitLink( $_GET['domaininf'], 'server', array("domaininf") ) );
		die();

	}
?>


	</form>








	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->
<?php

}

?>