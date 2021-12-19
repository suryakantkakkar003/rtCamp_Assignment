<?php
class AutoSendingMail{
    function SendMail($receiver,$urlImg){
        // Sending email
        // $to="fmc202158@zealeducation.com";
        $to=implode("",$receiver);
        $subject="XKCD Comics";
        $message="This is lovely XKCD comics picture.<br><img src=".$urlImg."><br><br><br><br><a href='https://sample-ps-website.herokuapp.com/unsubscribe.php'>
        Unsubscribe or change your email preferences.</a>";
        $sender = "From: sanapprasad2021@gmail.com\r\n";
        $sender .= "MIME-Version: 1.0"."\r\n";
        $sender .="Content-type:text/html;charset=UTF-8"."\r\n";
        mail($to,$subject,$message,$sender);
    }
}
// Development Connection
// $mysqli=NEW MySQLi('localhost','root','','rtcamp');

// Remote Database Connection
$mysqli=NEW MySQLi('remotemysql.com','4wBXWo57I5','In5xZmaTxC','4wBXWo57I5');
$asm=new AutoSendingMail();
$email=$mysqli->query("SELECT email FROM visitor_det WHERE action='start'");

// echo $email;
// $asm->SendMail('fmc202158@zealeducation.com');
// $query =$mysqli_query("SELECT email FROM visitor_det WHERE action='start'");


// set array
$array = array();
// look through query
while($row = mysqli_fetch_assoc($email)){
  // add each row returned into an array
  $array[] = $row;
}

// debug:
// print_r($array);

// Array length
// print_r ("<br>".count($array));

// Fatching the random image.
$no=rand(1,614);
$value=curl_init("https://xkcd.com/".$no."/info.0.json");
curl_setopt($value,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($value,CURLOPT_RETURNTRANSFER,true);
$result=curl_exec($value);
curl_close($value);
$data=json_decode($result);
echo $data->img;
$imgUrl=$data->img;


// Foreach array loop and send email to them.
foreach($array as $val){
    print_r($val);
    $asm->SendMail($val,$imgUrl);
}

?>
