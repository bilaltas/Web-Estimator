    <!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
    <script src="js/vendor/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/flat-ui.min.js"></script>


<script>
$(function () {
$('[data-toggle=tooltip]').tooltip();
});

// Disable link clicks to prevent page scrolling
$(document).on('click', 'a[href="#"]', function (e) {
  e.preventDefault();
});

<?php
if ( $_SERVER["QUERY_STRING"] != "" ) {
?>
	$(function() { // when the DOM is ready...
	    //  Move the window's scrollTop to the offset position of #now
	    $(window).scrollTop($('#big-title').offset().top);
	});
<?php
}
?>


<?php
if ( $this->stepSlug("additional") || $this->stepSlug("dynamic_pages") ) {
?>
// Additional Features and Services

$('li.item input').each(function() {

		if ($( "#" + this.id ).is(":checked")) {

	          $( "." + this.id + " > ul > li > label" ).show();
			  $( "." + this.id + " > ul > li > label > input" ).prop("disabled",false);

        } else {

	          $( "." + this.id + " > ul label" ).hide();
			  $( "." + this.id + " > ul > li > label > input" ).prop("disabled",true);

        }


	$( "#" + this.id ).click(function() {

		if ($( "#" + this.id ).is(":checked")) {

	          $( "." + this.id + " > ul > li > label" ).show();
			  $( "." + this.id + " > ul li input" ).prop("disabled",false);

        } else {

	          $( "." + this.id + " > ul label" ).hide();
			  $( "." + this.id + " > ul input" ).prop("disabled",true).prop('checked', false);

        }

	});


});



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


	// Checkboxes and Radio buttons
	$('[data-toggle="checkbox"]').radiocheck();
	$('[data-toggle="radio"]').radiocheck();


</script>