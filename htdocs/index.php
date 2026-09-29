<?php 

//HIPANAO SOLUTIONS

require_once("include/initialize.php");
   if (!isset($_SESSION['UID'])){
      redirect(WEB_ROOT."login.php");
 //   header("Location: login.php");

     }else{
      
     } 

// HIPANAO SOLUTIONS
// Route each account to its own dashboard based on tblusers.TYPE.
// Doctor accounts land on the Doctor Dashboard; every other type
// (Administrator, Staff, etc.) keeps using the default dashboard.
$userType = isset($_SESSION['TYPE']) ? $_SESSION['TYPE'] : '';

if ($userType == 'Doctor') {
    $title   = "Doctor Dashboard";
    $content = 'home-doctor.php';
} else {
    $title   = "Home";
    $content = 'home.php';
}

$view = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : '';
switch ($view) {
  case '1' :
     // Explicit request for the default dashboard view.
     $title="Home"; 
     $content='home.php'; 
    
    break;  
  default :
    // Keep the role-based $title/$content chosen above.
    break;
}
require_once("theme/loader.php");
?>

