
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
include 'cnx.php';


$sql = $cnx ->prepare("SELECT etudiants.login, etudiants.motDePasse,etudiants.profession FROM etudiants where idEtudiant =".$_GET['id']);
$sql ->execute();
$nom=$sql->fetchAll(PDO::FETCH_ASSOC);
echo "<h1>Bienvenue ".$nom[0]['login']."</h1>";
?>
</body>
<form action="CreerQuestionnaire.php">
<input type="submit" value="Crée questionnaire">
</form>
<form action="CreerQuestion.php">
<input type="submit" value="Crée question">
</form>
</html>