<?php

if ( $this->stepStatus("ecommerce_images") == "current" ) {

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
<h3>Do you have your images/illustrations to use for the products?</h3>

<div class="form-group">

  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="images" id="imagesy" value="yes" data-radiocheck-toggle="radio" <?=isset($_GET['ecommerce_images']) && $_GET['ecommerce_images']=="yes" ? 'checked="" ' : ''?>required>
    Yes, I have. / They will be ready.
  </label>
  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="images" id="imagesh" value="half" data-radiocheck-toggle="radio" <?=isset($_GET['ecommerce_images']) && $_GET['ecommerce_images']=="half" ? 'checked="" ' : ''?> required>
    Yes, but not all the products. I need a photography service for rest of my products.
  </label>
  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="images" id="imagesn" value="no" data-radiocheck-toggle="radio" <?=isset($_GET['ecommerce_images']) && $_GET['ecommerce_images']=="no" ? 'checked="" ' : ''?>>
    No, I don't. I need a photography service for all my products.
  </label>

<br/><br/>
<h4>Would you like to secure your product images with a watermark?</h4>
  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="ecommerce_watermark" id="imagesy" value="yes" data-radiocheck-toggle="radio" <?=isset($_GET['ecommerce_watermark']) && $_GET['ecommerce_watermark']=="yes" ? 'checked="" ' : ''?>required>
    Yes, I would.
  </label>
  <label class="radio primary">
    <input type="radio" data-toggle="radio" name="ecommerce_watermark" id="imagesh" value="no" data-radiocheck-toggle="radio" <?=isset($_GET['ecommerce_watermark']) && $_GET['ecommerce_watermark']=="no" ? 'checked="" ' : ''?> required>
    No, I don't need that.
  </label>

</div>

<button type="submit" class="btn btn-sm btn-primary">Continue</button>

<?php
	} elseif ( isset($_GET['submit']) ) {



		if ( $_GET['images']=="half" ) {
			header('Location: '.$this->submit_link( $_GET['images'], 'ecommerce_photography', array("submit", "images" ) ) );
			die();
		}else {
			header('Location: '.$this->submit_link( $_GET['images'], 'ecommerce_payment', array("submit", "images", "ecommerce_photography" ) ) );
			die();
		}


	}
?>


	</form>








	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->
<?php

}

?>