<?php

if ( $this->stepStatus("static_pages") == "current" ) {

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

<h3>Check the <b>static</b> pages you want to add into your website.</h3>

<div class="form-group">
              <label class="checkbox" for="<?=$this->prefixer('sttc_')?>homepage">
                <input type="checkbox" data-toggle="checkbox" value="yes" id="<?=$this->prefixer('sttc_')?>homepage" name="<?=$this->prefixer('sttc_')?>homepage" disabled="" checked="checked">
                Home Page
              </label>
              <label class="checkbox" for="<?=$this->prefixer('sttc_')?>aboutus">
                <input type="checkbox" data-toggle="checkbox" name="<?=$this->prefixer('sttc_')?>aboutus" value="yes" id="<?=$this->prefixer('sttc_')?>aboutus" <?=$this->checker('sttc_aboutus')?>>
                About Us Page
              </label>
              <label class="checkbox" for="<?=$this->prefixer('sttc_')?>privacy">
                <input type="checkbox" data-toggle="checkbox" name="<?=$this->prefixer('sttc_')?>privacy" value="yes" id="<?=$this->prefixer('sttc_')?>privacy" <?=$this->checker('sttc_privacy')?>>
                Privacy Policy Page
              </label>
              <label class="checkbox" for="<?=$this->prefixer('sttc_')?>terms">
                <input type="checkbox" data-toggle="checkbox" name="<?=$this->prefixer('sttc_')?>terms" value="yes" id="<?=$this->prefixer('sttc_')?>terms" <?=$this->checker('sttc_terms')?>>
                Terms and Conditions Page
              </label>
              <label class="checkbox" for="<?=$this->prefixer('sttc_')?>contactus">
                <input type="checkbox" data-toggle="checkbox" name="<?=$this->prefixer('sttc_')?>contactus" value="yes" id="<?=$this->prefixer('sttc_')?>contactus" <?=$this->checker('sttc_contactus')?>>
                Contact Us Page
              </label>

              <label for="<?=$this->prefixer('sttc_')?>more_pages">
              	and
              	<input class="form-control input-hg" type="number" name="<?=$this->prefixer('sttc_')?>more_pages" id="<?=$this->prefixer('sttc_')?>more_pages" value="<?=$this->valuer('sttc_more_pages', '0')?>" min="0" style="width: 100px;">
              	more custom static page(s)
              </label>
            </div>

<button type="submit" name="<?=$this->prefixer('sttc_')?>submit" class="btn btn-sm btn-primary">Continue</button>

<?php
	} elseif ( isset($_GET['submit']) && isset($_GET['sttc_submit']) ) {



if ( $_GET['sttc_homepage']=="yes"   ) $sttc_homepage= 1;
if ( $_GET['sttc_aboutus']=="yes"    ) $sttc_aboutus= 1;
if ( $_GET['sttc_privacy']=="yes"    ) $sttc_privacy= 1;
if ( $_GET['sttc_terms']=="yes"      ) $sttc_terms= 1;
if ( $_GET['sttc_contactus']=="yes"  ) $sttc_contactus= 1;
$sttc_more_pages = $_GET['sttc_more_pages'];

$counted = 1 + $sttc_aboutus + $sttc_privacy + $sttc_terms + $sttc_contactus + $sttc_more_pages; // RECALCULATE HERE!!!


	header('Location: '.$this->submit_link( $counted, 'dynamic_pages', array("submit", "sttc_submit") ) );
	die();



	} elseif ( isset($_GET['submit']) && isset($_GET['tmp_submit']) ) {



if ( $_GET['tmp_homepage']=="yes"   ) $tmp_homepage= 1;
if ( $_GET['tmp_aboutus']=="yes"    ) $tmp_aboutus= 1;
if ( $_GET['tmp_privacy']=="yes"    ) $tmp_privacy= 1;
if ( $_GET['tmp_terms']=="yes"      ) $tmp_terms= 1;
if ( $_GET['tmp_contactus']=="yes"  ) $tmp_contactus= 1;
$tmp_more_pages = $_GET['tmp_more_pages'];

$counted = 1 + $tmp_aboutus + $tmp_privacy + $tmp_terms + $tmp_contactus + $tmp_more_pages; // RECALCULATE HERE!!!

	header('Location: '.str_replace("tmp_", "sttc_", $this->submit_link( $counted, 'dynamic_pages', array("submit", "tmp_submit", "sttc_more_pages", "sttc_aboutus", "sttc_privacy", "sttc_terms", "sttc_contactus") ) ) );
	die();

	}
?>


	</form>








	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->
<?php

}

?>