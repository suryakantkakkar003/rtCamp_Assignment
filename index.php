<?php
  session_start();     
  $fname=$lname=$email="";
  $fnameErr=$lnameErr=$emailErr=$vcodeErr=NULL;
  $firstname=$lastname=$emailid="";
  $error=Null;
 if(isset($_POST['sendCode'])){
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    if(strlen($fname)<4){
      $fnameErr="Please enter valid first name";
      $lastname=$lname;
      $emailid=$email;
    }else
    if(strlen($lname)<4){
      $firstname=$fname;
      $lnameErr="Please enter valid first name";
      $emailid=$email;
    }else{
      // connect database
      // $mysqli=NEW MySQLi('localhost','root','','rtcamp');
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
      if(mysqli_num_rows($check)!=0){
        $firstname=$fname;
        $lastname=$lname;
        $emailErr="You are already resiter!";
      }else{

        //Inserting element
        $insert=$mysqli->query("INSERT INTO visitor_det(fname,lname,email,vkey,action)VALUES('$fname','$lname','$email','$vkey','$action')");
        
        if($insert){
          // $detail=array($fname,$lname,$email,$vkey);
          // $_SESSION['arr'] = $detail;
  
          $_SESSION['fname']=$fname;
          $_SESSION['lname']=$lname;
          // echo "<p>SUCCESS</p>";
          // Sending email
          $to=$email;
          $subject="Email Verification";
          $message="<h5>Hey $fname $lname, you're almost ready to start enjoing<strong> XKCD Comics.</strong>Simply verify your email address.</h5><h3>Verification Key:<br>$vkey</h3><br><br><br><h5>Thank you...!<h5>";
          $sender ="From: sanapprasad2021@gmail.com\r\n";
          $sender .="MIME-Version: 1.0"."\r\n";
          $sender .="Content-type:text/html;charset=UTF-8"."\r\n";
          mail($to,$subject,$message,$sender);
          header('location:thankyou.php');
        }else{
          echo $mysqli->error;
      }
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="./style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script>
  <title>rtCamp Asssignment</title>

</head>

<body>
  <div class="container">
    <section class="h-100 gradient-form" style="background-color: #eee;">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-xl-10">
            <div class="card rounded-3 text-black">
              <div class="row g-0">
                <div class="col-lg-6">
                  <div class="card-body p-md-5 mx-md-4">

                    <div class="text-center">
                      <img src="./rtCamp1.png" style="width: 185px;border-radius:50%" alt="logo">
                      <h4 class="mt-1 mb-5 pb-1">Good Work. Good People.</h4>
                    </div>

                    <form action="" method="post">
                      <div class="mb-3  <?php echo (!empty($fnameErr)) ? 'has-error' : ''; ?>">
                        <label class="form-label">First Name</label>

                        <input type="text" class="form-control" name="fname"
                          oninput="this.value = this.value.replace(/[^A-Za-z.]/g, '').replace(/(\..*)\./g, '$1');"
                          placeholder="Enter first name" value="<?php echo $firstname;?>" required>
                        <span class="help-block">
                          <?php echo $fnameErr;?>
                        </span>
                      </div>

                      <div class="mb-3  <?php echo (!empty($fnameErr)) ? 'has-error' : ''; ?>">
                        <label class="form-label">Last Name</label>

                        <input type="text" class="form-control" name="lname"
                          oninput="this.value = this.value.replace(/[^A-Za-z.]/g, '').replace(/(\..*)\./g, '$1');"
                          placeholder="Enter last name" value="<?php echo $lastname;?>" required>
                        <span class="help-block">
                          <?php echo $lnameErr;?>
                        </span>
                      </div>

                      <div class="mb-3  <?php echo (!empty($fnameErr)) ? 'has-error' : ''; ?>">
                        <label class="form-label">Email</label>

                        <input type="email" class="form-control" name="email" placeholder="Enter email" value="<?php echo $emailid;?>" required>
                        <span class="help-block">
                          <?php echo $emailErr;?>
                        </span>
                      </div>
                      <div class="text-center pt-1 mb-5 pb-1">
                      <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" name="sendCode">Send
                          Verification Code</button>
                      </div>
                    </form>


                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                  <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                    <h4 class="mb-4">We are more than just a company</h4>
                    <p class="small mb-0">We deliver enterprise-grade web publishing and digital commerce solutions
                      using WordPress.<br>
                      <br>
                      <br>
                      <br>
                      "Partnering with rtCamp was key to the success of our project. Their WordPress ecosystem insights,
                      engineering expertise, user focus, and super high-quality output were the perfect combination to
                      compliment our efforts on building Web Stories Embedding features."
                      <br>
                      <br>
                      <br>
                     
                      — Alberto Medina, Developer Relations, Google
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
</body>

</html>