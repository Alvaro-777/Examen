<?php
global $conceptos;
include 'datos.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Imprimir</title>
    <style>
        table { border-collapse: collapse; width: 50%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #eee; }
        a { text-decoration: none; color: blue; }
    </style>
</head>
<body>
<h2 style="text-align:center;">Listado de productos</h2>

<table>
    <tr>
        <th>Referencia</th>
        <th>Concepto</th>
        <th>Unidades</th>
        <th>Precio Unidad</th>
        <th>Precio Bruto</th>
    </tr>
    <?php foreach ($conceptos as $u): ?>
        <tr>
            <td><?= $u['referencia'] ?></td>
            <td><?= $u['concepto'] ?></td>
            <td><?= $u['unidades'] ?></td>
            <td><?= $u['precio_unidad'] ?></td>
            <td>
                <?php

                echo $u['unidades'] * $u['precio_unidad'];

                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<br>

<?php

    $unidades_totales = 0;
    $bruto = 0;
    $iva = 0;
    $neto = 0;
    $descuento = 0;
    $tipo = 0;

    foreach ($conceptos as $u) {
        $unidades_totales += $u['unidades'];
    }

    foreach ($conceptos as $u) {
        $bruto += $u['unidades'] * $u['precio_unidad'];
    }

    if($bruto > 3000){
        $descuento = $bruto * 20 / 100;
        $tipo = 20;
    }elseif($bruto < 3000 && $bruto > 2000){
        $descuento = $bruto * 10 / 100;
        $tipo = 10;
    }

    if($descuento != 0){
        $bruto = $bruto - $descuento;
    }

    $iva = $bruto * 21 / 100;

    $neto = $bruto + $iva;


    $neto = sprintf("%.2f", $neto);
    $descuento = sprintf("%.2f", $descuento);
    $iva = sprintf("%.2f", $iva);
    $bruto = sprintf("%.2f", $bruto);

    echo "<a>La cantidad de unidades totales es de: $unidades_totales</a>";
    echo "<br/>";
    echo "<a>Cantidad en bruto: $bruto</a>";
    echo "<br/>";
    echo "<a>Descuento ($tipo %) : $descuento</a>";
    echo "<br/>";
    echo "<a>Cantidad de iva en total: $iva</a>";
    echo "<br/>";
    echo "<a>Neto total: $neto</a>";

?>

</body>
</html>