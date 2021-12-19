<?php
  session_start();
//   require_once "dbconnection.php";      
  $fname=$lname=$email="";
  $fnameErr=$lnameErr=$emailErr=$vcodeErr=NULL;
  $firstname=$lastname=$emailid="";
  $error=Null;
 if(isset($_POST['sendCode']))
 { 
  $fname=$_POST['fname'];
  $lname=$_POST['lname'];
  $email=$_POST['email'];
  if(strlen($fname)<4)
  {
    $fnameErr="Please enter valid first name";
    $lastname=$lname;
    $emailid=$email;
  }else
  if(strlen($lname)<4)
  {
    $firstname=$fname;
    $lnameErr="Please enter valid first name";
    $emailid=$email;
  }
  else
  {
// Development Connection
// $mysqli=NEW MySQLi('localhost','root','','rtcamp');

// Remote Database Connection
$mysqli=NEW MySQLi('remotemysql.com','4wBXWo57I5','In5xZmaTxC','4wBXWo57I5');
    // sanitizing data SQL injection
    $fname=$mysqli->real_escape_string($fname);
    $lname=$mysqli->real_escape_string($lname);
    $email=$mysqli->real_escape_string($email);
    $action="stop";
    // Generate key
    $vkey=md5(time().$fname);
    //Checking already user or not
    $check=$mysqli->query("SELECT * FROM visitor_det WHERE email='$email'");
    if(mysqli_num_rows($check) == 0)
    {     
      //Inserting element
      $insert=$mysqli->query("INSERT INTO visitor_det(fname,lname,email,vkey,action)VALUES('$fname','$lname','$email','$vkey','$action')");
      if($insert)
      {
        // $detail=array($fname,$lname,$email,$vkey);
        // $_SESSION['arr'] = $detail;

        $_SESSION['fname']=$fname;
        $_SESSION['lname']=$lname;
        // echo "<p>SUCCESS</p>";
        // Sending email
        $to=$email;
        $subject="Email Verification";
        $message="<h5>Hey $fname $lname, you're almost ready to start enjoing<strong> XKCD Comics.</strong>Simply verify your email address.</h5><br><br><br><h3>Verification Key:<br>$vkey</h3><br><br><br><h5>Thank you.</h5>";
        $sender ="From: sanapprasad2021@gmail.com\r\n";
        $sender .="MIME-Version: 1.0"."\r\n";
        $sender .="Content-type:text/html;charset=UTF-8"."\r\n";
        mail($to,$subject,$message,$sender);
        header('location:thankyou.php');
      }
      else
      {
        echo $mysqli->error;
      }
    }
    else
    {
      $firstname=$fname;
      $lastname=$lname;
      $emailErr="You are already resiter!";
    }
  }    
}
 

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>rtCamp Asssignment</title>

</head>

<body>
<form action="" method="post">
        <table>
            <tr>
                <th colspan="2">
                <h4>XKCD Comics</h4>
                </th>
            </tr>
            <tr>
                <th>
                    <div>
                    <label>First Name</label>
                    </div> 
                </th>
                <th>
                    <input type="text"  name="fname" oninput="this.value = this.value.replace(/[^A-Za-z.]/g, '').replace(/(\..*)\./g, '$1');"
                    placeholder="Enter first name" value="<?php echo $firstname;?>" required>
                </th>
                <th>
                    <span>
                        <?php echo $fnameErr;?>
                    </span>
                </th>
            </tr>
            <tr>
                <th>
                    <div>
                    <label>Last Name</label>
                    </div> 
                </th>
                <th>
                    <input type="text"  name="lname" oninput="this.value = this.value.replace(/[^A-Za-z.]/g, '').replace(/(\..*)\./g, '$1');"
                    placeholder="Enter last name" value="<?php echo $lastname;?>" required>
                </th>
                <th>
                    <span>
                      <?php echo $lnameErr;?>
                    </span>
                </th>
            </tr>
            <tr>
                <th>
                    <div>
                    <label>Email ID</label>
                    </div> 
                </th>
                <th>
                    <input type="email"name="email" placeholder="Enter your email id" value="<?php echo $emailid;?>" required>
                </th>
                <th>
                    <span>
                      <?php echo $emailErr;?>
                    </span>
                </th>
            </tr>
          
            <tr>
                <td colspan="3">
                <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" name="sendCode">Send
                          Verification Code</button>
                </td>
            </tr>
        </table>        
    </form>
  
</body>

</html>
