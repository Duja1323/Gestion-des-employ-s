<?php
session_start();

if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

include_once "connexion.php";

if(isset($_POST['reset'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $check = mysqli_query($con, "SELECT id, username FROM users WHERE email = '$email'");
    
    if(mysqli_num_rows($check) > 0) {
        $user = mysqli_fetch_assoc($check);
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        mysqli_query($con, "UPDATE users SET reset_token = '$token', reset_expiry = '$expiry' WHERE id = " . $user['id']);
        
        // En production, utilisez une vraie fonction d'envoi d'email
        $reset_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/new-password.php?token=" . $token;
        $success = "Un email a été envoyé à $email avec les instructions de réinitialisation.<br>Lien de réinitialisation (pour demo) : <a href='$reset_link'>$reset_link</a>";
    } else {
        $error = "Aucun compte trouvé avec cet email";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe - Gestion des Employés</title>
    <link rel="icon" type="image/svg+xml" href="assets/img/favicon.svg">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Réinitialisation du mot de passe</h1>
            <p>Entrez votre email pour recevoir les instructions</p>
        </div>

        <div class="form-container">
            <?php if(isset($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if(isset($success)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        Email
                    </label>
                    <input type="email" name="email" required placeholder="Entrez votre email">
                </div>

                <button type="submit" name="reset" class="form-submit">
                    <i class="fas fa-paper-plane"></i>
                    Envoyer les instructions
                </button>

                <div class="form-links">
                    <a href="login.php" class="btn btn-link">
                        <i class="fas fa-arrow-left"></i>
                        Retour à la connexion
                    </a>
                </div>
            </form>
        </div>

        <footer>
            <p>© 2025 - Système de Gestion des Employés</p>
            <p>Développé par : Khadija DRIDER avec <i class="fas fa-heart"></i> pour votre entreprise</p>
        </footer>
    </div>
</body>
</html> 