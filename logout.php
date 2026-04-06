<?php
session_start(); // Pehle session kholo
session_unset(); // Uske saare variables khali karo
session_destroy(); // Us pass ko aag laga do
header("Location: login.php"); // Wapas login page par bhej do
exit();
?>