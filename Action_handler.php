<?php
//require ('./admin/required_links.php');
require ('./admin/admin.php');
    
if (count($_POST)){
    
    
  while (list($key, $val) = each($_POST)){
      if(gettype($val)!="array")
    $$key=preg_replace('/[^A-Za-z0-9\-]/', '', $val);
      else
        $$key=$val;
   } 
 }

if (count($_GET)){
  while (list($key, $val) = each( $_GET )){
      if(gettype($val)!="array")
    $$key=preg_replace('/[^A-Za-z0-9\-]/', '', $val);
      else
        $$key=$val;  
   } 
 }

if($pageRequst_name=="category"){
    if($operation==1){
        //echo 'alert(yes)';
        $sql = "INSERT INTO category (category_type)
        VALUES ('$cateType')";  
        if ($connection->query($sql) === TRUE) {

        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }

    } 
    
    if($operation==2){
        
        $sql = "UPDATE category SET category_type='$cateTypeEdit' WHERE id='$idEdit'";
        if ($connection->query($sql) === TRUE) {
           // echo 'alert("Something Went Wrong.");';
          //  echo $idEdit." ".$cateTypeEdit;
        }else {
            
            echo "<script>alert('Something Went Wrong.');</script>";
        }
    }
    
     if($operation==3){
        
        $sql =  "DELETE FROM category WHERE id=('$id')";  
        if ($connection->query($sql) === TRUE) {
              echo "Category Deleted Successfully.";
            

        } else {
          //  echo "Error: " . $sql . "<br> Cant\'t Be Deleted You Must Delete All Related Books to This Category " . $connection->error;
            
          echo "Cant't Be Deleted You Must Delete All Related Books to This Category.";
            
        }

    }
}else 

if($pageRequst_name=="author"){
    if($operation==1){
       // echo 'alert(yes)';
        $sql = "INSERT INTO author (author_fname,author_lname)
        VALUES ('$author_fname','$author_lname')";  
        if ($connection->query($sql) === TRUE) {

        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }

    } 
    
    if($operation==2){
        
        $sql = "UPDATE author SET author_Fname='$editAuthorFname',author_lname='$editAuthorLname'  WHERE id='$idEdit'";
        if ($connection->query($sql) === TRUE) {
           // echo 'alert("Something Went Wrong.");';
          //  echo $idEdit." ".$cateTypeEdit;
        }else {
            
            echo "<script>alert('Something Went Wrong.');</script>";
        }
    }
    
     if($operation==3){
        
        $sql =  "DELETE FROM author WHERE id=('$id')";  
        if ($connection->query($sql) === TRUE) {
            echo "Author Deleted Successfully. ";
                 
        } else {
           // echo "Error: " . $sql . "<br> Cant't Be Deleted You Must Delete All Related Books to This Author" . $connection->error;
              echo "Cant't Be Deleted You Must Delete All Related Books to This Author.";
        }

    }
}
    if($pageRequst_name=="book"){
   
    if($operation==1){
    //    bookTitle
    //    author_id
    //    category_id
       // echo 'alert(yes)';
         $book_last_id=null;
      
        $sql = "INSERT INTO book (book_title,author_id)
        VALUES ('$bookTitle','$author_id');";  
            
            if ($connection->query($sql) === TRUE) {
                   $book_last_id= mysqli_insert_id($connection);
            } else {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }
          
        
        
        
         
        
        foreach ($category_id as $k => $v) {
            $sql = "INSERT INTO book_category (book_id,category_id)
            VALUES ('$book_last_id','$v')";  
            
            if ($connection->query($sql) === TRUE) {

            } else {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }
          
        }  
        
       

    } 
    
    if($operation==2){
       //editBookTitle
       //category_id
       //editSelect_author
        //idEdit
        $sql =  "DELETE FROM book_category WHERE book_id=".$idEdit.";";
       
        if ($connection->query($sql) === TRUE) {

        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
        
        foreach ($category_id as $k => $v) {
            $sql = "INSERT INTO book_category (book_id,category_id)
            VALUES ('$idEdit','$v')";  
            
            if ($connection->query($sql) === TRUE) {

            } else {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }
          
        } 
        $sql =  "UPDATE book SET book_title='$editBookTitle', author_id ='$editSelect_author' WHERE id='$idEdit'";
       
        if ($connection->query($sql) === TRUE) {

        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }
    
     if($operation==3){
        
        $sql1 =  "DELETE FROM book_category WHERE book_id=".$id.";";
        $sql2="DELETE FROM book WHERE id=".$id.";";  
        if ($connection->query($sql1) === TRUE && $connection->query($sql2) === TRUE) {
                echo "Book Deleted Successfully. ";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }

    }
}
?>
