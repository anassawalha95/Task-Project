<?php 
       
require ('./admin/admin.php');
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
if(isset($pageRequst_name_retrive) && $pageRequst_name_retrive=="category"){  //category db functions starts

if(isset($query_type) && $query_type=="one_row")
    
{
   // die("im in");
$sql = "SELECT *  FROM category where id=".$cat_id;
$result = $connection->query($sql);
    if ($result->num_rows > 0) {
     while($row = $result->fetch_assoc()) {
       //  echo  $row["id"];
         echo  $row["category_type"];
     }
    }     
}
else{
    
    

$sql = "SELECT *  FROM category";
$result = $connection->query($sql);

if ($result->num_rows > 0) {    
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"]. "</td> <td>" . $row["category_type"]. "</td> 
        <td><button type='button' class='btn btn-primary' style='width:100%' onclick='show_modal(this.value)' value=".$row['id']." >Edit</button> </td>
        <td><button type='button' class='btn btn-danger' style='width:90%' onclick='sav_Update_Del(3,this.value);' value= ".$row['id']." >Delete</button></td></tr>";
            }
        }   
    }
} //author db functions ends
else if(isset($pageRequst_name_retrive) && $pageRequst_name_retrive=="author"){ //author db functions starts
    if(isset($query_type) && $query_type=="one_row")
    
{
   //die("im in");
$sql = "SELECT *  FROM author where id=".$author_id;
$result = $connection->query($sql);
    if ($result->num_rows > 0) {
     while($row = $result->fetch_assoc()) {
       //  echo  $row["id"];
         $data=array($row["id"],$row["author_fname"],$row["author_lname"]);
         $data=json_encode($data);
         echo  $data;
        // echo  $row["id"];
        // echo $row["author_fname"];
        // echo $row["author_lname"];
        // 
     }
    }     
}
else{
    
    

$sql = "SELECT *  FROM author";
$result = $connection->query($sql);

if ($result->num_rows > 0) {    
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"]. "</td> <td>" . $row["author_fname"]. "</td> <td>". $row["author_lname"]."</td>
        <td><button type='button' class='btn btn-primary' style='width:100%' onclick='show_modal(this.value)' value=".$row['id']." >Edit</button> </td>
        <td><button type='button' class='btn btn-danger' style='width:90%' onclick='sav_Update_Del(3,this.value);' value= ".$row['id']." >Delete</button></td></tr>";
            }
        }   
    }
    
    
    
} //author db functions ends
else if(isset($pageRequst_name_retrive) && $pageRequst_name_retrive=="book"){  //book db functions starts
    if(isset($query_type) && $query_type=="one_row"){
$author_data=array();
$category_data=array();
$book_data=array(); 
$all_data=array();
$author_id=0;
$category_id=array();
$counter=0;
$sql = "select all B.id as book_id , B.book_title , B.author_id , A.id as author_id, A.author_fname, A.author_lname, C.id as category_id, C.category_type FROM book as B INNER JOIN author as A ON B.author_id =A.id INNER JOIN book_category AS B_C on B.id=B_C.book_id INNER JOIN category AS C on C.id=B_C.category_id HAVING B.id=".$book_id;
        
 $result = $connection->query($sql);
if ($result->num_rows > 0) {    
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $book_data[0]=$row["book_title"];
      $author_id=$row["author_id"];
        $category_id[$counter]=$row["category_id"];
        ++$counter;
            }
        }   
        


        
 $counter=0;       
$sql = "SELECT *  FROM author";
$result = $connection->query($sql);
if ($result->num_rows > 0) {    
    // output data of each row
    while($row = $result->fetch_assoc()) {
     if($author_id == $row["id"]){
      $author_data[$counter]="<option value=".$row["id"]." selected >" . $row["author_lname"]. ",". $row["author_fname"]."</option>";
        ++$counter;}
        else{
            $author_data[$counter]="<option value=".$row["id"]."  >" . $row["author_lname"]. ",". $row["author_fname"]."</option>";
        ++$counter;}
        
            }
        }   
    

$counter=0;
$sql = "SELECT *  FROM category";
$result = $connection->query($sql);
if ($result->num_rows > 0) {    
    // output data of each row
    while($row = $result->fetch_assoc()) {
           if(in_array( $row["id"],$category_id)){
      $category_data[$counter]="   <option value=".$row["id"]." selected>" . $row["category_type"]. "   </option>";
        ++$counter;}
        else{
            
      $category_data[$counter]="   <option value=".$row["id"]." >" . $row["category_type"]. "   </option>";
        ++$counter;
         
        }
            }
        } 
    
    $all_data[0]=$author_data;
    $all_data[1]=$category_data;
    $all_data[2]=$book_data;
   // $all_data=array($all_data[0]=$author_data,$all_data[1]);
  //  echo $all_data;
     $all_data=json_encode($all_data);
   echo $all_data; 
}
else
    
    
if(isset($retrive_data_once ) && $retrive_data_once ==1 ){

$author_data=array();
$category_data=array();
$book_data=array(); 
$all_data=array();
$counter=0;
$sql = "SELECT *  FROM author";
$result = $connection->query($sql);
if ($result->num_rows > 0) {    
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $author_data[$counter]="<option value=".$row["id"]." >" . $row["author_lname"]. ",". $row["author_fname"]."</option>";
        ++$counter;
            }
        }   
    

$counter=0;
$sql = "SELECT *  FROM category";
$result = $connection->query($sql);
if ($result->num_rows > 0) {    
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $category_data[$counter]="   <option value=".$row["id"].">" . $row["category_type"]. "   </option>";
        ++$counter;
            }
        } 
    
    $all_data[0]=$author_data;
    $all_data[1]=$category_data;
   // $all_data=array($all_data[0]=$author_data,$all_data[1]);
  //  echo $all_data;
     $all_data=json_encode($all_data);
   echo $all_data;
    
    }  else{ 
    
    
    
   $sql = "select B.id as book_id ,
	   B.book_title ,
       B.author_id ,
       A.id as author_id,
       A.author_fname,
       A.author_lname,
       C.id as category_id,
       GROUP_CONCAT(C.category_type SEPARATOR ', ') as category_type
       FROM book  as B INNER JOIN author as A ON  B.author_id =A.id 
       	               INNER JOIN book_category AS B_C on B.id=B_C.book_id
                       INNER JOIN category AS C on C.id=B_C.category_id
         GROUP BY b.id";
 
    
    $result = $connection->query($sql);
    
if ($result->num_rows > 0) {    
    // output data of each row

    while($row = $result->fetch_assoc()) {
         
      echo   "<tr><td>". $row["book_id"]. "</td>
                  <td>" . $row["book_title"]. "</td>
                  <td>" . $row["author_fname"] ." ". $row["author_lname"]. "</td> 
                  <td>" . $row["category_type"] . "    </td> 
                  <td><button type='button' class='btn btn-primary' style='width:100%' onclick='show_modal(this.value)' value=".$row["book_id"]." >Edit</button> </td>
                  <td><button type='button' class='btn btn-danger' style='width:90%' onclick='sav_Update_Del(3,this.value);' value= ".$row['book_id']." >Delete</button></td>  </tr>";
            }
    
        }   
}
} //book db functions ends

             

?>