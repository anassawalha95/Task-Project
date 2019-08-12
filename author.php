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
require ('./admin/admin.php');
?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        var pageRequst_name_retrive = "author";

        function retrive_data() { // retrive data function
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    
                    document.getElementById("AddContent").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "data_retriver.php?pageRequst_name_retrive=" + pageRequst_name_retrive, true);
            xhttp.send();
        }
        
        function retrive_data_one_row(id){ // retrive one data function
        var data;
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // alert(this.responseText);
                     data= JSON.parse(this.responseText);
                   
                   $("#editAuthorFname").val(data[1]);
                    $("#editAuthorLname").val(data[2]);
                }
            };
            xhttp.open("GET", "data_retriver.php?query_type=one_row&author_id="+id+"&pageRequst_name_retrive="+pageRequst_name_retrive , true);
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
            if($("#authorFname").val() !="" && $("#authorLname").val() !="" && operation_val == 1 ){
            
                $.post("Action_handler.php", {
                        operation: operation_val,
                        pageRequst_name: "author",
                        author_fname: $("#authorFname").val(),
                        author_lname: $("#authorLname").val()


                    },
                    function(data, status) {
                        $("#addNewValue").modal('hide');
                        $(".modal-backdrop").remove();
                        $("#addNewValue").focus();
                        $("#authorFname").val("");
                        $("#authorLname").val("");
                        validating($("#authorFname"));
                        validating($("#authorLname"));
                         retrive_data();
                    
                    });
                    
            }
           
           if($("#editAuthorFname").val() !="" && $("#editAuthorLname").val() !="" && operation_val == 2 ){
                  $.post("Action_handler.php", {
                        operation: operation_val,
                        pageRequst_name: "author",
                        editAuthorFname: $("#editAuthorFname").val(),
                        editAuthorLname:  $("#editAuthorLname").val() ,
                        idEdit: val

                    },
                    function(data, status) {
                        $("#EditModal").modal('hide');
                        $(".modal-backdrop").remove();
                        $('#EditModal').focus();
                        // alert(data +" "+status);
                      retrive_data();
                    });
            }

            if (operation_val == 3) {
                var sure = confirm("Are You Sure ?");
                if (sure == true) {
                    $.post("Action_handler.php", {
                        id: val,
                        operation: operation_val,
                        pageRequst_name: "author",

                    },
                    function(data, status) {
                      
                         alert(data);
                      retrive_data();
                    });
                }
            }


            
        }
        retrive_data();

    </script>
</head>

<body>
    <div class="container">
        <br>
        <h2 style="color:#6c8389">Authors</h2>
        <div class="row justify-content-end">
            <div class="col-sm-12 col-md-4 col-lg-4">

                <button type="button" class="btn btn-primary" style=" width:100%" data-toggle="modal" data-target="#addNewValue">Add</button>
            </div>
        </div>
        <div class="modal " id="addNewValue">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Author</h4>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="main_form" method="post" action="#">
                            <!-- form start-->
                            <div class="form-group">
                                <label for="authorFname">Author Frist Name </label>
                                <input type="text" class="form-control is-invalid" id="authorFname" name="authorFname" onkeyup="validating(this)" required>
                            </div>
                            <div class="form-group">
                                <label for="authorLname">Author Last Name</label>
                                <input type="text" class="form-control is-invalid" id="authorLname" name="authorLname" onkeyup="validating(this)" required>
                            </div>
                            <input type="hidden" value="0" name="operation" id="operation">
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
                    <th>Author Frist Name</th>
                    <th>Author Last Name</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody id="AddContent">

            </tbody>
        </table>
    </div>
    <div class="modal " id="EditModal">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Author</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="#">
                        <!-- form start-->
                        <div class="form-group">
                            <label for="editAuthorFname">Author Frist Name </label>
                            <input type="text" class="form-control is-valid" id="editAuthorFname" name="editAuthorFname" onkeyup="validating(this)" required>
                        </div>
                        <div class="form-group">
                            <label for="editAuthorLname">Author Last Name</label>
                            <input type="text" class="form-control is-valid" id="editAuthorLname" name="editAuthorLname" onkeyup="validating(this)" required>
                        </div>

                    </form> <!-- form end-->
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
