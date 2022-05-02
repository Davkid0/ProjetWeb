

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../JS/JQuery 3.5.1.js"></script>
    <script src="../JS/mesFonction.js"></script>
    <script>
        $
        (
            function()
            {
                $('#btnAjouter').click(AjouterQuestion);
                $('#btnRetirer').click(RetirerQuestion);
                $('#btnEnregistrer').click(Verifier);
                $('.type').click(Effacer);
                

            }
        );
    </script>
</head>
<body>
<?php
if(isset($_GET['enregistrer']))
{
    if($_GET['txtQuestion']== "")
    {
        echo "<h1>Veuillez saisir le nom de la question </h1>";
    }
    if(!isset($_GET['choix']))
    {
        echo "<h1>Veuillez choisir un type</h1>";
    }
    if($_GET['choix']=="unique")
    {
        if(!isset($_GET['uniqueReponse']))
        {
            echo "<h1>Veuillez saisir une bonne réponse </h1>";
        }
    }
    else if($_GET['choix']=="multiple")
    {
        if(!isset($_GET['multipleReponse[]']))
        {
            echo "<h1>Veuillez saisir plusieur bonnes réponses </h1>";
        }
        else if(!is_array($_GET['multipleReponse[]']))
        {
            echo "<h1>Veuillez saisir des bonnes réponses </h1>";
        }
    }
    /*else if()
   

    {
        //Tout est okay;

    } */
    else {
        
        include 'cnx.php';
        $statut=0;
        $id=mt_rand()+10;
        $sql=$cnx->prepare("INSERT into question (libelleQuestion, type, nbReponse, nbBonneReponse) VALUES ('".$_POST["txtQuestion"]."', '".$_POST["choix"]."', 5, 1)");
        $sql->execute();
        header("Location:connexion.php");
    }
    
}
?>
    <h2>Entrez Votre question</h2>
    <br>
    <form action="CreerQuestion.php">
    <input type="text" name="txtQuestion">
    <h3>choix unique</h3>
    <input type="radio" name="choix" class=type value="unique">
    <h3>choix multiple</h3>
    <input type="radio" name="choix" class=type value="multiple" >
    <br>
    <div id="container">

    </div>

    
    <input type="button" id="btnAjouter" name="Ajouter" value="Ajouter" >
    
    <br>
    <br>
    
    
        
    <input type="submit" name="enregistrer"value="Enregistrer question" id="btnEnregistrer">
    </form>
    

</body>
</html>