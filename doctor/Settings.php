<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/animations.css">
<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/admin.css">
<title>Settings</title>
<style>
.dashbord-tables
  {
  animation: transitionIn-Y-over 0.5s;
}
.filter-container
  {
  animation: transitionIn-X 0.5s;
}
.sub-table
  {
  animation: transitionIn-Y-bottom 0.5s;
}
</style>
</head>
<body>
<?php
session_start();
if(isset($_SESSION["user"])){
  if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d')
  {
    header("location: ../login.php");
  }
  else
  {
    $useremail=$_SESSION["user"];
  }
}else
{
  header("location: ../login.php");
}
include("../connection.php");
$userrow = $database->query("select * from doctor where docemail='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["docid"];
$username=$userfetch["docname"];
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
<p class="profile-title"><?php echo substr($username,0,13) ?></p>
<p class="profile-subtitle"><?php echo substr($useremail,0,22) ?></p>
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
<td class="menu-btn menu-icon-dashbord" >
<a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></a></div></a>
</td>
</tr>
<tr class="menu-row">
<td class="menu-btn menu-icon-appoinment">
<a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Appointments</p></a></div>
</td>
</tr>
<tr class="menu-row" >
<td class="menu-btn menu-icon-session">
<a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></a></div>
</td>
</tr>
<tr class="menu-row" >
<td class="menu-btn menu-icon-patient">
<a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">My Patients</p></a></div>
</td>
</tr>
<tr class="menu-row" >
<td class="menu-btn menu-icon-settings menu-active menu-icon-settings-active">
<a href="settings.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Settings</p></a></div>
</td>
</tr>
</table>
</div>
