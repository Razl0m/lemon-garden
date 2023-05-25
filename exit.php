<?
session_start();
if (!isset($_SESSION["role"])) {
	$_SESSION["role"] = 0;
} else {
   $_SESSION["role"] = 0;
}
header("Location: /index.php");