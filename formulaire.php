<?php





echo'<form action="formulaire.php" method="post">';

echo'<p>';
        echo'<label for="nom">nom:</label>';
        echo' <input type="text" name="nom" />';
        echo'<label for="prenom">prenom:</label>';
        echo' <input type="text" name="prenom"/>';
        echo'<label for="classe">classe:</label>';
        echo'<input type="text" name="classe">';
        echo' <label for="matiere">matiere:</label>';
        echo' <input type="text" name="matiere"/>';
        echo' <label for="note">note:</label>';
        echo'  <input type="number" name="note" max="20">';
        echo' <label for="coefficient">coefficient:</label>';
        echo'  <input type="number" name="coefficient">';
        echo'  <input type="submit" value="envoyer" id="envoyer" name="envoyer"/>';
   echo' </p>';

echo'</form>';

if (!empty($_POST['envoyer'])) {
    //connection a la base de donnée
    $serveur = "localhost:3306";
    $dbname = "prise_de_note";
    $user = "root";
    $pass = "test";
    //recuperation du fomulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $classe = $_POST["classe"];
    $note   = $_POST["note"];
    $coefficient = $_POST["coefficient"];
    $matiere = $_POST["matiere"];
    $matiere = $_POST["matiere"];
    //envoie a la base de donnée
        $dbc = mysqli_connect($serveur,$user,$pass,$dbname);
        $dbco = new PDO("mysql:host=$serveur;dbname=$dbname", $user, $pass);
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $reqev =$dbco->query("SELECT COUNT(*) FROM etudiant WHERE nom_etudiant= '$nom'and prenom_etudiant= '$prenom' and classe_etudiant='$classe' ");
        $query= mysqli_fetch_array(mysqli_query($dbc,"SELECT count(*) FROM etudiant WHERE nom_etudiant= '$nom'and prenom_etudiant= '$prenom' and classe_etudiant='$classe' "))[0];
            if($query>=1){
            $reqne = mysqli_fetch_array(mysqli_query($dbc,"SELECT num_etudiant FROM etudiant WHERE nom_etudiant= '$nom'and prenom_etudiant= '$prenom' and classe_etudiant='$classe' "))[0];

            }else{
        //envoie dans la table etudiant
        $reqe = $dbco->prepare("
                INSERT INTO etudiant(nom_etudiant,prenom_etudiant, classe_etudiant)
                VALUES('$nom', '$prenom', '$classe')");

            $reqe->execute()or die(print_r($reqe->errorInfo(), true));}
            $reqne = mysqli_fetch_array(mysqli_query($dbc,"SELECT num_etudiant FROM etudiant WHERE nom_etudiant= '$nom'and prenom_etudiant= '$prenom' and classe_etudiant='$classe' "))[0];

            //envoi dans la table matiere
            $reqme = mysqli_fetch_array(mysqli_query($dbc,"SELECT num_matiere FROM matiere WHERE matiere_matiere = '$matiere' "))[0];

            if($reqme>=1){}else{

            $reqm = mysqli_query($dbc,"
                    INSERT INTO matiere(matiere_matiere)
                    VALUES('$matiere')");
                $reqme = mysqli_fetch_array(mysqli_query($dbc,"SELECT num_matiere FROM matiere WHERE matiere_matiere = '$matiere' "))[0];
            }

        //envoie dans la table note
        $reqn = $dbco->prepare("
                INSERT INTO note(note_note,coef_note,id_etudiant,id_martiere)
                VALUES('$note', '$coefficient','$reqne','$reqme')");
        $reqn->execute()or die(print_r($reqn->errorInfo(), true));


        print "envoyer";
        mysqli_close($dbc);
}
?>
