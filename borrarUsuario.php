<?php
require("hasLoginProyectoStardew.php");
require("DBProyectoStardew.php");

if(!isset($_SESSION["user_id"])){
    header("Location: loginProyectoStardew.php");
    exit();
}

//Verificamos si es admin
$stmt = $conn->prepare("SELECT rol FROM usuarios WHERE id = :id");
$stmt->bindParam(":id", $_SESSION["user_id"]);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user["rol" !== "admin"]){
    exit("No eres un admin");
}

//Obtener id de usuario a borrar
$id = $_GET["id"] ?? null;

if($id){
    //Evitamos que el admin se borre a si mismo
    if($id == $_SESSION["user_id"]){
        exit("No puedes borrarte a ti mismo");
    }

    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->bindPARAM(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
}

header("Location: adminUsuarios.php");
exit();
?>