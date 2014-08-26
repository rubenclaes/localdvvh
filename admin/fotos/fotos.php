<div class="hero-unit">      
    <ul class="nav nav-tabs">
        <li><a href="gebruikersgegevens"><span>Gebruikersgegevens</span></a></li>
        <li><a href="nieuws"><span>Voeg nieuws toe</span></a></li>
        <li><a href="artikels"><span>Nieuws & Reacties</span></a></li>
        <li><a href="gebruiker"><span>Beheer Gebruikers</span></a></li>
        <li><a href="repertoires"><span>Repertoire</span></a></li>
        <li><a href="?jaarprogramma"><span>Agenda</span></a></li>
        <li class="active"><a href="fotos"><span>Foto\'s</span></a></li>
    </ul>

    <form method="post" enctype="multipart/form-data">
        <label>naam fotoalbum :</label> <input type="text" name="fotoalbum" />
        <br>
        <label for="file">Afbeeldingen (.jpg):</label>
        <input type="file" name="file[]" id="file" multiple/> 
        <br>
        <input type="submit" name="submit" value="Upload" />
    </form>
    <?php
    if (isset($_POST['submit'])) {
        if (isset($_FILES["file"])) {
            mkdir('fotoalbums/' . $_POST['fotoalbum']);
            if (file_exists('fotoalbums/' . $_POST['fotoalbum'] . '/' . $_FILES["file"]["name"])) {
                echo '<p>bestand bestaat al!</p>';
            } else {
                $aantalBestanden = count($_FILES["file"]["name"]);
                for ($x = 0; $x < $aantalBestanden; $x++) {
                    $name = $_FILES["file"]["name"][$x];
                    $tmp_name = $_FILES["file"]["tmp_name"][$x];

                    move_uploaded_file($_FILES["file"]["tmp_name"][$x], 'fotoalbums/' . $_POST['fotoalbum'] . '/' . $_FILES["file"]["name"][$x]);
                    echo "Opgeslagen in: " . 'fotoalbums/' . $_POST['fotoalbum'] . '/' . $_FILES["file"]["name"];
                }
            }
        }
    }
    ?>
</div>
