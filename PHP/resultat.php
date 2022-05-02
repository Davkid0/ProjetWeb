

<?php
include 'cnx.php';
session_start();

if(!isset($_GET['txtTerminer']))
{
   

    $_SESSION['nbQuestion'] =$_SESSION['nbQuestion']+1;
    if(is_array($_POST['reponse']))
    {
       for($i=0;$i<count($_POST['reponse']);$i++)
       {
        $_SESSION['reponseMultiple'][$i]=$_POST['reponse'][$i];
        
       }
    }
    else
    {
        $_SESSION['result'][$_SESSION['nbQuestion']] = $_POST['reponse'];
    }
    $_SESSION['idQ'][$_SESSION['nbQuestion']] = $_POST['idQ'];
    

    
   
    $ok=0;
$resultat =0;
$i=1;

while($i<=$_SESSION['nbQuestion'])

{
    
    $rql = $cnx ->prepare("SELECT libelleQuestion,nbBonneReponse,reponse.valeur,bonne FROM reponse, questionreponse,question WHERE reponse.idReponse = questionreponse.idReponse AND idQuestion = questionreponse.idQuestionReponse and bonne=1 AND idQuestion =".$_SESSION['idQ'][$i]);
$rql ->execute();
$reponse = $rql->fetchAll(PDO::FETCH_ASSOC);
echo "<h1>".$reponse[0]['libelleQuestion']."</h1>";

if($reponse[0]['nbBonneReponse']>1)

{
    $dac=0;
     $multiple=0;
    $sql = $cnx ->prepare("select valeur FROM reponse, questionreponse,question WHERE reponse.idReponse = questionreponse.idReponse AND idQuestion = questionreponse.idQuestionReponse and bonne=1 AND idQuestion =".$_SESSION['idQ'][$i]);
$sql ->execute();
foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $ligne)
{
    $j=0;
    while($j<count($_SESSION['reponseMultiple']))
    {
        if($_SESSION['reponseMultiple'][$j]==$ligne['valeur'])
        {
            $dac=$dac+1;
           
        }
        $j++;
    }
}
$cql = $cnx ->prepare("select count(valeur) FROM reponse, questionreponse,question WHERE reponse.idReponse = questionreponse.idReponse AND idQuestion = questionreponse.idQuestionReponse and bonne=1 AND idQuestion =".$_SESSION['idQ'][$i]);
$cql ->execute();
$nbreponse = $cql->fetchAll(PDO::FETCH_ASSOC);
$sql = $cnx ->prepare("select valeur FROM reponse, questionreponse,question WHERE reponse.idReponse = questionreponse.idReponse AND idQuestion = questionreponse.idQuestionReponse and bonne=1 AND idQuestion =".$_SESSION['idQ'][$i]);
$sql ->execute();


if($nbreponse[0]['count(valeur)']==$dac)
{
    $ok=$ok+1;
    echo "<h2>Bonne réponse,c'était bien : ";
    foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $ligne)
    {
        echo ",".$ligne['valeur'];
    }
    echo ".</h2>";
}
else
{
    echo "<strong>Mauxaise réponse,c'était ";
    foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $ligne)
    {
        echo ",".$ligne['valeur'];
    }
    echo ".<strong>";
}



}
else if($reponse[0]['nbBonneReponse'] =1)
{
    $bonne = false;
    $j=1;
    while($j<count( $_SESSION['result']))
    {
        if($_SESSION['result'][$j] ==$reponse[0]['valeur'])
        {
            $bonne=true;
            break;
        }
        $j++;

    }
    if($bonne == true)
    {
        $ok=$ok+1;
        echo "<h2>Bonne réponse,c'était bien ".$reponse[0]['valeur']."</h2>";
    }
    else if($bonne == false)
    {
        echo "<strong>Mauvaise réponse,La réponse est ".$reponse[0]['valeur']."</strong>";
    }
    
}
else
{

}


$i++;
// echo date('d/m/Y');
}

$resultat = $ok/$_SESSION['nbQuestion']*100;
echo "<h1>Votre résultat est de ".$resultat."%</h1>";
}
$sql =$cnx->prepare("SELECT qcmfait.dateFait,qcmfait.point,questionnaire.idQuestionnaire,questionnaire.libelleQuestionnaire
FROM qcmfait,questionnaire,etudiants
WHERE etudiants.idEtudiant = qcmfait.idEtudiantQcm
AND qcmfait.idQcmFait = questionnaire.idQuestionnaire
AND etudiants.idEtudiant = ".$_SESSION['id']."
and questionnaire.idQuestionnaire =".$_SESSION['idQuestionnaire']);
$sql->execute();
$fait = $sql->fetchAll(PDO::FETCH_ASSOC);

if(!isset($fait[0]['dateFait']))
{
    $sql = $cnx->prepare("INSERT INTO `qcmfait` (`idEtudiantQcm`, `idQcmFait`, `dateFait`, `point`) VALUES (".$_SESSION['id'].", ".$_SESSION['idQuestionnaire'].", '".date('d/m/Y')."', ".$resultat.")");
    $sql->execute();
}
else if(isset($fait[0]['dateFait']))
{
    $rql = $cnx->prepare("UPDATE qcmfait SET point = ".$resultat." WHERE qcmfait.idEtudiantQcm = ".$_SESSION['id']." AND qcmfait.idQcmFait = ".$_SESSION['idQcmFait']);
    $rql->execute();
}
// }




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/resultat.css">
</head>
<body>
    


<form action="etudiant.php" method="get">
<input type="submit" value="Terminer" name="txtTerminer">
<input type="hidden" name="id" <?php echo "value='".$_SESSION['id']."'"?>>
</form>

</body>
</html>