<?php
session_start();

// Si déjà connecté, rediriger vers index.php
if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Traitement du formulaire de connexion
if(isset($_POST['login'])) {
    include_once "connexion.php";
    
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($con, $sql);
    
    if($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Mot de passe incorrect";
        }
    } else {
        $error = "Nom d'utilisateur non trouvé";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion des Employés</title>
    <link rel="icon" type="image/svg+xml" href="assets/img/favicon.svg">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Connexion</h1>
            <p>Accédez à votre espace de gestion</p>
        </div>

        <div class="form-container">
            <?php if(isset($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" autocomplete="off">
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i>
                        Nom d'utilisateur
                    </label>
                    <input type="text" name="username" id="username" required placeholder="Entrez votre nom d'utilisateur" >
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i>
                        Mot de passe
                    </label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" required placeholder="Entrez votre mot de passe" autocomplete="new-password">
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                </div>

                <button type="submit" name="login" class="form-submit">
                    <i class="fas fa-sign-in-alt"></i>
                    Se connecter
                </button>

                <div class="form-links">
                    <a href="reset-password.php" class="btn btn-link">
                        <i class="fas fa-key"></i>
                        Mot de passe oublié ?
                    </a>
                </div>
            </form>
        </div>

        <footer>
            <p>© 2025 - Système de Gestion des Employés</p>
            <p>Développé par : Khadija DRIDER avec <i class="fas fa-heart"></i> pour votre entreprise</p>
        </footer>
    </div>
    <script>
        // Vider le formulaire au chargement de la page
        window.onload = function() {
            document.getElementById('username').value = '';
            document.getElementById('password').value = '';
        };

        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html> 