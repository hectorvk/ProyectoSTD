<?php
//Carga el idioma a través de los otros archivods
$idioma = $_COOKIE['idioma'] ?? 'es';

switch($idioma){
    case 'en':
        $lang = include("lang_en.php");
        break;
    case 'fr':
        $lang = include("lang_fr.php");
        break;
    default:
        $lang = include("lang_es.php");
        break;
}
?>