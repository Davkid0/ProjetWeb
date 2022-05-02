<?php
include 'cnx.php';
session_start();
$_SESSION['result'] = array();
$_SESSION['idQuestion']=array();
$_SESSION['reponseMultiple']=array();
$_SESSION['nbQuestion'] = -1;
$_SESSION['multiple'] = 0;
$_SESSION['variable']=-1;
$faitOuPas = false;
if(!isset($_GET['btnRecherche']))
{
    
    $sql = $cnx ->prepare("SELECT idEtudiant,etudiants.login, etudiants.motDePasse,etudiants.profession FROM etudiants where idEtudiant =".$_GET['id']);
$sql ->execute();
$nom=$sql->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['nom'] = $nom[0]['login'];
echo "<h1>Bienvenue ".$nom[0]['login']."</h1>";

    $_SESSION['id'] = $nom[0]['idEtudiant'];
    // $_SESSION['txtRecherche'] = $_GET['txtRechercher'];
   
    ?>
    <form action="etudiant.php" method="get">
<input type="text" name="txtRecherche" id="">
<input type="submit" value="rechercher" name="btnRecherche">
</form>
    <?php

$sql = $cnx->prepare("SELECT questionnaire.libelleQuestionnaire ,questionnaire.idQuestionnaire FROM questionnaire");
$sql ->execute();


echo"<table>
<thead>
            <tr>
                <th>Numéro</th>
                <th>Libellé</th>
                <th>Fait le </th>
                <th></th>
            </tr>
        </thead>";


foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $ligne)
{
    echo "<tr>";
    echo "<td>".$ligne['libelleQuestionnaire']."</td>";
    $rql= $cnx ->prepare("SELECT qcmfait.dateFait,qcmfait.point,questionnaire.idQuestionnaire,questionnaire.libelleQuestionnaire
    FROM qcmfait,questionnaire,etudiants
    WHERE etudiants.idEtudiant = qcmfait.idEtudiantQcm
    AND qcmfait.idQcmFait = questionnaire.idQuestionnaire
    AND etudiants.idEtudiant = ".$_SESSION['id']."
    and questionnaire.idQuestionnaire =".$ligne['idQuestionnaire']);
    $rql->execute();
   
    foreach($rql->fetchAll(PDO::FETCH_ASSOC) as $i)
    {
        if($i['dateFait']=="")
        {
            
        }
        else
        {
            $faitOuPas = true;
            echo"<td>".$i['dateFait']."</td>";
            echo"<td>".$i['point']."</td>";
        }
        
    }
    
    echo "<td><a href='questionnaire.php?numQuestionnaire=".$ligne['idQuestionnaire']."'>Choisir</a></td>";
    
    echo "</tr>";
}

echo "</table>";
    
}
else
{
    
if($_GET['txtRecherche'] =="")
{
    echo "<h1>Bienvenue ".$_SESSION['nom']."</h1>";
    echo "<strong>Le champ ne peut pas etre vide</strong>";
    echo "<h1>Veuillez selectionner un question</h1>";
    ?>
    <form action="etudiant.php" method="get">
<input type="text" name="txtRecherche" id="">
<input type="submit" value="rechercher" name="btnRecherche">
</form>
    <?php
    $sql = $cnx->prepare("SELECT questionnaire.libelleQuestionnaire ,questionnaire.idQuestionnaire FROM questionnaire");
    $sql ->execute();
    
    
    echo"<table>";
    
    
    foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $ligne)
    {
        echo "<tr>";
        echo "<td>".$ligne['libelleQuestionnaire']."</td>";
        $rql= $cnx ->prepare("SELECT qcmfait.dateFait,qcmfait.point,questionnaire.idQuestionnaire,questionnaire.libelleQuestionnaire
        FROM qcmfait,questionnaire,etudiants
        WHERE etudiants.idEtudiant = qcmfait.idEtudiantQcm
        AND qcmfait.idQcmFait = questionnaire.idQuestionnaire
        AND etudiants.idEtudiant = ".$_SESSION['id']."
        and questionnaire.idQuestionnaire =".$ligne['idQuestionnaire']);
        $rql->execute();
       
        foreach($rql->fetchAll(PDO::FETCH_ASSOC) as $i)
        {
            if($i['dateFait']=="")
            {
                
            }
            else
            {
                $faitOuPas = true;
                echo"<td>".$i['dateFait']."</td>";
                echo"<td>".$i['point']."</td>";
            }
            
        }
        $_SESSION['fait'] = $faitOuPas;
        echo "<td><a href='questionnaire.php?numQuestionnaire=".$ligne['idQuestionnaire']."'>Choisir</a></td>";
        
        echo "</tr>";
    }
    
echo "</table>";
}
else
{
    echo "<h1>Bienvenue ".$_SESSION['nom']."</h1>";
    echo "<h1>Veuillez selectionner un question</h1>";
    ?>
    <form action="etudiant.php" method="get">
<input type="text" name="txtRecherche" id="">
<input type="submit" value="rechercher" name="btnRecherche">
</form>
    <?php

$sql = $cnx->prepare("SELECT questionnaire.libelleQuestionnaire ,questionnaire.idQuestionnaire FROM questionnaire WHERE libelleQuestionnaire like '%".$_GET['txtRecherche']."%'");
$sql ->execute();


echo"<table>";


foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $ligne)
{
    echo "<tr>";
    echo "<td>".$ligne['libelleQuestionnaire']."</td>";
    $rql= $cnx ->prepare("SELECT qcmfait.dateFait,qcmfait.point,questionnaire.idQuestionnaire,questionnaire.libelleQuestionnaire
    FROM qcmfait,questionnaire,etudiants
    WHERE etudiants.idEtudiant = qcmfait.idEtudiantQcm
    AND qcmfait.idQcmFait = questionnaire.idQuestionnaire
    AND etudiants.idEtudiant = ".$_SESSION['id']."
    and questionnaire.idQuestionnaire =".$ligne['idQuestionnaire']);
    $rql->execute();
   
    foreach($rql->fetchAll(PDO::FETCH_ASSOC) as $i)
    {
        if($i['dateFait']=="")
        {
            
        }
        else
        {
            $faitOuPas = true;
            echo"<td>".$i['dateFait']."</td>";
            echo"<td>".$i['point']."</td>";
        }
        
    }
    $_SESSION['fait'] = $faitOuPas;
    echo "<td><a href='questionnaire.php?numQuestionnaire=".$ligne['idQuestionnaire']."'>Choisir</a></td>";
    
    echo "</tr>";
}

}
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/etudiant.css">
</head>
<body>
<br>


</body>
</html>