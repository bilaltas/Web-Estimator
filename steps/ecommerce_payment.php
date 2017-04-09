<?php

if ( $this->stepStatus("ecommerce_payment") == "current" ) {

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

<h3>Which payment methods will your website use?</h3>

<div class="form-group">

      <label class="checkbox" for="<?=$this->prefixer('pymnt_')?>payment_paypal">
        <input type="checkbox" data-toggle="checkbox" name="<?=$this->prefixer('pymnt_')?>payment_paypal" value="yes" id="<?=$this->prefixer('pymnt_')?>payment_paypal" <?=$this->checker('pymnt_payment_paypal')?>>
        Via PayPal (No requirements)
      </label>
      <label class="checkbox" for="<?=$this->prefixer('pymnt_')?>payment_card">
        <input type="checkbox" data-toggle="checkbox" name="<?=$this->prefixer('pymnt_')?>payment_card" value="yes" id="<?=$this->prefixer('pymnt_')?>payment_card" <?=$this->checker('pymnt_payment_card')?>>
        Credit Card Direct Payment (Needs some merchandise information)
      </label>
      <label class="checkbox" for="<?=$this->prefixer('pymnt_')?>payment_other">
        <input type="checkbox" data-toggle="checkbox" name="<?=$this->prefixer('pymnt_')?>payment_other" value="yes" id="<?=$this->prefixer('pymnt_')?>payment_other" <?=$this->checker('pymnt_payment_other')?>>
        Others (Wire, Pay on Delivery, etc. )
      </label>

<br/><br/>
<h4>Do you want to purchase a SSL Security Certificate? SSL is especially recommended for e-Commerce websites.</h4>
  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="ssl" id="ssly" value="yes" data-radiocheck-toggle="radio" <?=$this->radiochecker('ecommerce_payment', 'sslyes')?>required>
    Yes, I do.
  </label>
  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="ssl" id="ssln" value="no" data-radiocheck-toggle="radio" <?=$this->radiochecker('ecommerce_payment', 'sslno')?> required>
    No, I don't want it.
  </label>

</div>

<button type="submit" name="<?=$this->prefixer('pymnt_')?>submit" class="btn btn-sm btn-primary">Continue</button>

<?php
	} elseif ( isset($_GET['submit']) && isset($_GET['pymnt_submit']) ) {



		$delete = array("submit", "pymnt_submit", "ssl");

		header('Location: '.$this->submitLink( "ssl".$_GET['ssl'], 'additional', $delete ) );
		die();



	} elseif ( isset($_GET['submit']) && isset($_GET['tmp_submit']) ) {



		$delete = array("submit", "tmp_submit", "ssl", "pymnt_payment_paypal", "pymnt_payment_card", "pymnt_payment_other"  );

		header('Location: '.str_replace("tmp_", "pymnt_", $this->submitLink( "ssl".$_GET['ssl'], 'additional', $delete ) ) );
		die();


	}
?>


	</form>








	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->
<?php

}

?>