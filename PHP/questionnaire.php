<?php

include 'cnx.php';



session_start();
$_SESSION['nbQuestion']= $_SESSION['nbQuestion']+1;
$_SESSION['variable']=$_SESSION['variable']+1;

if(isset($_POST['valid_connection']))
{
    
    if(is_array($_POST['reponse']))
    {
       for($i=0;$i<count($_POST['reponse']);$i++)
       {
         $_SESSION['reponseMultiple'][$i]=$_POST['reponse'][$i];
       
        
       }
    }
    else
    {
        $_SESSION['result'][$_SESSION['variable']] = $_POST['reponse'];
    }


    $_SESSION['idQ'][$_SESSION['nbQuestion']] = $_POST['idQ'];
   
   
   

}

if(!isset($_POST['valid_connection']))
{
    $memo = $cnx->prepare("SELECT qcmfait.idQcmFait,questionnaire.idQuestionnaire,questionnaire.libelleQuestionnaire FROM questionnaire,qcmfait,etudiants where etudiants.idEtudiant=idEtudiantQcm AND idQcmFait = questionnaire.idQuestionnaire AND idEtudiantQcm =".$_SESSION['id']." AND questionnaire.idQuestionnaire = ".$_GET['numQuestionnaire']);
    $memo->execute();
    $row = $memo->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['idQcmFait'] = $row[0]['idQcmFait'];
    $_SESSION['idQuestionnaire'] = $row[0]['idQuestionnaire'];
    $_SESSION['idQcmFait'] = $row[0]['idQcmFait'];

}


$rql = $cnx ->prepare("SELECT COUNT(question.libelleQuestion)FROM questionnaire,questionquestionnaire,question WHERE questionnaire.idQuestionnaire =questionquestionnaire.idQuestionnaireQuestion AND question.idQuestion = questionquestionnaire.idQuestionQuestionnaire AND questionnaire.idQuestionnaire = ".$_SESSION['idQuestionnaire']);
$rql ->execute();
 $nbquestion = $rql->fetchAll(PDO::FETCH_ASSOC);
 $sql = $cnx ->prepare("SELECT question.libelleQuestion,nbBonneReponse,idQuestion,questionreponse.idQuestionReponse
 FROM questionnaire,questionquestionnaire,question,questionreponse
 WHERE questionnaire.idQuestionnaire =questionquestionnaire.idQuestionnaireQuestion
 AND question.idQuestion = questionquestionnaire.idQuestionQuestionnaire
 AND questionnaire.idQuestionnaire = ".$_SESSION['idQuestionnaire']);
    $sql ->execute();
    $question= $sql->fetchAll(PDO::FETCH_ASSOC);
    echo "<h1>".$question[$_SESSION['nbQuestion']]['libelleQuestion']."</h1>";
    if($_SESSION['nbQuestion']+1 >=$nbquestion[0]['COUNT(question.libelleQuestion)'])
    {
        ?><form action="resultat.php" method="post">
       <?php $rql = $cnx ->prepare("SELECT idQuestion,nbBonneReponse,reponse.valeur,bonne FROM reponse, questionreponse,question WHERE reponse.idReponse = questionreponse.idReponse AND idQuestion = questionreponse.idQuestionReponse AND idQuestion =".$question[$_SESSION['nbQuestion']]['idQuestion']);
    $rql ->execute();
    foreach($rql->fetchAll(PDO::FETCH_ASSOC) as $ligne)
    {
        if($ligne['nbBonneReponse'] >1)
        {
        ?><input type="checkbox" name="reponse" id="" value="<?php echo $ligne['valeur'];?>"><?php echo $ligne['valeur'];

         echo "<br>";
        }
        else if($ligne['nbBonneReponse']=1)
        {
        ?><input type="radio" name="reponse" id="" value="<?php echo $ligne['valeur'];?>"><?php echo $ligne['valeur'];
         echo "<br>";
        }
        ?><input type="hidden" name="idQ" value="<?php echo $ligne['idQuestion'];?>">
        <?php
    }
    ?>
        <input type="submit" name="valid_connection" value="Terminer">
    </form>
    <?php
    }
    else
    {
        ?><form action="questionnaire.php" method="post">
           <?php $rql = $cnx ->prepare("SELECT idQuestion,nbBonneReponse,reponse.valeur,bonne FROM reponse, questionreponse,question WHERE reponse.idReponse = questionreponse.idReponse AND idQuestion = questionreponse.idQuestionReponse AND idQuestion =".$question[$_SESSION['nbQuestion']]['idQuestion']);
    $rql ->execute();
    foreach($rql->fetchAll(PDO::FETCH_ASSOC) as $ligne)
    {
        if($ligne['nbBonneReponse'] >1)
        {
        ?><input type="checkbox" name="reponse[]" id="" value="<?php echo $ligne['valeur'];?>"><?php echo $ligne['valeur'];

         echo "<br>";
        }
        else if($ligne['nbBonneReponse']=1)
        {
        // echo "<input type='checkbox' name='' id=''>".$ligne['valeur'];
        ?><input type="radio" name="reponse" id="" value="<?php echo $ligne['valeur'];?>"><?php echo $ligne['valeur'];


         echo "<br>";
        }
        ?><input type="hidden" name="idQ" value="<?php echo $ligne['idQuestion'];?>">
        <?php

    }

    ?>
        <input type="submit" name="valid_connection" value="suivant">
    </form>
    <?php
    }




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/questionnaire.css">
</head>
<body>

</body>
</html>