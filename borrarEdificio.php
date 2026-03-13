<?php
require('hasLoginProyectoStardew.php');
require('hasAdminProyectoStardew.php');
require('DBProyectoStardew.php');

if(!isset($_GET['id'])) die("Falta ID");
$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM edificios WHERE id=:id");
$stmt->bindParam(':id',$id);
$stmt->execute();
header("Location: edificios.php");
exit();