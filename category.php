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
    <?php
require ('./admin/required_links.php');
require ('./admin/admin.php');
?>

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
                                      
        var pageRequst_name_retrive="category";
        function retrive_data(){ // retrive data function
         var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //alert(this.response);
                    document.getElementById("AddContent").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "data_retriver.php?pageRequst_name_retrive="+pageRequst_name_retrive, true);
            xhttp.send();   
        }
        
        function retrive_data_one_row(id){ // retrive one data function
         var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                 //   alert(this.responseText);
                    $("#cateTypeEdit").val(this.responseText);
                }
            };
            xhttp.open("GET", "data_retriver.php?query_type=one_row&cat_id="+id+"&pageRequst_name_retrive="+pageRequst_name_retrive , true);
            xhttp.send();   
        }
        
        function show_modal(id){    //show_modal for edit function
          //  alert(id);
            retrive_data_one_row(id);
            $("#EditModal_hidden_id").val(id);
            $("#EditModal").modal('show');
            $("#EditModal").focus();
            
           
        }
               
        
        
        function sav_Update_Del(operation_val, val) {
            $("#operation").value = operation_val;
            if($("#cateType").val() !="" && operation_val == 1 ){
        
        
                $.post("Action_handler.php", {
                        operation: operation_val,
                        pageRequst_name: "category",
                        cateType: $("#cateType").val()

                    },
                    function(data, status) {
                        $("#addNewValue").modal('hide');
                        $(".modal-backdrop").remove();
                        $("#addNewValue").focus();
                        $("#cateType").val("");
                       
                        validating($("#cateType"));
                        retrive_data();
                        
                        //alert(data+" "+ status);
                    });
            
        }
            if($("#cateTypeEdit").val() !="" && operation_val == 2 ){
         
                //    alert($("#cateTypeEdit").val());
                $.post("Action_handler.php", {
                        operation: operation_val,
                        pageRequst_name: "category",
                        cateTypeEdit: $("#cateTypeEdit").val(),
                        idEdit : val

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
                        pageRequst_name: "category",
                        
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
        <h2 style="color:#6c8389">Categories</h2>
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
                        <h4 class="modal-title">Add New Category</h4>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="main_form" method="post" action="#"  class="needs-validation" novalidate>
                            <!-- form start-->
                            <div class="form-group">
                                <label for="cateType">Category Type</label>
                                <input type="text"  class="form-control is-invalid" id="cateType" onkeyup="validating(this)" name="cateType" value="" required>
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
                    <th>Category Type</th>
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
                    <h4 class="modal-title">Edit Category</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="#" >
                        <!-- form start-->
                        <div class="form-group">
                            <label for="cateTypeEdit">Category Type</label>
                            <input type="text" value="" class="form-control is-valid" id="cateTypeEdit" name="cateTypeEdit" onkeyup="validating(this)" required>

                        </div>

                    </form> <!-- form end-->
                </div>
                <!-- Modal footer -->
                <div class="modal-footer  justify-content-start">
                    <button type="button" class="btn btn-success" name="EditModal_hidden_id" id="EditModal_hidden_id"  style="width:100%" onclick="sav_Update_Del(2,this.value);" value="0">Save</button>
                    <button type="button" class="btn btn-danger" style="width:100%" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>
