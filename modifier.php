<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un employé - Gestion des Employés</title>
    <link rel="icon" type="image/svg+xml" href="assets/img/favicon.svg">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Modifier un Employé</h1>
            <p>Modifier les informations de l'employé</p>
        </div>

        <?php
        include_once "connexion.php";
        $id = $_GET['id'];
        $req = mysqli_query($con , "SELECT * FROM Employe WHERE id = $id");
        $row = mysqli_fetch_assoc($req);

        if(isset($_POST['button'])){
            extract($_POST);
            if(isset($nom) && isset($prenom) && isset($age)){
                $req = mysqli_query($con, "UPDATE Employe SET nom = '$nom', prenom = '$prenom', age = '$age' WHERE id = $id");
                if($req){
                    header("location: index.php");
                }else{
                    $message = "<div class='alert alert-error'><i class='fas fa-exclamation-circle'></i> Une erreur est survenue lors de la modification</div>";
                }
            }else{
                $message = "<div class='alert alert-error'><i class='fas fa-exclamation-circle'></i> Veuillez remplir tous les champs !</div>";
            }
        }
        ?>

        <div class="form-container">
            <a href="index.php" class="add-btn">
                <i class="fas fa-arrow-left"></i>
                Retour
            </a>

            <?php 
            if(isset($message)){
                echo $message;
            }
            ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="nom">
                        <i class="fas fa-user"></i>
                        Nom
                    </label>
                    <input type="text" name="nom" id="nom" value="<?=$row['nom']?>" placeholder="Entrez le nom">
                </div>
                <div class="form-group">
                    <label for="prenom">
                        <i class="fas fa-user"></i>
                        Prénom
                    </label>
                    <input type="text" name="prenom" id="prenom" value="<?=$row['prenom']?>" placeholder="Entrez le prénom">
                </div>
                <div class="form-group">
                    <label for="age">
                        <i class="fas fa-calendar-alt"></i>
                        Âge
                    </label>
                    <input type="number" name="age" id="age" value="<?=$row['age']?>" placeholder="Entrez l'âge">
                </div>
                <button type="submit" name="button" class="form-submit">
                    <i class="fas fa-save"></i>
                    Modifier
                </button>
            </form>
        </div>

        <footer>
            <p>© 2025 - Système de Gestion des Employés</p>
            <p>Développé par : Khadija DRIDER avec <i class="fas fa-heart"></i> pour votre entreprise</p>
        </footer>
    </div>
</body>
</html>