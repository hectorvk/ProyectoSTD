<?php

session_start();

$cookie_name = "idioma";

//Guardar o eliminar cookie
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['idioma']) && $_POST['idioma'] !== ""){
        $idioma = $_POST['idioma'];
        //Guardamos por 30 días
        setcookie($cookie_name, $idioma, time()+(30*24*60*60), "/");
        $_COOKIE[$cookie_name] = $idioma;//Actualiza el valor en tiempo de ejecución
    }elseif(isset($_POST['idioma']) && $_POST['idioma'] === ""){
        //Eminimanos la cookie
        setcookie($cookie_name, "", time() - 3600, "/");
        unset($_COOKIE[$cookie_name]);
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}



$valor_cookie = $_COOKIE[$cookie_name] ?? null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Stardew</title>
    <link rel="stylesheet" href="css/estilosProyectoStardew.css">
</head>
<body>
    <?php require("header.php");//incluimos el header con el menu de navegación?>

    <div class="login-container">
        <h1>Configuración de Cookies</h1>
        <?php if($valor_cookie): ?>
            <p>El idioma actual de la cookie es: <strong><?php echo htmlspecialchars($valor_cookie); ?></strong>
            <?php else: ?>
                <p>No hay cookie de idiomas establecida.</p>
            <?php endif; ?>

            <form method="post">
                <label>Selecciona un idioma:</label>
                <select name="idioma">
                    <option value="es" <?php if($valor_cookie==='es') echo "selected"; ?>>Español</option>
                    <option value="en" <?php if($valor_cookie==='en') echo "selected"; ?>>Inglés</option>
                    <option value="fr" <?php if($valor_cookie==='fr') echo "selected"; ?>>Francés</option>
                </select>
                <input type="submit" value="Guardar">
            </form>

            <?php if($valor_cookie): ?>
            <form method="post" style="margin-top:10px;">
                <input type="hidden" name="idioma" value="">
                <input type="submit" value="Eliminar cookie">
            </form>
            <?php endif; ?>
    </div>
    <?php require("footer.php");//Incluimos el footer ?>
</body>
</html>