<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $referencia = $_POST['referencia'];
    $accion = $_POST["accion"];

    if ($accion == "eliminar") {

        foreach ($_SESSION['albaran'] as &$albaran) {
            if ($albaran['referencia'] == $referencia) {
                $albaran = null;
            }
        }

    }
}


header('Location: generar.php');
exit;