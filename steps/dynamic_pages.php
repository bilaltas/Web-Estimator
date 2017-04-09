<?php

if ( $this->stepStatus("dynamic_pages") == "current" ) {

	// INPUT PREFIXES
	function prfx() {return "dynmc_";}
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
<h3>Check the <b>dynamic</b> pages you want to add into your website.<br/><span style="color: #ECF0F1;">(Optional)</span></h3>

<div class="form-group">


<ul class="main">



	<li class="item <?=$this->prefixer()?>blog">

		<label class="checkbox" for="<?=$this->prefixer()?>blog">
			<input type="checkbox" data-toggle="checkbox" value="yes" id="<?=$this->prefixer()?>blog" name="<?=$this->prefixer()?>blog" <?=$this->checker('blog_posts')?>>
				Blog Page
		</label>

			<ul class="sub">

				<li class="item sub-item <?=$this->prefixer()?>blog_posts">
					<label for="<?=$this->prefixer()?>blog_posts" id="<?=$this->prefixer()?>blog_sub" style="display: <?=$this->hider('blog_posts')?>;">
						How many blog posts do you want to add for first?
						<input class="form-control input-lg" type="number" name="<?=$this->prefixer()?>blog_posts" id="<?=$this->prefixer()?>blog_posts" value="<?=$this->valuer('blog_posts', '0')?>" min="0" style="width: 100px;" <?=$this->disabler(prfx().'blog_posts')?>>
						blog post(s)
					</label>
				</li>

			</ul>

	</li>


	<li class="item <?=$this->prefixer()?>portfolio">
		<label class="checkbox" for="<?=$this->prefixer()?>portfolio">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->prefixer()?>portfolio" value="yes" id="<?=$this->prefixer()?>portfolio" <?=$this->checker('portfolio_items')?>>
			Portfolio Page Page
		</label>

			<ul class="sub">

				<li class="item sub-item <?=$this->prefixer()?>portfolio_items">
					<label for="<?=$this->prefixer()?>portfolio_items" id="<?=$this->prefixer()?>portfolio_sub" style="display: <?=$this->hider('portfolio_items')?>;">
						How many portfolio items do you want to add for first?
						<input class="form-control input-lg" type="number" name="<?=$this->prefixer()?>portfolio_items" id="<?=$this->prefixer()?>portfolio_items" value="<?=$this->valuer('portfolio_items', '0')?>" min="0" style="width: 100px;" <?=$this->disabler(prfx().'portfolio_items')?>>
						blog post(s)
					</label>
				</li>

			</ul>
	</li>



</ul>




<button type="submit" name="<?=$this->prefixer()?>submit" class="btn btn-sm btn-primary">Continue</button>

<?php
	} elseif ( isset($_GET['submit']) &&  isset($_GET[prfx().'submit']) ) {



		$counted = $_GET[prfx().'blog_posts'] + $_GET[prfx().'portfolio_items']; // RECALCULATE HERE!!!

		$delete = array("submit", prfx()."submit", prfx()."blog", prfx()."portfolio");


		if ( (isset($_GET[prfx().'blog']) && $_GET[prfx().'blog']!="yes") && (isset($_GET[prfx().'portfolio']) && $_GET[prfx().'portfolio']!="yes") ) { $counted = "no"; }
		if ( !isset($_GET[prfx().'blog']) && !isset($_GET[prfx().'portfolio']) ) { $counted = "no"; }

			if ( $_GET['website']=="ecommerce" ) {
				header('Location: '.$this->submitLink( $counted, 'ecommerce_products', $delete ) );
				die();
			}elseif ( $_GET['website']=="news" ) {
				header('Location: '.$this->submitLink( $counted, 'news_blabla', $delete ) );
				die();
			}



	} elseif ( isset($_GET['submit']) &&  isset($_GET['tmp_submit']) ) {



		$counted = $_GET['tmp_blog_posts'] + $_GET['tmp_portfolio_items']; // RECALCULATE HERE!!!

		$delete = array("submit", "tmp_submit", "tmp_blog", "tmp_portfolio", prfx()."blog_posts", prfx()."portfolio_items" );



		if ( (isset($_GET['tmp_blog']) && $_GET['tmp_blog']!="yes") && (isset($_GET['tmp_portfolio']) && $_GET['tmp_portfolio']!="yes") ) { $counted = "no"; }
		if ( !isset($_GET['tmp_blog']) && !isset($_GET['tmp_portfolio']) ) { $counted = "no"; }

			if ( $_GET['website']=="ecommerce" ) {
				header('Location: '.str_replace("tmp_", prfx(), $this->submitLink( $counted, 'ecommerce_products', $delete ) ) );
				die();
			}elseif ( $_GET['website']=="news" ) {
				header('Location: '.str_replace("tmp_", prfx(), $this->submitLink( $counted, 'news_blabla', $delete ) ) );
				die();
			}



	}
?>

</div> <!-- /.form-group -->

	</form>








	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->
<?php

}

?>