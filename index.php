<?php
    session_start();
    require_once 'databaseConnection.php';
//     require_once 'sendMail.php';

    $fname=$lname=$email="";
    $fnameErr=$lnameErr=$emailErr=$vcodeErr=NULL;
    $firstname=$lastname=$emailid="";
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
        }
        else if(strlen($lname)<4)
        {
            $firstname=$fname;
            $lnameErr="Please enter valid first name";
            $emailid=$email;
        }
        else
        {
            // sanitizing data SQL injection
            $fname=$mysqli->real_escape_string($fname);
            $lname=$mysqli->real_escape_string($lname);
            $email=$mysqli->real_escape_string($email);
            $action="stop";
            $vkey=md5(time().$fname);
            //Checking already user or not
            $check=$mysqli->query("SELECT * FROM visitor_det WHERE email='$email'");
            if(mysqli_num_rows($check) == 0)
            {
                // echo"Success"; 
                $insert=$mysqli->query("INSERT INTO visitor_det(fname,lname,email,vkey,action)VALUES('$fname','$lname','$email','$vkey','$action')");
                if($insert){                    
                    $_SESSION['fname']=$fname;
                    $_SESSION['lname']=$lname;
                    SendMail($fname,$lname,$email,$vkey);
                }else{
                    echo"Mail not sent."; 
                }
            }else{
                echo"You are already register"; 
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
