<?php
session_start();
$_SESSION['period'] = $_GET['p'];
header('Location: index.html');
?>