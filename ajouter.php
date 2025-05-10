<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Employé</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Ajouter un Employé</h1>
            <p>Créez un nouveau profil d'employé</p>
        </div>

        <?php
        if(isset($_POST['button'])){
            extract($_POST);
            if(isset($nom) && isset($prenom) && $age){
                include_once "connexion.php";
                $req = mysqli_query($con , "INSERT INTO Employe VALUES(NULL, '$nom', '$prenom','$age')");
                if($req){
                    header("location: index.php");
                } else {
                    $message = "<div class='alert alert-error'>
                        <i class='fas fa-exclamation-circle'></i>
                        Une erreur est survenue lors de l'ajout
                    </div>";
                }
            } else {
                $message = "<div class='alert alert-error'>
                    <i class='fas fa-exclamation-circle'></i>
                    Veuillez remplir tous les champs !
                </div>";
            }
        }
        ?>

        <div class="form-container">
            <a href="index.php" class="add-btn">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>

            <?php if(isset($message)) echo $message; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="nom">
                        <i class="fas fa-user"></i>
                        Nom
                    </label>
                    <input type="text" name="nom" id="nom" placeholder="Entrez le nom de l'employé">
                </div>

                <div class="form-group">
                    <label for="prenom">
                        <i class="fas fa-user"></i>
                        Prénom
                    </label>
                    <input type="text" name="prenom" id="prenom" placeholder="Entrez le prénom de l'employé">
                </div>

                <div class="form-group">
                    <label for="age">
                        <i class="fas fa-calendar-alt"></i>
                        Âge
                    </label>
                    <input type="number" name="age" id="age" placeholder="Entrez l'âge de l'employé">
                </div>

                <button type="submit" name="button" class="form-submit">
                    <i class="fas fa-user-plus"></i>
                    Ajouter l'employé
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