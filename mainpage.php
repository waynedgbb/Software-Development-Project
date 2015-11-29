
<?php
			session_start();
			include("connection.php");
							$uid = '1'; //for testing
			if (isset($_SESSION['uid'])) {
				$uid = $_SESSION['uid'];
			} else {
				header("Location: project.php");
			}
?>
			<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>category_list</title>

    <!-- page icon -->
    <link rel="shortcut icon" href="favicon.ico">
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/custom.css" rel="stylesheet">
		<link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
<nav class="navbar navbar-default no-margin">
    <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header fixed-brand">
                   
                    <a class="navbar-brand" href="#"><i class="fa fa-rocket fa-4"></i>My Recipes</a>
                </div><!-- navbar-header-->
 
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="float:right;">
                            <ul class="nav navbar-nav">
										<li ><input id="searchInput" class="form-control" placeholder="Search Recipes..." STYLE="color: #000000; font-family: Verdana; font-size: 14px; background-color: #FFFFFFF;  margin-top:10px;" ></input></li>
										
										<li style="font-size=120%;"><a href="project.php?logout=1">Log Out <span class="glyphicon glyphicon-off" aria-hidden="true"></span></a></li>
                            </ul>
                </div><!-- bs-example-navbar-collapse-1 -->
    </nav>
	<div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav nav-pills nav-stacked" id="menu"">
                <h3 id="sidebar-icon"><li class="sidebar-brand"><a href='#subject'  >CUISINES</a></li></h3>

       	         <?php
							
				
					$sql = "SELECT * FROM cuisines WHERE user_id= '".$uid."' ORDER BY cuisine_title DESC";
					$res = mysql_query($sql) or die(mysql_error());
					$cuisines = "";

					if (mysql_num_rows($res)>0) {
						while ($row = mysql_fetch_assoc($res)) {
							$id = $row['id'];
							$title = $row['cuisine_title'];
							$description = $row['cuisine_description'];
							$cuisines .= "<li>";
							$cuisines .= "<a href='".$id."' >".$title."</a>";
							$cuisines .= "</li>";
						}
		
						echo $cuisines;
						
					} 
				?>
				
				<li>
					<a href="#subjectModal" data-toggle="modal"  data-target="#subjectModal">
						ADD NEW CUISINES<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
					</a>

					<!-- Modal -->
					<div class="modal fade" id="subjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      
					      <div class="modal-body">
					        
					      	<form action="cuisine_create_parse.php" method="post" class="form-horizontal" role="form">
				                <div class="form-group">
				                  <label for="inputfn3" class="col-sm-2 control-label" style="font-size:18px; ">CUISINE</label>
				                  <div class="col-sm-10" style="margin-top:10px;">
				                    <div class="input-group">
				                      <div class="input-group-addon" ><span class="glyphicon glyphicon-edit"></span></div>
				                      <input type="text" class="form-control"  name="cuisine_title" placeholder="cuisine name..">
				                    </div>
				                  </div>
				                  
				                </div>

				                <div class="form-group" style="margin-left:30px;">
				                  <div class="col-sm-offset-7 col-sm-10">
				                  	<button type="submit" class="btn btn-primary">Save changes</button>
				                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					        					
				                  </div>
				                </div>
				            </form>

					      </div>
					    
					    </div>
					  </div>
					</div>


            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <?php

			$uid = '1'; //for testing
			if (isset($_SESSION['uid'])) {
				$uid = $_SESSION['uid'];
			} else {
				header("Location: project.php");
			}
			

		?>
		
        <div id="page-content-wrapper" STYLE="background-image:url("backinfo.jpg");">
    			
            
        </div>

        <!-- /#page-content-wrapper -->
    </div>
    
    
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="project_general.js"></script>
  </body>
		<!-- Menu Toggle Script -->
<script>
	$("#menu-toggle").click(function(e) {
	    e.preventDefault();
	    $("#wrapper").toggleClass("toggled");
	});
</script>

<script>
	$("#searchInput").on("input", function() {
		var word = $(this).val();
		if (word.length == 0) {
			return;
		}
	    $('#page-content-wrapper').load('recipe_search_parse.php?word='+word);
	});
	$("#wrapper").css("min-height",$(window).height()-55);
</script>

</html>



