<?php
//connection a la base de donnée

$dsn = "mysql:dbname=prise_de_note;host=127.0.0.1;port=3306;" ;
$database = new PDO( $dsn, 'root', 'test' );
//choisis l'etudiant selon l'id en paramètre
function get_etudiant( PDO $database, $etudiant_id )
{
    $sql = "SELECT 
                etudiant.nom_etudiant AS nom, 
                etudiant.prenom_etudiant AS prenom,
                etudiant.classe_etudiant AS classe
            FROM etudiant
            WHERE etudiant.num_etudiant = ?" ;

    $req = $database-> prepare( $sql );
    $req-> execute( array( $etudiant_id ) );

    return $req-> fetch( PDO::FETCH_ASSOC );
}
//tableau avec tous les etudiants
function get_id_etudiant (PDO $database)
{
    $sql = "SELECT
                etudiant.num_etudiant AS num
                From etudiant" ;

    $req = $database-> prepare( $sql );
    $req-> execute();
    return $req-> fetchAll( PDO::FETCH_COLUMN);
}
//prend les notes et les matieres
function moyenne_matiere( PDO $database, $etudiant_id )
{
    $sql = "SELECT
                matiere.matiere_matiere AS matiere,
                AVG(note.note_note) AS moyenne, 
                note.coef_note AS coefficient
            FROM note,matiere 
            WHERE note.id_etudiant = ?
            AND note.id_martiere = matiere.num_matiere 
            GROUP BY note.id_martiere" ;

    $req = $database-> prepare( $sql );
    $req-> execute( array( $etudiant_id ) );

    return $req-> fetchAll( PDO::FETCH_ASSOC );
}
//faite le totale de la moyenne
function moyenne_totale( array $resultat_moyenne_matiere )
{
    $matiere_note = array();
    $sum_coeff = 0 ;

    foreach( $resultat_moyenne_matiere as $matiere )
    {
        $matiere_note[] = $matiere['moyenne'] * $matiere['coefficient'];
        $sum_coeff = $sum_coeff + $matiere['coefficient'];
    }

    $result = array_sum( $matiere_note ) / $sum_coeff ;

    return round( $result, 2, PHP_ROUND_HALF_UP );
}
//sorte tous les etudiants
$etudiants_id= get_id_etudiant($database);

foreach ($etudiants_id as $etudiant_id)
{
    $etudiant = get_etudiant( $database, $etudiant_id );
$moyenne_matiere = moyenne_matiere($database, $etudiant_id );
$moyenne_total = moyenne_totale( $moyenne_matiere );

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>

        <div id="etudiant">
            <table>
                <tr>
                    <td>Nom</td>
                    <td><?php echo $etudiant['nom'] ?></td>
                </tr>                <tr>
                    <td>Prénom</td>
                    <td><?php echo $etudiant['prenom'] ?></td>
                </tr>                <tr>
                    <td>Classe</td>
                    <td><?php echo $etudiant['classe'] ?> </td>
                </tr>
            </table>
        </div>

        <div id="matiere">
            <table>
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Moyenne</th>
                        <th>Coefficient</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $moyenne_matiere as $item ): ?>
                    <tr>
                        <td><?php echo $item['matiere'] ?></td>
                        <td><?php echo $item['moyenne'] ?></td>
                        <td><?php echo $item['coefficient'] ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <div id="total">
            <span>L'étudiant a eu un moyenne totale de <?php echo $moyenne_total ?></span>
        </div>
        <br><br>
    </body>
</html>
<?php
}
?>