<?php
$servername='localhost';
   $username='root';
   $password='';
   $dbname = "controldb";
   $conn=mysqli_connect($servername,$username,$password,"$dbname");
   if(!$conn){
      die('Could not Connect My Sql:' .mysql_error());
   }
// print_r($_POST);die();
if (isset($_POST['time']) &&$_POST['time']==0 && $_POST['timer']>120) {
    mysqli_query($conn,"UPDATE control set control_status=0 WHERE userid='" . $_POST['userid'] . "'"); 
    echo json_encode(array('success' => 1,'data'=>$_POST));
}
if(isset($_POST['getcontrol'])){
	mysqli_query($conn,"UPDATE control set control_status=1 WHERE userid='" . $_POST['userid'] . "'"); 
    echo json_encode(array('success' => 1));
}
?>