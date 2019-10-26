<?php 
session_start();

include_once("includes/functions.php");
$flag = 0;  


if(isset($_POST['button_1'])){
  $errors = "";
  $succ =0;
  
    //taking input from user
    $formUsername=validateFormData($_POST['email1']);
    $formPassword=validatePassword($_POST['passw']);
    include_once("includes/connection.php");
    //fetching data from database
    $query="SELECT * from user where email='$formUsername'";
    $result=mysqli_query($conn,$query);
    

  if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
    $_SESSION['uid']  =$row['uid'];
        $_SESSION['username']=$row['email'];
        $pass=$row['pass'];
    
        
        //verify if the password matches the hashed password
        $loginsuccess = 0;

    
    if($_SESSION['username'] == 'admin@gmail.com')
    {
        $hashedPassword=base64_decode($pass);
        $loginsuccess = 1;

    }
    else
    {
      if(password_verify($formPassword,$pass)){
        $loginsuccess = 1;
      }
    }
        if($loginsuccess == 1){
            //login details are correct start the session
            //store the data in session variable
            
            $_SESSION['loggedInUser']=$row['name'];
            $_SESSION['loggedInEmail']=$row['email'];
            
    
     /* if($_SESSION['username'] == 'admin@gmail.com' || $_SESSION['username'] == 'member@gmail.com')
      {
        header("login.php");

      }
      else
        header("login.php");*/
        } //end of password verified
        //if password didn't match
        else{
        /*    $error="<div class='alert alert-danger'> Wrong username,password combination.
            <a class='close' data-dismiss='alert'>&times; </a></div>";*/
      echo "<script> alert('Incorrect Password') </script>";

      
        }//end of password didnot match
    }//end of num rows =1
    else{
    
      echo "<script> alert('Incorrect Username') </script>";

    }//end of 0 results fetched case
    
    mysqli_close($conn);
}

if(isset($_POST['button_2']))
{
  $result='';
$success=0;
$flag=0;


if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
  {
      $result= $result."Invalid Email<br>"; 
    $flag=1;
}


if(!empty($_POST['pass1']) && !empty($_POST['pass2']))
{
  if(strcmp($_POST['pass1'],$_POST['pass2'])!=0)
  {
    $result= $result."Passwords do not match , Please Re enter<br>"; 
    $flag=1;
  }
}



include_once("includes/connection.php");

  $uname=$_POST['name'];
  $uemail=$_POST['email'];
  $uloc=$_POST['loc'];
  $pass=$_POST['pass1'];
  
  if($uemail == 'admin@gmail.com')
  {
    $hashPassword = base64_encode($pass);
  }
  else
  {
    $options = array("cost"=>4);
    $hashPassword = password_hash($pass,PASSWORD_BCRYPT,$options);
  }
  $success=0; 

$sql="INSERT INTO user(name,email,loc,pass) values('$uname','$uemail','$uloc','$hashPassword')";
if(mysqli_query($conn,$sql)) {
  echo '<script> alert("Sign Up successful") </script>';
  $success=1;
}
else{ 
echo '<div class="error">'.mysqli_error($conn).'</div>';
//echo '<script> alert("Error, Try  again ") </script>';
}


if($success==1)
{
  header("Location:login.php");
}
}
?>

<!DOCTYPE HTML>
<html>
<head>

<title> Hack27 | Welcome </title>
 <meta charset = "utf-8">
 <meta name="viewport" content="width=device-width">
 
 
 </head>
    <body>
      <header>
        
         
       
        <form method="POST" >
              <input type="email" id="email1" name="email1" placeholder="Enter email..." required>
              <input type="password" id="passw" name="passw" placeholder="Enter password..." required>
              <button type="submit" class="button_1" name="button_1">Log In</button>
        </form>


       
      </header>


     

   <section id="signup">
              
       <div class="container"> 
            
            
           
            
      <form method="POST" >
              <br>

              
            <input type="name" id="name" name="name" placeholder="Enter name..." required><br>
            <input type="email" id="email" name="email" placeholder="Enter e-mail..." required> <br>
            <input type="text" id="loc" name="loc" placeholder="Enter the location..." required><br>
            <input type="password" id="pass1" name="pass1" placeholder="Enter password..." required><br>
            <input type="password" id="pass2" name="pass2" placeholder="Confirm password..." required><br><br>
            <button type="submit" class="button_2" name="button_2">Signup</button><br>
           </form>  
           </div>
     </section>  
       <footer>
      </footer> 
    </body>
        </html>
