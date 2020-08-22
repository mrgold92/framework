<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Error</title>
</head>

<body>
<div id="error-page" class="container">
    <div class="row">
        <div class="col-12 col"><a href="/">Volver a inicio</a></div>
        <div class="col">
            <h1 class="text-center">ERROR</h1>
            <?php

            if (isset($data["error"])) {

                echo "<p class='text-center'>" . $data['error'] . "</p>";
            } else {
                echo "<p class='text-center'>La página que solicita no ha sido encontrada.</p>";
            }
            ?>


        </div>
    </div>
</div>
</body>
</html>
