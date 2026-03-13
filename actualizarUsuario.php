<?php
    require("hasLoginProyectoStardew.php");
    require("DBProyectoStardew.php");

    if(!isset($_SESSION["user_id"])){
        header("Location: loginProyectoStardew.php");
        exit();
    }
    //Verificamos admin
    $stmt = $conn->prepare("SELECT rol FROM usuarios WHERE id = :id");
    $stmt->bindParam(":id", $_SESSION["user_id"]);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    if($admin['rol'] !== 'admin'){ exit ("No eres admin");}

    //Obtenemos los datos del post
    $id = $_POST['id'] ?? null;
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $experiencia = trim($_POST['experiencia'] ?? '');
    $rol = trim($_POST['rol'] ?? 'normal');
    $nuevoPass = $_POST['newPass'] ?? '';
    $confirmPass = $_POST['confirmPass'] ?? '';

    //Validacion
    if(!$id || strlen($username) < 3 || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        exit("Datos no válidos");
    }

    //Obtenemos usuario a editar
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$user){
        exit("Usuario no encontrado");
    }

    // Evitamos que el admin se cambie a sí mismo de rol
    if($id == $_SESSION["user_id"]){
        $rol = $user['rol'];
    }

    // Verificamos que el username o email no estén repetidos en otros usuarios
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE (username = :username OR email = :email) AND id != :id");
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        exit("El username o email ya existe en otro usuario");
    }

    //Si se da una nueva contraseña la tenemos que hashear
    $updateQuery = "UPDATE usuarios SET username = :username, email = :email,
    nombre = :nombre, experiencia = :experiencia, rol = :rol";

    //Validamos la nueva contraseña
    if(!empty($nuevoPass)){
        if(strlen($nuevoPass) < 6){
            exit("LA contraseña debe tener al menos 6 caracteres");
        }
        if($nuevoPass !== $confirmPass){
            exit("Las contraseñas no coinciden");
        }
        $hash = password_hash($nuevoPass, PASSWORD_DEFAULT);
        $updateQuery .= ", password = :password";//Concatenamos
    }
    
    $updateQuery .= " WHERE id = :id";
   
    $update = $conn->prepare($updateQuery);
    $update->bindParam(":username", $username);
    $update->bindParam(":email", $email);
    $update->bindParam(":nombre", $nombre);
    $update->bindParam(":experiencia", $experiencia);
    $update->bindParam(":rol", $rol);
    $update->bindParam(":id", $id, PDO::PARAM_INT);

    if(!empty($nuevoPass)){
        $update->bindParam(":password", $hash);
    }

    $update->execute();

    header("Location: adminUsuarios.php");
    exit();
?>