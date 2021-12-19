<?php
session_start();
$vkeyErr="";
if(isset($_POST['verify']))
{      
  $vkey  = $_POST['vkey'];
  // connect database
  $mysqli=NEW MySQLi('localhost','root','','rtcamp');
  // Checking verification key.
  $query =$mysqli->query("SELECT `vkey` FROM `visitor_det`WHERE '$vkey' IN (`vkey`) LIMIT 1;");

  if (mysqli_num_rows($query) == 1){
    // sanitizing data SQL injection              
    $vkey=$mysqli->real_escape_string($vkey);
    // updating data values.
    $update=$mysqli->query("UPDATE visitor_det SET verified=1,action='start' WHERE vkey='$vkey'");
    if($update){
      echo "Thanks";
      header('Location:index.php');
    }
  }else{
    $vkeyErr="You enter wrong verification key.";
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
            <h2>XKCD Comics</h2>
          </th>
        </tr>
        <tr>
          <th colspan="2">
            <h3><strong>Thank you..!</strong></h3>
          </th>
        </tr>
        <tr>
          <th colspan="2">
            <?php
              echo "<p class='text-primary display-3 text-wrap fw-bold'> ---" . $_SESSION['fname']." ". $_SESSION['lname'].  "---</p>";
            ?>
          </th>
        </tr>
        <tr>
          <th>
            Enter Verification Code
          </th>
          <td>
            <input type="text" class="form-control" name="vkey" placeholder="Enter your verification code here..." required>
          </td>
          <td>
            <span class="help-block">
                <?php echo $vkeyErr;?>
            </span>
          </td>
        </tr>
        <tr>
          <th colspan="2">
            <p>Please click OK for complete your account setup.</p>
          </th>
        </tr>
        <tr>
          <th colspan="2">
            <button type="submit" name="verify">OK</button>
          </th>
        </tr>
      </table>
    </form>
    
<?php
// remove all session variables
session_unset();

// destroy the session
session_destroy();
?>

  </body>
</html>
