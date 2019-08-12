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
require ('./admin/required_links.php');
require ('./admin/admin.php');
?>
<!DOCTYPE html>
<html>

<head>
    

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>Task</title>
     <script>
         function validating(obj){
                 // alert($(obj).attr('id'));
            if ($(obj).val() != ""){
                  $(obj).removeClass("is-invalid ").addClass("is-valid");
              }else {
                $(obj).addClass("is-invalid ");
                  }
              }
        var pageRequst_name_retrive="book";
        function retrive_data(){ // retrive data function
         var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                 //   alert(this.responseText);   
                  document.getElementById("AddContent").innerHTML = this.responseText;
                    
                }
            };
            xhttp.open("GET", "data_retriver.php?pageRequst_name_retrive="+pageRequst_name_retrive, true);
            xhttp.send();   
        }
         function retrive_data_one_time(){ // retrive data function
         var xhttp;
         
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   data= JSON.parse(this.responseText);
                       //alert(this.responseText);
                    // alert(data);
                    data[0].forEach(function(entry){
                        
                       $("#select_author").append(entry); 
                    });
                    data[1].forEach(function(entry){
                        
                       $("#select_category").append(entry); 
                    });
                    
                }
            };
            xhttp.open("GET", "data_retriver.php?retrive_data_once=1&pageRequst_name_retrive="+pageRequst_name_retrive, true);
            xhttp.send();   
        }
         
        
        function retrive_data_one_row(id){ // retrive one data function
         var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  //  $("#editSelect_author").empty(); 
                  //  $("#editSelect_category").empty(); 
                    //alert(this.responseText);
                  data= JSON.parse(this.responseText);
                      // alert(this.responseText);
                     //alert(data);
                    data[0].forEach(function(entry){
                        
                       $("#editSelect_author").append(entry); 
                      //  alert(entry);
                    });
                    data[1].forEach(function(entry){
                        
                       $("#editSelect_category").append(entry); 
                    });
                     $("#editBookTitle").val(data[2]);
                    
                }
            };
            xhttp.open("GET", "data_retriver.php?query_type=one_row&book_id="+id+"&pageRequst_name_retrive="+pageRequst_name_retrive , true);
            xhttp.send();   
        }
        
        function show_modal(id){    //show_modal for edit function
           // alert(id);
            retrive_data_one_row(id);
            $("#EditModal_hidden_id").val(id);
            $("#EditModal").modal('show');
            $("#EditModal").focus();
            
           
        }
               

        
        function sav_Update_Del(operation_val, val) {

            $("#operation").value = operation_val;
            if (operation_val == 1 && $("#bookTitle").val() !="" && $("#select_author").val() !="" && $("#select_category").val() !="") {
              //var  d= $("#select_category").val();
                 //  alert( d[1]);
                $.post("Action_handler.php", {
                        operation: operation_val,
                        pageRequst_name: "book",
                        bookTitle: $("#bookTitle").val(),
                        author_id: $("#select_author").val(),
                        category_id: $("#select_category").val()

                    },
                    function(data, status) {
                        $("#addNewValue").modal('hide');
                        $(".modal-backdrop").remove();
                        $("#addNewValue").focus();
                        $("#bookTitle").val("");
                        validating($("#bookTitle"));
                        $("#select_author").val("");
                        $("#select_category").val("non");
                        $( "#select_author" ).val("non");
                        $("#select_author").removeClass("is-valid ").addClass("is-invalid");
                        $("#select_category").removeClass("is-valid ").addClass("is-invalid");
                        retrive_data();
                        
                       // alert(data+" "+ status);
                    });
            }

            if (operation_val == 2 && $("#editBookTitle").val() !="" && $("#editSelect_author").val() !="" && $("#editSelect_category").val() !="") {
                //    alert($("#cateTypeEdit").val());
                $.post("Action_handler.php", {
                        operation: operation_val,
                        pageRequst_name: "book",
                        editBookTitle: $("#editBookTitle").val(),
                        category_id: $("#editSelect_category").val(), 
                        editSelect_author: $("#editSelect_author").val(), 
                        idEdit : val

                    },
                    function(data, status) {
                        $("#EditModal").modal('hide');
                        $(".modal-backdrop").remove();
                      $('#EditModal').focus();
                      //alert(data +" "+status);
                     retrive_data();
                      
                    });
            }

            if (operation_val == 3) {
                var sure = confirm("Are You Sure ?");
                if (sure == true) {
                    $.post("Action_handler.php", {
                        id: val,
                        operation: operation_val,
                        pageRequst_name: "book",
                       
                    }, function(data, status) {
                        alert(data);
                        retrive_data();
                      
                    });
                }
            }
            
          
               
        }
      retrive_data(); 
      retrive_data_one_time();

    </script>
</head>

<body>
    <br>
    <div class="container">
        <h2 style="color:#6c8389">Books</h2>
        <div class="row justify-content-end">
            <div class="col-sm-12 col-md-4 col-lg-4 ">

                <button type="button" class="btn btn-primary" style=" width:100%" data-toggle="modal" data-target="#addNewValue">Add</button>
            </div>
        </div>
        <div class="modal " id="addNewValue">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Book</h4>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> <!-- form start-->
                            <div class="form-group">
                                <label for="bookTitle">Title: </label>
                                <input type="text" class="form-control is-invalid" id="bookTitle" name="bookTitle" onkeyup="validating(this)" required>
                            </div>
                            <div class="form-group">
                                <label for="select_author">Author</label>
                                <select class="form-control is-invalid" id="select_author" name="select_author" onchange="validating(this)" required>
                                    <option value="non" disabled selected>None</option>
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="select_category">Category</label>
                                <select multiple class="form-control is-invalid" id="select_category" name="select_category" onchange="validating(this)" required>
                                     <option value="non" disabled selected>None</option>
                                </select>
                            </div>
                        </form> <!-- form end-->
                    </div>
                    <!-- Modal footer --> 
                    <div class="modal-footer  justify-content-start">
                         <button type="button" class="btn btn-success" style="width:100%" onclick="sav_Update_Del(1,this.value);" value="0">Save</button>
                        <button type="button" class="btn btn-danger" style="width:100%" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-hover" style="text-align:center;   margin-top:6%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead >
            <tbody id="AddContent">

                
            </tbody>
        </table>
    </div>
    <div class="modal " id="EditModal">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Category</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> <!-- form start-->
                            <div class="form-group">
                                <label for="editBookTitle">Title: </label>
                                <input type="text" class="form-control is-valid" id="editBookTitle"  name="editBookTitle" onkeyup="validating(this)" required>
                            </div>
                            <div class="form-group">
                                <label for="editSelect_author">Author</label>
                                <select class="form-control is-valid" id="editSelect_author" name="editSelect_author" onchange="validating(this)" required>
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editSelect_category">Category</label>
                                <select multiple class="form-control is-valid" id="editSelect_category" name="editSelect_category" onchange="validating(this)" required>
                                    
                                </select>
                            </div>
                        </form><!-- form end-->
                </div>
                <!-- Modal footer -->
                <div class="modal-footer  justify-content-start">
                    <button type="button" class="btn btn-success" name="EditModal_hidden_id" id="EditModal_hidden_id" style="width:100%" onclick="sav_Update_Del(2,this.value);" value="0">Save</button>
                    <button type="button" class="btn btn-danger" style="width:100%" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    

</body>

</html>
