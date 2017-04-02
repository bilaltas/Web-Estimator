<?php

if ( $this->stepStatus("ecommerce_products") == "current" ) {

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
<h3>How many products do you want to add your website for first?</h3>

<div class="form-group">

	<label for="products" id="products_lbl">
		<input class="form-control input-lg" type="number" name="products" id="products" value="<?=$_GET['ecommerce_products']!="" && $_GET['ecommerce_products']!="current" ? $_GET['ecommerce_products'] : '1'?>" min="1" style="width: 100px;">
		product(s)
	</label>

</div>

<button type="submit" class="btn btn-sm btn-primary">Continue</button>

<?php
	} elseif ( isset($_GET['submit']) ) {


$delete = array("submit", "products" );


		header('Location: '.$this->submit_link( $_GET['products'], 'ecommerce_images', $delete ) );
		die();

	}
?>


	</form>








	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->
<?php

}

?>