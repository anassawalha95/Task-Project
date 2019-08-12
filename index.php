<?php
if (count($_POST)){
  while (list($key, $val) = each($_POST)){
     $$key=$val;
   } 
 }

if (count($_GET)){
  while (list($key, $val) = each($_GET)){
    $$key=$val;
   } 
 }

?>
<!DOCTYPE html>
<html>

<head>
    <?php
require ('./admin/required_links.php');
    
?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task</title>
    <style>
        #nav li :hover {
            background-color: #007bff;
            color: white;
        }

    </style>
    
<script>
$( document ).ready(function() {
     var modal = $('#welcome_modal');
    modal.fadeIn();
    $('#content').load("./book.php");
    
});

 function loadPage(pageName){
     $('#content').load(pageName);
     
    }

</script>
</head>

<body>
    <div class="container">
        <ul id="nav" class="nav nav-pills" role="tablist" style="text-align:center;">
            <li class="nav-item  " style="width:33%">
                <a class="nav-link active"  data-toggle="pill" onclick="loadPage('./book.php');" href="#">Book</a>
            </li>
            <li class="nav-item" style="width:33%">
                <a class="nav-link "   data-toggle="pill" onclick="loadPage('./author.php');" href="#">Author</a>
            </li>

            <li class="nav-item" style="width:33%">
                <a class="nav-link "  data-toggle="pill" onclick="loadPage('./category.php');" href="#">Category</a>
            </li>
        </ul>
    </div>

    <div class="modal " id="welcome_modal"> 
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                
             
                <div class="modal-body" style="text-align:center">
                    <p> Welcome to Our Humble Library Feel Free to Explore It. </p>
                </div>

                
                
                    <button type="button" class="btn btn-primary" onclick="$('#welcome_modal').fadeOut()">Close</button>
                

            </div>
        </div>
    </div>
<div id="content">
    
  </div>
    
    
</body>

</html>
