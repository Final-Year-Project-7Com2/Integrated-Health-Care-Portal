<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/animations.css">  
<link rel="stylesheet" href="../css/main.css">  
<link rel="stylesheet" href="../css/admin.css">
        
<title>Appointments</title>
<style>
.popup{
animation: transitionIn-Y-bottom 0.5s;
}
.sub-table{
animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php
session_start();

if(isset($_SESSION["user"])){
if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
header("location: ../login.php");
}else{
$useremail=$_SESSION["user"];
        }

 }else{
        header("location: ../login.php");
    }
   include("../connection.php");
$sqlmain= "select * from patient where pemail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s",$useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["pid"];
$username=$userfetch["pname"];

$sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid  where  patient.pid=$userid ";

    if($_POST){
       if(!empty($_POST["sheduledate"])){
$sheduledate=$_POST["sheduledate"];
$sqlmain.=" and schedule.scheduledate='$sheduledate' ";
};           
}
$sqlmain.="order by appointment.appodate  asc";
$result= $database->query($sqlmain);
?>
<div class="container">
<div class="menu">
<table class="menu-container" border="0">
<tr>
<td style="padding:10px" colspan="2">
<table border="0" class="profile-container">
<tr>
<td width="30%" style="padding-left:20px" >
<img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
</td>
<td style="padding:0px;margin:0px;">
<p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
<p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
</td>
</tr>
<tr>
<td colspan="2">
<a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
</td>
</tr>
</table>
</td>
</tr>
<tr class="menu-row" >
<td class="menu-btn menu-icon-home" >
<a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
</td>
</tr>
<tr class="menu-row">
<td class="menu-btn menu-icon-doctor">
<a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></a></div>
</td>
</tr>
 <tr class="menu-row" >
<td class="menu-btn menu-icon-session">
<a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
</td>
</tr>
<tr class="menu-row" >
<td class="menu-btn menu-icon-appoinment  menu-active menu-icon-appoinment-active">
<a href="appointment.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">My Bookings</p></a></div>
</td>
</tr>
<tr class="menu-row" >
<td class="menu-btn menu-icon-settings">
<a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
</td>
</tr>
 </table>
</div>
<div class="dash-body">
<table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
<tr >
<td width="13%" >
                    <a href="appointment.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
</td>
<td>
<p style="font-size: 23px;padding-left:12px;font-weight: 600;">My Bookings history</p>
</td>
<td width="15%">
<p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
Today's Date
</p>
<p class="heading-sub12" style="padding: 0;margin: 0;">
<?php 

date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');
echo $today;
?>
</p>
</td>
<td width="10%">
<button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
</td>
</tr>
               
<!-- <tr>
<td colspan="4" >
<div style="display: flex;margin-top: 40px;">
<div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Schedule a Session</div>
                        <a href="?action=add-session&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Session</font></button>
</a>
</div>
</td>
</tr> -->
<tr>
<td colspan="4" style="padding-top:10px;width: 100%;" >
                    
<p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">My Bookings (<?php echo $result->num_rows; ?>)</p>
</td>
</tr>
<tr>
<td colspan="4" style="padding-top:0px;width: 100%;" >
<center>
<table class="filter-container" border="0" >
<tr>
<td width="10%">
</td> 
<td width="5%" style="text-align: center;">
Date:
</td>
<td width="30%">
<form action="" method="post">
                            
<input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">

</td>
<td width="12%">
<input type="submit"  name="filter" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
</form>
</td>

</tr>
</table>
</center>
</td>
                    
</tr>
                
               
                  
<tr>
<td colspan="4">
<center>
<div class="abc scroll">
<table width="93%" class="sub-table scrolldown" border="0" style="border:none">
<tbody>
