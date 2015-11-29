$(document).ready(function() {
	$('#page-content-wrapper').load('recipes.php');
	$('#sidebar-wrapper ul li a').click(function(){
		var cid = $(this).attr('href');
		if (!isNaN(cid)) {
			$('#page-content-wrapper').load('recipes.php?cuisine_id='+cid);
			return false;
		}  else {
			return true;
		}
		

	} );

});

