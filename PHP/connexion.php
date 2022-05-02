<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Connexion</title>
</head>
<body class="bg-orange-200">
    <br>
    <br>
    <h1 class="text-center font-medium text-purple-500">Connexion</h1>
    


<?php

include 'cnx.php';
session_start();
$rql = $cnx ->prepare("SELECT etudiants.login FROM etudiants ");
$rql ->execute();
$row =$rql->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['login'] = $row[0]['login'];

if(isset($_POST['valid_connection']))
{
    //si l'utilisateur n'a pas donnée de donné
    if($_POST['form_username'] == "" )
    {
        echo"<h1 class='text-center text-red-600'>Identifiant incorrect</h1>";
    }
    else if($_POST['form_passeword'] =="")
    {
        echo"<h1 class='text-center text-red-600'>Identifiant incorrect</h1>";
    }
    //Vérifier si il est dans la base de donné
    else
    {

            $sql = $cnx ->prepare("SELECT etudiants.idEtudiant, etudiants.login, etudiants.motDePasse,etudiants.profession FROM etudiants ");
            $sql ->execute();
            //$profession=$sql->fetchAll(PDO::FETCH_ASSOC);
            
            
            foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $ligne)
            {
                // echo "<h1>".$ligne['idEtudiant']."</h1>";
                if($_POST['form_username'] == $ligne['login'] && $_POST['form_passeword'] == $ligne['motDePasse'])
                {
                    
                    if($ligne['profession']==1)
                    {
                        
                        header('Location:professeur.php?id='.$ligne['idEtudiant']);
                    }
                    else 
                    {
                        
                        header('Location:etudiant.php?id='.$ligne['idEtudiant']);
                    }
                    break;
                    
                }
            }
            echo "<h1>erreur</h1>";
    }
}
?>

    <form class="text-center" action="connexion.php" method="post">
        <input class="border-current border-2 rounded-lg" type="text" name="form_username" placeholder= "Identifiant...">
        <br>
        <br>
        <input class="border-current border-2 rounded-lg" type="password" name="form_passeword" placeholder="Mot de passe..." >
        <br>
        <br>
        <input class="border-current border-2 rounded-lg" type="submit" name="valid_connection" value="Connexion">
    </form>

    <nav>
        <br>
        <ul>
            <h6 class="text-sm text-center">Pas de compte? <a class="text-blue-600 text-xs underline" href="inscription.php">S'inscrire</a></h6>
            <h6 class="text-center text-xs underline text-blue-600"><a ><a href="bienvenue.php"href="connexion.php">Retourner à l'accueil</a></h6>
        </ul>
    </nav>
    <?php

    ?>
</body>
</html>