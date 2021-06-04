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
                <li><a href="administracija.html">ADMINISTRACIJA</a></li>
                <li><a href="registracija.html" class="active">REGISTRACIJA</a></li>
            </ul>
        </nav>
    </header>


<?php
include 'connect.php';

if ($_POST['ime'] != '' && $_POST['prezime'] != '' && $_POST['korisnicko_ime'] != '' && $_POST['lozinka'] != ''){
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = $_POST['lozinka'];
    $hashed_password = password_hash($lozinka, CRYPT_BLOWFISH);
    $razina = 0;
    $registriranKorisnik = '';

    $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $korisnicko_ime);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }
    if(mysqli_stmt_num_rows($stmt) > 0){
        $msg='Korisničko ime već postoji!';
    }else {
        $sql = "INSERT INTO korisnik (ime, prezime,korisnicko_ime, lozinka,
        razina)VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssssd', $ime, $prezime, $korisnicko_ime,
            $hashed_password, $razina);
            mysqli_stmt_execute($stmt);
            $registriranKorisnik = true;
        }
    }
}
mysqli_close($dbc);

if($registriranKorisnik == true) {
    echo "<section class='clanak'>
    <h1 style='padding-top:50px;'>Korisnik je uspješno registriran!</h1>
    </section>";
} else {
?>
    <form method='POST' class="form">
        <label for='ime'>Ime:</label>
        <br>
        <input type='text' id='ime' name='ime' class='input2'>
        <br>
        <span id='porukaIme'></span><br>
        <label for='prezime'>Prezime:</label>
        <br>
        <input type='text' id='prezime' name='prezime' class='input2'>
        <br>
        <span id='porukaPrezime'></span><br>
        <label for='korisnicko_ime'>Korisničko ime:</label>
        <br>
        <input type='text' id='korisnicko_ime' name='korisnicko_ime' class='input2'>
        <br>
        <?php echo '<span>'.$msg.'</span><br>'; ?>
        <span id='porukaKorisnicko_ime'></span><br>
        <label for='lozinka'>Lozinka:</label>
        <br>
        <input type='password' id='lozinka' name='lozinka' class='input2'>
        <br>
        <span id='porukaLozinka'></span><br>
        <label for='ponlozinka'>Ponovite lozinku:</label>
        <br>
        <input type='password' id='ponlozinka' name='ponlozinka' class='input2'>
        <br>
        <span id='porukaLozinka2'></span><br>
        <input type='reset' value='Poništi'>
        <input type='submit' id='registracija' value='Registriraj se'>
    </form>
    <section></section>
    <footer style='position: absolute; bottom: 0; width:100%;'>
        <div class='gore'></div>
        <div class='dolje'>
            © Copyright EL DEBATE. Todos los derechos reservados.
        </div>
    </footer>
</body>
<script type="text/javascript">
    document.getElementById("registracija").onclick = function(event) {
        var slanjeForme = true;
    
        var poljeIme = document.getElementById("ime");
        var ime = document.getElementById("ime").value;
        if (ime.length == 0) {
            slanjeForme = false;
            poljeIme.style.border="1px solid red";
            document.getElementById("porukaIme").innerHTML="Unesite ime!<br>";
        }

        var poljePrezime = document.getElementById("prezime");
        var prezime = document.getElementById("prezime").value;
        if (prezime.length == 0) {
            slanjeForme = false;
            poljePrezime.style.border="1px solid red";
            document.getElementById("porukaPrezime").innerHTML="Unesite Prezime!<br>";
        }
    
        var poljeKorisnicko_ime = document.getElementById("korisnicko_ime");
        var korisnicko_ime = document.getElementById("korisnicko_ime").value;
        if (korisnicko_ime.length == 0) {
            slanjeForme = false;
            poljeKorisnicko_ime.style.border="1px solid red";
            document.getElementById("porukaKorisnicko_ime").innerHTML="Unesite korisničko ime!<br>";
        }
    
        var poljeLozinka = document.getElementById("lozinka");
        var lozinka = document.getElementById("lozinka").value;
        var poljePonLozinka = document.getElementById("ponlozinka");
        var ponlozinka = document.getElementById("ponlozinka").value;
        if (lozinka.length == 0 || ponlozinka.length == 0 || lozinka != ponlozinka) {
            slanjeForme = false;
            poljeLozinka.style.border="1px solid red";
            poljePonLozinka.style.border="1px solid red";
            document.getElementById("porukaLozinka").innerHTML="Lozinke nisu iste!<br>";
            document.getElementById("porukaLozinka2").innerHTML="Lozinke nisu iste!<br>";
        }
    
        if (slanjeForme != true) {
            event.preventDefault();
        }
    };
</script>
<?php } ?>

<section></section>
<footer style='position: absolute; bottom: 0; width:100%;'>
    <div class='gore'></div>
    <div class='dolje'>
        © Copyright EL DEBATE. Todos los derechos reservados.
    </div>
</footer>