<?php

session_name('ud1_13');
session_start();
//session_destroy();

if (!isset($_SESSION['albaran'])) {
    $_SESSION['albaran'] = [];
    $_SESSION['version'] = 1;

}else{
    $_SESSION['version'] += 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $referencia = $_POST['referencia'];
    $concepto = $_POST['concepto'];
    $unidades = $_POST['unidades'];
    $precio = $_POST['precio'];

    $agregar = $_POST["agregar"];

    if ( $agregar == "ok" ) {
        $_SESSION['albaran'][] = [
            'referencia' => $referencia,
            'concepto' => $concepto,
            'unidades' => $unidades,
            'precio_unidad' => $precio
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sumar = $_POST["sumar"];
    $restar = $_POST["restar"];
    $referencia = $_POST["referencia"];

    if($sumar == "ok"){
        foreach ($_SESSION['albaran'] as &$albaran) {
            if ($albaran['referencia'] === $referencia && $albaran['unidades'] >= 0) {
                $albaran['unidades'] ++;
            }
        }
    }elseif ($restar == "ok"){
        foreach ($_SESSION['albaran'] as &$albaran ) {
            if ($albaran['referencia'] === $referencia && $albaran['unidades'] > 0) {
                $albaran['unidades'] --;
            }
        }
    }

}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset']) && $_POST['reset'] == 'ok'){
    $_SESSION['albaran'] = [];

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $referencia = $_POST['referencia'];
    $accion = $_POST["accion"];

    if($accion == "eliminar"){
        foreach ($_SESSION['albaran'] as &$albaran) {
            if ($albaran['referencia'] == $referencia) {
                $albaran = null;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>generar</title>
    <style>
        table { border-collapse: collapse; width: 50%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>
<h2 style="text-align:center;">Listado de Productos</h2>

<a>El numero de version es: <?php echo $_SESSION['version']; ?></a>

<table>
    <tr>
        <th>Referencia</th>
        <th>Concepto</th>
        <th>Unidades</th>
        <th>Precio Unidad</th>
        <th>Precio Bruto</th>
        <th>Eliminar</th>
    </tr>
    <?php foreach ($_SESSION['albaran'] as $u): ?>
        <tr>
            <td><?= $u['referencia'] ?></td>
            <td><?= $u['concepto'] ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="referencia" value="<?= $u['referencia'] ?>">
                    <button type="submit" name="sumar" value="ok">+</button>
                </form>

                <?= $u['unidades'] ?>

                <form method="post">
                    <input type="hidden" name="referencia" value="<?= $u['referencia'] ?>">
                    <button type="submit" name="restar" value="ok">-</button>
                </form>

            </td>
            <td><?= $u['precio_unidad'] . "€" ?></td>
            <td>
                <?php
                echo $u['unidades'] * $u['precio_unidad']  . "€";
                ?>
            </td>
            <td>
                <form method="post">
                    <input type="hidden" name="referencia" value="<?= $u['referencia'] ?>">
                    <button type="submit" name="accion" value="eliminar">Eliminar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<table >
    <tr>

    </tr>
        <tr>
            <td>Unidades totales</td>
            <td>Bruto:</td>
            <td>Descuento:</td>
            <td>IVA:</td>
            <td>Neto:</td>
        </tr>
        <tr>
            <td>
                <?php

                $cantidada = 0;

                foreach ($_SESSION['albaran'] as $albaran) {
                    $cantidada += $albaran['unidades'];
                }

                echo $cantidada;
                ?>
            </td>
            <td>
                <?php
                $bruto = 0;

                foreach ($_SESSION['albaran'] as $u) {
                    $bruto += $u['precio_unidad'] * $u['unidades'];
                }

                echo $bruto . "€";
                ?>
            </td>
            <td>
                <?php
                $descuento = 0;

                if($bruto > 3000){
                    $descuento = $bruto * 20 / 100;
                    $tipo = 20;
                }elseif($bruto < 3000 && $bruto > 2000){
                    $descuento = $bruto * 10 / 100;
                    $tipo = 10;
                }

                echo "(" . $tipo . "%)";
                echo " ";
                echo "-" . $descuento . "€";

                ?>
            </td>
            <td>
                <?php

                $total = $bruto - $descuento;
                $iva = 0;

                $iva = $total * 21 / 100;

                echo $iva . "€";

                ?>
            </td>
            <td>
                <?php

                $neto = $total + $iva;
                echo $neto . "€";

                ?>
            </td>
        </tr>
</table>

<br>

<form method="post">

    <a>Referencia</a>
    <input type="text" name="referencia" minlength="1" required>

    <a>Concepto</a>
    <input type="text" name="concepto" minlength="1" required>

    <br><br>

    <a>Unidades</a>
    <input type="number" name="unidades" min="1" required>

    <a>precio</a>
    <input type="number" name="precio" required>

    <br><br>

    <button type="submit" name="agregar" value="ok">Añadir</button>

    <br><br>

</form>

<form method="post">
<button type="submit" name="reset" value="ok">Reset</button>
</form>

</body>
</html>