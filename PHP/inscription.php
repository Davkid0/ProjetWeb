<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com/%22%3E"></script>
</head>
<body class="bg-orange-200">
    <br><br>
    <h1 class="text-center font-medium text-purple-500">Inscription</h1>
    <br>
    <h2 class="text-center"></h2>

    <?php
            session_start();
            if(isset($_POST['valid_inscription']))
            {
                if($_POST['Nom']=="")
                {
                    echo "<h1 class='text-center text-red-600' > Veuillez entrer un nom</h1>";
                }
                else if($_POST['Prenom']=="")
                {
                    echo "<h1 class='text-center text-red-600' >Veuillez entrer un prenom</h1>";  
                }
                else if($_POST['Mail']=="")
                {
                    echo "<h1 class='text-center text-red-600' >Veuillez entrer un Mail</h1>";  
                }
                else if($_POST['login']=="")
                {
                    echo "<h1 class='text-center text-red-600' >Veuillez entrer un login</h1>";
                }
                else if($_POST['MDP']=="")
                {
                    echo "<h1 class='text-center text-red-600' >Veuillez entrer un mot de passe</h1>";
                }
                else if (!is_numeric($_POST['MDP']))
                {
                    echo "<h1 classe='text-center text-ref-600' >Veuillez entrer un mot de passe ne contenant que des chiffres</h1>";
                }
                else if($_POST['Confirm']=="")
                {
                    echo "<h1 class='text-center text-red-600' >Veuillez Confirmez le mot de passe</h1>";
            
                }
                else if($_POST['Confirm']!=$_POST['MDP'])
                {
                    echo "<h1 class='text-center text-red-600' >Vos mot de passe ne sont pas identiques</h1>";
                }

                else
                {
                   
                   include 'cnx.php';
                   $statut=0;
                   $id=mt_rand()+10;
                   //$sql=$cnx->prepare("INSERT INTO etudiants VALUES (".$id.",'".$_POST['Nom']."','".$_POST['Prenom']."','".$_POST['Mail']."','".$_POST['login']."','".$_POST['MDP']."',".$statut.")");
                   $sql=$cnx->prepare("INSERT into etudiants (login, motDePasse, nom, prenom, email, profession) VALUES ('".$_POST["login"]."', '".$_POST["MDP"]."', '".$_POST["Nom"]."', '".$_POST["Prenom"]."', '".$_POST["Mail"]."', 0)");
                   $sql->execute();
                   header("Location:connexion.php");
                }
            }
            
    ?>
    <form class="text-center" action="inscription.php" method="post">
        <input class="border-current border-2 rounded-lg" type="text" name="Nom" class="form-control" placeholder= "Votre nom..." requiered="requiered" >
        <br>
        <br>
        <input class="border-current border-2 rounded-lg" type="text" name="Prenom" class="form-control" placeholder= "Votre prenom..." requiered="requiered" >
        <br>
        <br>
        <input class="border-current border-2 rounded-lg" type="text" name="Mail" class="form-control" placeholder= "Votre adresse mail..." requiered="requiered">
        <br>
        <br>
        <input class="border-current border-2 rounded-lg" type="text" name="login" class="form-control" placeholder= "Votre login..." requiered="requiered">
        <br>
        <br>
        <input class="border-current border-2 rounded-lg" type="password" name="MDP" class="form-control" placeholder="Entrez votre mot de passe..." >
        <br>
        <br>
        <input class="border-current border-2 rounded-lg" type="password" name="Confirm" class="form-control" placeholder="Confirmer votre mot de passe..."> 
        <br>
        <br>
        <input class="border-current border-2 " type="submit" name="valid_inscription" value="Inscription">

        <nav>
            <br>
        <ul>
            <h6 class="text-sm">Déjà inscris? <a class="text-blue-600 text-xs underline" href="connexion.php">Se connecter</a></h6>
            <h6 class="text-center text-xs underline text-blue-600"><a href="bienvenue.php">Retourner à l'accueil</a></h6>
        </ul>
    </nav>
    </form>