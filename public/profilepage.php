<?php
session_start();
include("./../server/connection.php");
include("./../server/functions.php");

//$user_data = check_login($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <!-- Includi lo stile CSS qui -->
    <link rel="stylesheet" href="./../templates/styles/header.css">
    <link rel="stylesheet" href="./../templates/styles/footer.css">
    <!--css della pagina-->
    <!--api-->

</head>
<body>

    <?php include ('./../templates/header.html'); ?>

        <!-- Contenuto della pagina -->
        <main>
            <h1>Benvenuto su My Website!</h1>
            <p>Qui ci sarà tutto il contenuto interessante della tua pagina.</p>
        </main>

        <!-- Includi lo script JavaScript qui -->
        <!--script src="script.js"--></script>


    <?php include ('./../templates/footer.html'); ?>

</body>
</html>

