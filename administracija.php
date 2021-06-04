<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="https://assets.debate.com.mx/__export/1513187264000/sites/debate/arte/el-debate/apps/favicon.png_2040392579.png">
    <title>El Debate</title>
</head>

<body>
    <header>
        <img src="https://assets.debate.com.mx/__export/1508771766000/sites/debate/arte/el-debate/logo-blanco.svg">
        <nav>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="kategorija.php?id=politika">POLITIKA</a></li>
                <li><a href="kategorija.php?id=sport">SPORT</a></li>
                <li><a href="unos.html">UNOS</a></li>
                <li><a href="administracija.html" class="active">ADMINISTRACIJA</a></li>
                <li><a href="registracija.html">REGISTRACIJA</a></li>
            </ul>
        </nav>
    </header>

<?php
session_start();
include 'connect.php';
define('UPLPATH', 'slike/');

if (isset($_POST['prijava'])) {
    $loginKorisnik = $_POST['korisnicko_ime'];
    $loginLozinka = $_POST['lozinka'];
    $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik
    WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $loginKorisnik);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }
    mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
    mysqli_stmt_fetch($stmt);
    if (password_verify($_POST['lozinka'], $lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['$uspjesnaPrijava'] = true;
        if($levelKorisnika == 1) {
            $_SESSION['$admin'] = true;
        } else {
            $_SESSION['$admin'] = false;
        }
        $_SESSION['$username'] = $imeKorisnika;
        $_SESSION['$level'] = $levelKorisnika;
    } else {
        $_SESSION['$uspjesnaPrijava'] = false;
    }
}
   
if(isset($_POST['delete'])) {
    $id=$_POST['id'];
    $query = "DELETE FROM vijest WHERE id=$id ";
    $result = mysqli_query($dbc, $query);
}
if(isset($_POST['update'])){
    $slika = $_FILES['slika']['name'];
    $naslov=$_POST['naslov'];
    $sazetak=$_POST['kratkisadrzaj'];
    $sadrzaj=$_POST['sadrzaj'];
    $kategorija=$_POST['kategorija'];
    if(isset($_POST['arhiva'])){
     $arhiva=1;
    }else{
     $arhiva=0;
    }
    $dir = 'slike/'.$slika;
    move_uploaded_file($_FILES["slika"]["tmp_name"], $dir);
    $id=$_POST['id'];
    $query = "UPDATE vijest SET naslov='$naslov', sazetak='$sazetak', sadrzaj='$sadrzaj',
    slika='$slika', kategorija='$kategorija', arhiva='$arhiva' WHERE id=$id ";
    $result = mysqli_query($dbc, $query);
}

if (($_SESSION['$uspjesnaPrijava'] == true && $_SESSION['$admin'] == true) || (isset($_SESSION['$username'])) && $_SESSION['$level'] == 1) {
    $query = "SELECT * FROM vijest";
    $result = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_array($result)) {
        echo '<form enctype="multipart/form-data" method="POST">
        <label for="naslov">Naslov vjesti:</label><br>
        <input type="text" name="naslov" class="input" value="' . $row['naslov'] . '"><br>
        <label for="kratkisadrzaj">Kratki sadržaj vijesti (do 50 znakova):</label><br>
        <textarea name="kratkisadrzaj" rows="10">' . $row['sazetak'] . '</textarea><br>
        <label for="sadrzaj">Sadržaj vijesti:</label><br>
        <textarea name="sadrzaj" rows="10">' . $row['sadrzaj'] . '</textarea><br>
        <label for="slika">Slika:</label>
        <input type="file" name="slika"/> <br><img src="' . UPLPATH . 
        $row['slika'] . '" width=150px><br><br>
        <label for="kategorija">Kategorija:</label>
        <select name="kategorija">
            <option value="politika"';
            if ($row['kategorija'] == 'politika') {
                echo 'selected="selected"';
            }
            echo '>Politika</option>
            <option value="sport"';
            if ($row['kategorija'] == 'sport') {
                echo 'selected="selected"';
            }
            echo '>Sport</option>
        </select><br>
        <label>Spremiti u arhivu:';
        if ($row['arhiva'] == 0) {
            echo '<input type="checkbox" name="archive" id="archive"/>Arhiviraj?';
        } else {
            echo '<input type="checkbox" name="archive" id="archive" checked/> Arhiviraj?';
        }
        echo ' </label><br><br>
        <input type="hidden" name="id" value="' . $row['id'] . '">
        <button type="reset" value="Poništi">Poništi</button>
        <button name="update" value="Prihvati">Izmjeni</button>
        <button name="delete" value="Izbriši">Izbriši</button>
        </form>
        <hr>';
    } 
 } else if ($_SESSION['$uspjesnaPrijava'] == true && $_SESSION['$admin'] == false) {
   echo "<section class='clanak'>
    <h1 style='padding-top:50px;'>Bok " . $imeKorisnika . "! Uspješno ste prijavljeni, ali niste administrator.</h1>
    </section>";
 } else if (isset($_SESSION['$username']) && $_SESSION['$level'] == 0) {
    echo "<section class='clanak'>
    <h1 style='padding-top:50px;'>Bok " . $_SESSION['$username'] . "! Uspješno ste prijavljeni, ali niste administrator.</h1>
    </section>";
 } else if ($_SESSION['$uspjesnaPrijava'] == false) {
?>
<form method="POST" class="form">
    <label for="korisnicko_ime">Korisničko ime:</label>
    <br>
    <input type="text" id="korisnicko_ime" name="korisnicko_ime" class="input2">
    <br>
    <span id="porukaKorisnicko_ime"></span><br>
    <label for="lozinka">Lozinka:</label>
    <br>
    <input type="password" id="lozinka" name="lozinka" class="input2">
    <br>
    <span id="porukaLozinka"></span><br>
    <input type="reset" value="Poništi">
    <input type="submit" id="prijava" name="prijava" value="Prijavi se">
</form>
<script type="text/javascript">
    document.getElementById("prijava").onclick = function(event) {
        var slanjeForme = true;

        var poljeKorisnicko_ime = document.getElementById("korisnicko_ime");
        var korisnicko_ime = document.getElementById("korisnicko_ime").value;
        if (korisnicko_ime.length == 0) {
            slanjeForme = false;
            poljeKorisnicko_ime.style.border="1px solid red";
            document.getElementById("porukaKorisnicko_ime").innerHTML="Unesite korisničko ime!<br>";
        }

        var poljeLozinka = document.getElementById("lozinka");
        var lozinka = document.getElementById("lozinka").value;
        if (lozinka.length == 0 || ponlozinka.length == 0 || lozinka != ponlozinka) {
            slanjeForme = false;
            poljeLozinka.style.border="1px solid red";
            document.getElementById("porukaLozinka").innerHTML="Unesite lozinku!<br>";
        }

        if (slanjeForme != true) {
            event.preventDefault();
        }
    };
</script>

<?php } ?>
    <section></section>
    <footer>
        <div class="gore"></div>
        <div class="dolje">
            © Copyright EL DEBATE. Todos los derechos reservados.
        </div>
    </footer>
</body>

</html>