<?php
if ( $this->stepStatus("additional") == "current" ) {

	// INPUT PREFIXES
	function prfx() {return "adtn_";}
?>
<div class="row">
	<div class="col-xs-12">





	<form role="form">
<?php
// BRING THE OLD DATA
$this->bringData();
?>

<?php
	if ( !isset($_GET['submit']) ) {
?>
<input type='text' name='submit' value='yes' hidden='true'>
<h3>Check the services you also want to get.<br/><span style="color: #ECF0F1;">(Optional)</span></h3>

<div class="form-group">



<ul class="main">



	<li class="item <?=$this->namer("logo")?>">
		<label class="checkbox" for="<?=$this->namer("logo")?>">
			<input type="checkbox" data-toggle="checkbox" value="yes" id="<?=$this->namer("logo")?>" name="<?=$this->namer("logo")?>" <?=$this->checker('logo')?> >
				Logo Design <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>
	</li>


	<li class="item <?=$this->namer("underconstruction")?>">
		<label class="checkbox" for="<?=$this->namer("underconstruction")?>">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("underconstruction")?>" value="yes" id="<?=$this->namer("underconstruction")?>" <?=$this->checker('underconstruction')?> >
				Custom Under Construction Page <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>
	</li>


	<li class="item <?=$this->namer("contentwriting")?>">
		<label class="checkbox" for="<?=$this->namer("contentwriting")?>">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("contentwriting")?>" value="yes" id="<?=$this->namer("contentwriting")?>" <?=$this->checker('contentwriting')?> >
				Content Writing Service <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>
	</li>


	<li class="item <?=$this->namer("socialmedia")?>">
		<label class="checkbox" for="<?=$this->namer("socialmedia")?>">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("socialmedia")?>" value="yes" id="<?=$this->namer("socialmedia")?>" onchange="checktheother(this.id, 'must', '<?=$this->namer("socialmedia_setup")?>', '<?=$this->namer("socialmedia_management")?>');" <?=$this->checker('socialmedia')?> >
				Social Media Management <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>

			<ul class="sub">

				<li class="item sub-item <?=$this->namer("socialmedia_setup")?>">
					<label class="checkbox" for="<?=$this->namer("socialmedia_setup")?>" id="<?=$this->namer("socialmedia_alt")?>">
						<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("socialmedia_setup")?>" value="yes" id="<?=$this->namer("socialmedia_setup")?>" <?=$this->checker('socialmedia_setup')?> onclick="unchecktheother(this.id, '<?=$this->namer("socialmedia")?>', '<?=$this->namer("socialmedia_management")?>');" >
							Social Media Setup and Design <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
					</label>
				</li>

				<li class="item sub-item <?=$this->namer("socialmedia_management")?>">
					<label class="checkbox" for="<?=$this->namer("socialmedia_management")?>" id="<?=$this->namer("socialmedia_alt2")?>">
						<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("socialmedia_management")?>" value="yes" id="<?=$this->namer("socialmedia_management")?>" <?=$this->checker('socialmedia_management')?> onclick="unchecktheother(this.id, '<?=$this->namer("socialmedia")?>', '<?=$this->namer("socialmedia_setup")?>');" >
							Social Media Management <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
					</label>
				</li>

			</ul>

	</li>


	<li class="item <?=$this->namer("speed")?>">
		<label class="checkbox" for="<?=$this->namer("speed")?>">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("speed")?>" value="yes" id="<?=$this->namer("speed")?>" onclick="justunchecktheother(this.id, '<?=$this->namer("seo")?>');" <?=$this->checker('speed')?> >
				Speed Optimization <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>
	</li>


	<li class="item <?=$this->namer("seo")?>">
		<label class="checkbox" for="<?=$this->namer("seo")?>">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("seo")?>" value="yes" id="<?=$this->namer("seo")?>" onclick="checktheother(this.id, 'normal', '<?=$this->namer("speed")?>');" <?=$this->checker('seo')?> >
				Organic Search Engine Optimization <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>
	</li>


	<li class="item <?=$this->namer("advertisement")?>">
		<label class="checkbox" for="<?=$this->namer("advertisement")?>">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("advertisement")?>" value="yes" id="<?=$this->namer("advertisement")?>" <?=$this->checker('advertisement')?> >
				Marketing & Advertisement <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>

			<ul class="sub">

				<li class="item sub-item <?=$this->namer("advertisement_marketing")?>">
					<label class="checkbox" for="<?=$this->namer("advertisement_marketing")?>" id="<?=$this->namer("advertisement_alt")?>">
						<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("advertisement_marketing")?>" value="yes" id="<?=$this->namer("advertisement_marketing")?>" onclick="checktheother(this.id, 'must', '<?=$this->namer("advertisement_marketing_marketing_research")?>', '<?=$this->namer("advertisement_marketing_pr_analysis")?>', '<?=$this->namer("advertisement")?>'); unchecktheother(this.id, '<?=$this->namer("advertisement")?>', '<?=$this->namer("advertisement_facebook")?>', '<?=$this->namer("advertisement_adwords")?>');" <?=$this->checker('advertisement_marketing')?> >
							Company Marketing Service <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
					</label>

						<ul class="sub sub-double">

							<li class="item sub-double-item <?=$this->namer("advertisement_marketing_marketing_research")?>">
								<label class="checkbox" for="<?=$this->namer("advertisement_marketing_marketing_research")?>" id="<?=$this->namer("advertisement_marketing_alt")?>">
									<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("advertisement_marketing_marketing_research")?>" value="yes" id="<?=$this->namer("advertisement_marketing_marketing_research")?>" onclick="unchecktheother(this.id, '<?=$this->namer("advertisement_marketing")?>', '<?=$this->namer("advertisement_marketing_pr_analysis")?>');" <?=$this->checker('advertisement_marketing_marketing_research')?> >
										Marketing Research <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
								</label>
							</li>

							<li class="item sub-double-item <?=$this->namer("advertisement_marketing_pr_analysis")?>">
								<label class="checkbox" for="<?=$this->namer("advertisement_marketing_pr_analysis")?>" id="<?=$this->namer("advertisement_marketing_alt2")?>">
									<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("advertisement_marketing_pr_analysis")?>" value="yes" id="<?=$this->namer("advertisement_marketing_pr_analysis")?>" <?=$this->checker('advertisement_marketing_pr_analysis')?> onclick="unchecktheother(this.id, '<?=$this->namer("advertisement_marketing")?>', '<?=$this->namer("advertisement_marketing_marketing_research")?>');" >
										PR Analysis <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
								</label>
							</li>

						</ul>

				</li>

				<li class="item sub-item <?=$this->namer("advertisement_adwords")?>">
					<label class="checkbox" for="<?=$this->namer("advertisement_adwords")?>" id="<?=$this->namer("advertisement_alt2")?>">
						<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("advertisement_adwords")?>" value="yes" id="<?=$this->namer("advertisement_adwords")?>" <?=$this->checker('advertisement_adwords')?> onclick="unchecktheother(this.id, '<?=$this->namer("advertisement")?>', '<?=$this->namer("advertisement_facebook")?>', '<?=$this->namer("advertisement_marketing")?>');">
							Google Adwords (Marketing Research is recommended for best results) <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
					</label>

						<ul class="sub sub-double">

							<li class="item sub-double-item <?=$this->namer("advertisement_adwords_google_budget")?>">
								<label class="checkbox" for="<?=$this->namer("advertisement_adwords_google_budget")?>" id="<?=$this->namer("advertisement_adwords_alt")?>">
									What is your budget for this advertisement? (At least $4.000 is recommended but it's up to you)
									<div class="input-group" style="width: 180px;">
										<span class="input-group-addon">$</span>
										<input type="number" class="form-control" name="<?=$this->namer("advertisement_adwords_google_budget")?>" id="<?=$this->namer("advertisement_adwords_google_budget")?>" value="<?=$this->valuer('advertisement_adwords_google_budget', '4000')?>" min="5" <?=$this->disabler('advertisement_adwords_google_budget')?>>
										<span class="input-group-addon">.00</span>
									</div>
								</label>
							</li>

						</ul>

				</li>

				<li class="item sub-item <?=$this->namer("advertisement_facebook")?>">
					<label class="checkbox" for="<?=$this->namer("advertisement_facebook")?>" id="<?=$this->namer("advertisement_alt3")?>">
						<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("advertisement_facebook")?>" value="yes" id="<?=$this->namer("advertisement_facebook")?>" <?=$this->checker('advertisement_facebook')?> onclick="unchecktheother(this.id, '<?=$this->namer("advertisement")?>', '<?=$this->namer("advertisement_adwords")?>', '<?=$this->namer("advertisement_marketing")?>');" >
							Facebook (Marketing Research is recommended for best results) <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
					</label>

						<ul class="sub sub-double">

							<li class="item sub-double-item <?=$this->namer("advertisement_facebook_facebook_budget")?>">
								<label class="checkbox" for="<?=$this->namer("advertisement_facebook_facebook_budget")?>" id="<?=$this->namer("advertisement_facebook_alt")?>">
									What is your budget for this advertisement? (At least $4.000 is recommended but it's up to you)
									<div class="input-group" style="width: 180px;">
										<span class="input-group-addon">$</span>
										<input type="number" class="form-control" name="<?=$this->namer("advertisement_facebook_facebook_budget")?>" id="<?=$this->namer("advertisement_facebook_facebook_budget")?>" value="<?=$this->valuer('advertisement_facebook_facebook_budget', '4000')?>" min="5" <?=$this->disabler('advertisement_facebook_facebook_budget')?>>
										<span class="input-group-addon">.00</span>
									</div>
								</label>
							</li>

						</ul>

				</li>

			</ul>

	</li>


	<li class="item <?=$this->namer("backup")?>">
		<label class="checkbox" for="<?=$this->namer("backup")?>">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("backup")?>" value="yes" id="<?=$this->namer("backup")?>" <?=$this->checker('backup')?> onclick="justunchecktheother(this.id, '<?=$this->namer("security")?>');" >
				Auto/Cloud Backup <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>
	</li>


	<li class="item <?=$this->namer("security")?>">
		<label class="checkbox" for="<?=$this->namer("security")?>">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("security")?>" value="yes" id="<?=$this->namer("security")?>" onclick="checktheother(this.id, 'normal', '<?=$this->namer("backup")?>');" <?=$this->checker('security')?> >
				Extra Security <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>
	</li>


	<li class="item <?=$this->namer("newsletter")?>">
		<label class="checkbox" for="<?=$this->namer("newsletter")?>">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("newsletter")?>" value="yes" id="<?=$this->namer("newsletter")?>" <?=$this->checker('newsletter')?> >
				Newsletter <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>
	</li>


	<li class="item <?=$this->namer("chat")?>">
		<label class="checkbox" for="<?=$this->namer("chat")?>">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("chat")?>" value="yes" id="<?=$this->namer("chat")?>" <?=$this->checker('chat')?> >
				Live Support Chat Feature <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>
	</li>

	<li class="item <?=$this->namer("updates")?>">
		<label class="checkbox" for="<?=$this->namer("updates")?>">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("updates")?>" value="yes" id="<?=$this->namer("updates")?>" <?=$this->checker('updates')?> >
				Periodic Maintenance & Updates <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>
	</li>

	<li class="item <?=$this->namer("customrequests")?>">
		<label class="checkbox" for="<?=$this->namer("customrequests")?>">
			<input type="checkbox" data-toggle="checkbox" name="<?=$this->namer("customrequests")?>" value="yes" id="<?=$this->namer("customrequests")?>" <?=$this->checker('customrequests')?> >
				Custom Requests & Programs <a title="Description." data-toggle="tooltip" data-placement="top">(?)</a>
		</label>
	</li>


</ul>







<button type="submit" name="<?=$this->namer("submit")?>" class="btn btn-sm btn-primary">Go to Results</button>

<?php
	} elseif ( isset($_GET['submit']) && isset($_GET[prfx().'submit']) ) {



	$x = array(
	"adtn_logo",
	"adtn_customrequests",
	"adtn_underconstruction",
	"adtn_contentwriting",
	"adtn_socialmedia",
	"adtn_socialmedia_setup",
	"adtn_socialmedia_management",
	"adtn_speed",
	"adtn_seo",
	"adtn_advertisement",
	"adtn_advertisement_marketing",
	"adtn_advertisement_marketing_marketing_research",
	"adtn_advertisement_marketing_pr_analysis",
	"adtn_advertisement_adwords",
	"adtn_advertisement_adwords_google_budget",
	"adtn_advertisement_facebook",
	"adtn_advertisement_facebook_facebook_budget",
	"adtn_backup",
	"adtn_security",
	"adtn_newsletter",
	"adtn_chat",
	"adtn_updates");


foreach ($x as $y) {

	if ($_GET[$y] != "") {

		$there_is_a_value = true;
		break;
	}

}

	if ($there_is_a_value) $result="yes";
		else  $result="no";


	$delete = array("submit", "adtn_submit");

		header('Location: '.$this->submitLink( $result, 'results', $delete ) );
		die();




	} elseif ( isset($_GET['submit']) && isset($_GET['tmp_submit']) ) {






	$delete = array(
	"submit",
	"tmp_submit",
	"adtn_customrequests",
	"adtn_logo",
	"adtn_underconstruction",
	"adtn_contentwriting",
	"adtn_socialmedia",
	"adtn_socialmedia_setup",
	"adtn_socialmedia_management",
	"adtn_speed",
	"adtn_seo",
	"adtn_advertisement",
	"adtn_advertisement_marketing",
	"adtn_advertisement_marketing_marketing_research",
	"adtn_advertisement_marketing_pr_analysis",
	"adtn_advertisement_adwords",
	"adtn_advertisement_adwords_google_budget",
	"adtn_advertisement_facebook",
	"adtn_advertisement_facebook_facebook_budget",
	"adtn_backup",
	"adtn_security",
	"adtn_newsletter",
	"adtn_chat",
	"adtn_updates");


	$x = array(
	"adtn_logo",
	"adtn_customrequests",
	"adtn_underconstruction",
	"adtn_contentwriting",
	"adtn_socialmedia",
	"adtn_socialmedia_setup",
	"adtn_socialmedia_management",
	"adtn_speed",
	"adtn_seo",
	"adtn_advertisement",
	"adtn_advertisement_marketing",
	"adtn_advertisement_marketing_marketing_research",
	"adtn_advertisement_marketing_pr_analysis",
	"adtn_advertisement_adwords",
	"adtn_advertisement_adwords_google_budget",
	"adtn_advertisement_facebook",
	"adtn_advertisement_facebook_facebook_budget",
	"adtn_backup",
	"adtn_security",
	"adtn_newsletter",
	"adtn_chat",
	"adtn_updates");

	foreach ($x as $y) {

		if ($_GET[str_replace("adtn_", "tmp_", $y)] != "") {

			$there_is_a_value = true;
			break;
		}

	}

	if ($there_is_a_value) $result="yes";
		else  $result="no";

		header('Location: '.str_replace("tmp_", "adtn_", $this->submitLink( $result, 'results', $delete ) ) );
		die();


	}
?>

</div>  <!-- /.form-group -->
	</form>








	</div> <!-- /.col-xs-12 -->
</div> <!-- /row -->
<?php
}
?>


<script>
<?php
if ( $this->stepSlug("additional") || $this->stepSlug("dynamic_pages") ) {
?>

	function checktheother(id, must, destination, destination2, destination3) {

	 	if (document.getElementById(id) != null) {
			if (document.getElementById(id).checked == true) {
				if (document.getElementById(destination) != null) document.getElementById(destination).checked = true;
				if (destination2!="" && document.getElementById(destination2)!=null ) document.getElementById(destination2).checked = true;
				if (destination3!="" && document.getElementById(destination3)!=null ) document.getElementById(destination3).checked = true;
			}
		}

		if (document.getElementById(destination) != null) {
			document.getElementById(destination).onchange = function(){

				if ( must=='must') {
					if (document.getElementById(destination).checked == false && document.getElementById(destination2).checked == false) {
						if (document.getElementById(id) != null) document.getElementById(id).checked = false;
					}
					if (document.getElementById(destination).checked == true) {
						if (document.getElementById(id) != null) document.getElementById(id).checked = true;
					}
				} else {
					if (document.getElementById(destination).checked == false) {
						if (document.getElementById(id) != null) document.getElementById(id).checked = false;
					}
				}

			};
		}

		if ( destination2!="" ) {

			if (document.getElementById(destination2) != null) {
				document.getElementById(destination2).onchange = function(){

					if ( must=='must') {
						if (document.getElementById(destination2).checked == false && document.getElementById(destination).checked == false) {
							if (document.getElementById(id) != null) document.getElementById(id).checked = false;
						}
						if (document.getElementById(destination2).checked == true) {
							if (document.getElementById(id) != null) document.getElementById(id).checked = true;
						}
					} else {
						if (document.getElementById(destination2).checked == false) {
							if (document.getElementById(id) != null) document.getElementById(id).checked = false;
						}
					}

				};
			}
		}

		if ( destination3!="" ) {

			if (document.getElementById(destination3) != null) {
				document.getElementById(destination3).onchange = function(){

					if ( must=='must') {
						if (document.getElementById(destination3).checked == false && document.getElementById(destination2).checked == false && document.getElementById(destination).checked == false) {
							if (document.getElementById(id) != null) document.getElementById(id).checked = false;
						}
						if (document.getElementById(destination3).checked == true) {
							if (document.getElementById(id) != null) document.getElementById(id).checked = true;
						}
					} else {
						if (document.getElementById(destination3).checked == false) {
							if (document.getElementById(id) != null) document.getElementById(id).checked = false;
						}
					}

				};
			}
		}


	}

	window.onload = checktheother;

	function unchecktheother(id, destination, dependent1, dependent2, dependent3) {


		if ( dependent1 == null && dependent2 == null && dependent3 == null ) {
		 	if (document.getElementById(id) != null) {
				if (document.getElementById(id).checked == false) {
					if (document.getElementById(destination) != null) document.getElementById(destination).checked = false;
				} else {
					if (document.getElementById(destination) != null) document.getElementById(destination).checked = true;
				}
			}
		} else if ( dependent1 != null && dependent2 == null && dependent3 == null ) {
		 	if (document.getElementById(id) != null) {
				if (document.getElementById(id).checked == false) {
					if (document.getElementById(destination) != null && document.getElementById(dependent1).checked != true ) document.getElementById(destination).checked = false;
				} else {
					if (document.getElementById(destination) != null && document.getElementById(dependent1).checked != true ) document.getElementById(destination).checked = true;
				}
			}
		} else if ( dependent1 != null && dependent2 != null && dependent3 == null ) {
		 	if (document.getElementById(id) != null) {
				if (document.getElementById(id).checked == false) {
					if (document.getElementById(destination) != null && document.getElementById(dependent1).checked != true && document.getElementById(dependent2).checked != true ) document.getElementById(destination).checked = false;
				} else {
					if (document.getElementById(destination) != null && document.getElementById(dependent1).checked != true && document.getElementById(dependent2).checked != true ) document.getElementById(destination).checked = true;
				}
			}
		} else if ( dependent1 != null && dependent2 != null && dependent3 != null ) {
		 	if (document.getElementById(id) != null) {
				if (document.getElementById(id).checked == false) {
					if (document.getElementById(destination) != null && document.getElementById(dependent1).checked != true && document.getElementById(dependent2).checked != true ) document.getElementById(destination).checked = false;
				} else {
					if (document.getElementById(destination) != null && document.getElementById(dependent1).checked != true && document.getElementById(dependent2).checked != true ) document.getElementById(destination).checked = true;
				}
			}
		}

	}


	function justunchecktheother(id, destination, dependent1, dependent2, dependent3) {


		if ( dependent1 == null && dependent2 == null && dependent3 == null ) {
		 	if (document.getElementById(id) != null) {
				if (document.getElementById(id).checked == false) {
					if (document.getElementById(destination) != null) document.getElementById(destination).checked = false;
				}
			}
		} else if ( dependent1 != null && dependent2 == null && dependent3 == null ) {
		 	if (document.getElementById(id) != null) {
				if (document.getElementById(id).checked == false) {
					if (document.getElementById(destination) != null && document.getElementById(dependent1).checked != true ) document.getElementById(destination).checked = false;
				}
			}
		} else if ( dependent1 != null && dependent2 != null && dependent3 == null ) {
		 	if (document.getElementById(id) != null) {
				if (document.getElementById(id).checked == false) {
					if (document.getElementById(destination) != null && document.getElementById(dependent1).checked != true && document.getElementById(dependent2).checked != true ) document.getElementById(destination).checked = false;
				}
			}
		} else if ( dependent1 != null && dependent2 != null && dependent3 != null ) {
		 	if (document.getElementById(id) != null) {
				if (document.getElementById(id).checked == false) {
					if (document.getElementById(destination) != null && document.getElementById(dependent1).checked != true && document.getElementById(dependent2).checked != true ) document.getElementById(destination).checked = false;
				}
			}
		}


	}

<?php
}
?>

</script>