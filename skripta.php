<?php

if (isset($_POST['naslov']) && isset($_POST['kratkisadrzaj']) && isset($_POST['sadrzaj']) && isset($_POST['kategorija'])){
    $naslov=$_POST['naslov'];
    $kratkisadrzaj=$_POST['kratkisadrzaj'];
    $sadrzaj=$_POST['sadrzaj'];
    $kategorija=$_POST['kategorija'];
    $imeSlike = $_FILES["slika"]["name"];
    $tmpSlika = $_FILES["slika"]["tmp_name"];
    move_uploaded_file($tmpSlika, "slike/" . $imeSlike);
    $pathSlike = "slike/" . $imeSlike;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="https://assets.debate.com.mx/__export/1513187264000/sites/debate/arte/el-debate/apps/favicon.png_2040392579.png">
    <title><?php echo $naslov; ?></title>
</head>
<body>
    <header>
        <img src="https://assets.debate.com.mx/__export/1508771766000/sites/debate/arte/el-debate/logo-blanco.svg">
        <nav>
            <ul>
                <li><a href="index.html">HOME</a></li>
                <li><a href="#" class="active">MUNDO</a></li>
                <li><a href="unos.html">UNOS</a></li>
                <li><a href="administracija.html">ADMINISTRACIJA</a></li>
            </ul>
        </nav>
    </header>
    <section class="clanak">
        <h5 class="h6gore"><?php echo $kategorija; ?></h5>
        <h1><?php echo $naslov; ?></h1>
        <p><?php echo $kratkisadrzaj; ?></p>
    </section>
    <img src="<?php echo $pathSlike; ?>" class="slikaclanka">
    <section class="clanakdolje">
        <p><?php echo $sadrzaj; ?></p>
    </section>
    <footer>
        <div class="gore"></div>
        <div class="dolje">
            © Copyright EL DEBATE. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>