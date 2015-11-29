<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>category_list</title>

    
  </head>
  <body>


        <!-- Page Content -->
        <?php
			session_start();
			include("connection.php");
			if (isset($_SESSION['uid'])) {
				$uid = $_SESSION['uid'];
			} else {
				$uid = '-1';
			}
/*
			
*/
			$sql = "SELECT * FROM cuisines WHERE user_id= '".$uid."' ORDER BY cuisine_title DESC";
			$res = mysql_query($sql) or die(mysql_error());
		

			if (isset($_GET['cuisine_id'])) {
				$cuisine_id = (int)$_GET['cuisine_id'];
			} else {
				$cuisine_id = -1; //for empty results
				$sql = "SELECT * FROM cuisines WHERE user_id= '".$uid."' ORDER BY cuisine_title DESC";
				$res = mysql_query($sql) or die(mysql_error());

				while ($row = mysql_fetch_assoc($res)) {
					$cuisine_id = (int) $row['id'];
					break; //do not need to read more value
				}
			}

		?>

		<div class="container-fluid" >
            <div class="row">
                <div class="col-lg-12">
                    <h1>
                    	<?php
                    		$cuisine_title = "Recipes Titles Listing";
                    		$res = mysql_query($sql) or die(mysql_error());
           
                    		while ($row = mysql_fetch_assoc($res)) {
												$id = (int) $row['id'];
												if ($cuisine_id == $id) {
												$cuisine_title = $row['cuisine_title'];
												break;
								}
							}

							if (isset($_SESSION['search_word'])) {
								echo "Search Result:";
							} else {
								echo $cuisine_title;
								
							}
							
                    	?>
                    </h1>

                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="color:black;");">
						<?php
							$_SESSION['cuisine_id'] = $cuisine_id;
				
							
							$sql = "SELECT * FROM recipes WHERE cuisine_id= '".$cuisine_id."' ORDER BY title DESC";
							$res = mysql_query($sql) or die(mysql_error());

							if (isset($_SESSION['search_word'])) {
							
									$sql = "SELECT * FROM `recipes` r, `cuisines` c WHERE r.cuisine_id = c.id AND c.user_id = '".$uid."'";
									$res = mysql_query($sql) or die(mysql_error());
							}

		
							$recipes = "";

							$tmp = "";

							while ($row = mysql_fetch_assoc($res)) {
								$id = $row['id'];
								$title = $row['title'];
								$content = $row['content'];

								if (isset($_SESSION['search_word'])) {
									$word = $_SESSION['search_word'];
									$title_lower = strtolower($title);
									$content_lower = strtolower($content);

									$pos1 = strpos($title_lower, $word);
									$pos2 = strpos($content_lower, $word);

									if ($pos1===false && $pos2===false) {
										continue;
									}
								}

								$recipes .= "<div class=\"panel panel-default\">";
								$recipes .= "<div class=\"panel-heading\" role=\"tab\" id=\"".$id."\">";
								$recipes .= "<h4 class=\"panel-title\">";
								$recipes .= "<a class=\"collapsed\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse".$id."\" aria-expanded=\"false\" aria-controls=\"collapseThree\">";
								$recipes .= $title;
								$recipes .= "</a></h4></div>";

								$recipes .= "<div id=\"collapse".$id."\" class=\"panel-collapse collapse\" role=\"tabpanel\" aria-labelledby=\"headingThree\">";
								$recipes .= "<div id=\"recipecontent".$id."\" class=\"panel-body recipecontent\">";
								$recipes .= $content;
								$recipes .= "</div></div></div>";

								$tmp .= "<div class=\"modal fade\" id=\"recipesEditModal".$id."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">";
								$tmp .= "<div class=\"modal-dialog modal-lg\" \">";
								$tmp .= "<div class=\"modal-content\">";
								$tmp .= "<div class=\"modal-body\">";
								$tmp .= "<form action=\"recipe_edit_parse.php\" method=\"post\" class=\"form-horizontal\" role=\"form\">";
								$tmp .= "<div class=\"form-group\">";        
								$tmp .= "<label for=\"inputfn3\" class=\"col-sm-2 control-label\"  >Recipe Title</label>";
								$tmp .= "<div class=\"col-sm-10\">";
								$tmp .= "<div class=\"input-group\">";
								$tmp .= "<span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-folder-open\"></span></span>";
								$tmp .= "<input type=\"text\" class=\"form-control\" id=\"recipe_title".$id."\" value=\"".$title."\" name=\"title\">";
								
								$tmp .= "<div class=\"input-group\" style=\"display:none;\" > ";
								$tmp .= "<input type=\"text\" class=\"form-control\" id=\"recipe_id".$id."\" value=\"".$id."\" name=\"recipe_id\">";
								$tmp .= "</div>";
								
								$tmp .= "</div></div></div>";
								$tmp .= "<div class=\"form-group\">";
								$tmp .= "<label for=\"inputfn3\" class=\"col-sm-2 control-label\">Content</label>";
								$tmp .= "<div class=\"col-sm-10\">";
								$tmp .= "<div class=\"input-group\">";
								$tmp .= "<span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-inbox\"></span></span>";
								$tmp .= "<textarea class=\"form-control\" rows=\"20\" id=\"recipe_content".$id."\" name=\"content\" \">".$content."</textarea>";
								$tmp .= "</div></div></div>";
								$tmp .= "<div class=\"form-group\">";
								$tmp .= "<div class=\"col-sm-offset-2 col-sm-10\">";
								$tmp .= "<button type=\"submit\" value=\"save\" class=\"btn btn-primary recipe_btn\">Save Changes</button>";
								$tmp .= "<button type=\"button\" class=\"btn btn-danger recipe_btn\" onclick=\"deleteRecipe(".$id.")\" >Delete Recipe</button>";
								$tmp .= "<button type=\"button\" class=\"btn btn-default recipe_btn\" data-dismiss=\"modal\">Close</button>";
								$tmp .= "</div></div></form></div></div></div></div>";

							}

							echo $recipes;
							echo $tmp;

							
						?>


					  
					</div>
                    <a href="#menu-toggle" class="btn btn-warning" id="menu-toggle">Toggle Menu</a>

                    <?php
                    	if (!isset($_SESSION['search_word'])) {
                    		echo "<a href=\"#recipeCreateModal\" class=\"btn btn-primary\" id= \"btn_create_recipe\" data-toggle=\"modal\"  data-target=\"#recipeCreateModal\">Write New Recipe</a>";
                    		echo "<a href=\"cuisine_delete_parse.php?id=".$cuisine_id."\" class=\"btn btn-danger\" >Delete Cuisine</a>";
                    
                    	}
                    
	                    if (isset($_SESSION['search_word'])) {
							unset($_SESSION['search_word']);
						}
					?>

					<!-- Create Note Modal -->
					<div class="modal fade" id="recipeCreateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      
					      <div class="modal-body">
					        
					      	<form action="recipe_create_parse.php" method="post" class="form-horizontal" role="form">
				                <div class="form-group">
				                  <label for="recipe_title" class="col-sm-2 control-label">Recipe Title</label>
				                  <div class="col-sm-10">
				                    <div class="input-group">
				                      <span class="input-group-addon"><span class="glyphicon glyphicon-folder-open"></span></span>
				                      <input type="text" class="form-control" id="recipe_title" name="title" placeholder="recipe title" />
				                    </div>
				                  </div>
				                </div>

				                <div class="form-group">
				                  <label for="recipe_content" class="col-sm-2 control-label">recipe_content</label>
				                  <div class="col-sm-10">
				                    <div class="input-group">
				                      <span class="input-group-addon"><span class="glyphicon glyphicon-inbox"></span></span>
				                      <textarea class="form-control" rows="20" id="recipe_content" name="content" placeholder="recipe content"></textarea>
				                    </div>
				                  </div>
				                </div>

				                <div class="form-group" style="display:none;">
				                  <label for="recipe_cuisine" class="col-sm-2 control-label">Content</label>
				                  <div class="col-sm-10">
				                    <div class="input-group">
				                      <span class="input-group-addon"><span class="glyphicon glyphicon-inbox"></span></span>
				                      <input type="text" class="form-control" id="recipe_cuisine" name="recipe_cuisine" value="<?php echo $cuisine_id ?>" placeholder="recipe title">
				                    </div>
				                  </div>
				                </div>

				                <div class="form-group">
				                  <div class="col-sm-offset-2 col-sm-10">
				                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					        					<button type="submit" class="btn btn-primary">Save Changes</button>
				                  </div>
				                </div>
				            </form>

					      </div>
					    
					    </div>
					  </div>
					</div>


                </div>
            </div>

        </div>
        

    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    
  </body>
		<!-- Menu Toggle Script -->
	<script>
		$("#menu-toggle").click(function(e) {
		    e.preventDefault();
		    $("#wrapper").toggleClass("toggled");
		});


		$('.recipecontent').click(function(){
			var nid = $(this).attr('id');
			nid = nid.substring(13, nid.length);
			var modalID = "#recipesEditModal" + nid;
			$(modalID).modal('show');
		} );
		
		//getter
		var autoWidth = $( ".selector" ).accordion( "option", "autoWidth" );
		//setter
		$( ".selector" ).accordion( "option", "autoWidth", false );
	</script>

	<script>
		function deleteRecipe(recipeid) {
	      window.location = "recipe_delete_parse.php?id="+recipeid;
	       
	    }

	</script>

</html>


