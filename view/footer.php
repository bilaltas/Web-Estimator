<!-- Footer ================================================== -->

    <footer>
      <div class="container">
        <div class="row">
          <div class="col-xs-7">
            <h3 class="footer-title">Subscribe</h3>


            <p>Do you like this freebie? Want to get more stuff like this?<br>
              Subscribe to WebEstimator news and updates to stay tuned on great deals.<br><br>
              Go to: <a href="<?=$this->homePageURL()?>" target="_blank">http://web-estimator.com/</a>
            </p>

            <a class="footer-brand" href="<?=$this->homePageURL()?>" target="_blank">
              <img src="img/footer/logo.png" alt="Logo" />
            </a>
          </div> <!-- /col-xs-7 -->


          <div class="col-xs-5">
            <div class="footer-banner">

<img src="img/login/icon.png" class="login-image">
<?= !$this->isLoggedIn() ? '
<h5 class="footer-title">If you are a registered user, please sign in!
	<small title="They are the companies who offer their clients website service and are getting special discount by lower hourly rate than our standart hourly rate." data-toggle="tooltip" data-placement="top">Who are they?</small>
</h5>' : '
<h5 class="footer-title" style="line-height: 20px;">Welcome Mr.
<span style="text-transform: capitalize;">'.$_SESSION['login_user'].'</span><br/>
	<a href="'.$this->currentPageURL("logout").'" style="text-decoration: none;">
		<small title="Log-out" data-toggle="tooltip" data-placement="top">This is not you?</small>
	</a>
</h5><br/><br/>'; ?>

<?php
	if ( !$this->isLoggedIn() ) {
?>
<form action="<?= $this->currentPageURL("login") ?>" method="post" id="login-form">
	<div class="login-form">
		<div class="form-group">
			<input type="text" class="form-control login-field" placeholder="Enter your e-mail" id="login-name" name="login-name">
			<label class="login-field-icon fui-user" for="login-name"></label>
		</div>

		<div class="form-group">
			<input type="password" class="form-control login-field" placeholder="Password" id="login-pass" name="login-pass">
			<label class="login-field-icon fui-lock" for="login-pass"></label>
		</div>

		<input type="submit" style="display: none;"/>
		<a class="btn btn-primary btn-lg btn-block" onclick="document.getElementById('login-form').submit(); return false;" href="javascript:{}" style="color: #fff; text-decoration: none;">Log in</a>


		<a class="login-link" href="#" style="color: rgb(191, 201, 202); text-decoration: none;">Lost your password?</a>
		<a class="login-link" href="#" style="color: rgb(191, 201, 202); text-decoration: none;">I want to be registered user</a>
	</div>
</form>
<?php
	} else {
?>
<center>
Now, you can go ahead on these 10 steps.<br/>
Then, I will help you on the last step.
</center>

<a href="<?=$this->currentPageURL("logout")?>" style="text-decoration: none; position: absolute; right: 50px; margin-top: 40px; font-weight: bold; color: #DCFF96;">
	<small title="Log-out">Sign Out</small>
</a>
<?php
	}
?>


            </div> <!-- /footer-banner -->
          </div> <!-- /col-xs-5 -->


        </div> <!-- /row -->
      </div> <!-- /container -->
    </footer>


    <!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
    <script src="js/vendor/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/flat-ui.min.js"></script>
    <!-- Custom JS -->
    <script src="js/custom.js"></script>

<!-- Footer End ================================================== -->


