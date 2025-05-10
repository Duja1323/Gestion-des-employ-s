<?php 
include_once "auth.php";

// Vérifier si l'utilisateur est admin (id=1)
if($_SESSION['user_id'] != 1) {
    header("Location: index.php");
    exit;
}

include_once "connexion.php";

// Traitement de l'ajout d'utilisateur
if(isset($_POST['add_user'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $check = mysqli_query($con, "SELECT id FROM users WHERE username = '$username' OR email = '$email'");
    if(mysqli_num_rows($check) == 0) {
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        if(mysqli_query($con, $sql)) {
            $success = "Utilisateur ajouté avec succès";
        } else {
            $error = "Erreur lors de l'ajout de l'utilisateur";
        }
    } else {
        $error = "Nom d'utilisateur ou email déjà utilisé";
    }
}

// Traitement de la suppression
if(isset($_GET['delete']) && $_GET['delete'] != 1) {
    $id = (int)$_GET['delete'];
    if(mysqli_query($con, "DELETE FROM users WHERE id = $id")) {
        $success = "Utilisateur supprimé avec succès";
    }
}

// Récupération des utilisateurs
$users = mysqli_query($con, "SELECT * FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="user-info">
                <span>Compte : <?php echo htmlspecialchars($username); ?></span>
                <a href="index.php" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Retour
                </a>
                <a href="logout.php" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                </a>
            </div>
            <h1>Gestion des Utilisateurs</h1>
            <p>Gérez les accès à votre plateforme</p>
        </div>

        <div class="content-container">
            <!-- Formulaire d'ajout -->
            <div class="form-container">
                <h2><i class="fas fa-user-plus"></i> Ajouter un utilisateur</h2>
                
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
                        <label for="username">
                            <i class="fas fa-user"></i>
                            Nom d'utilisateur
                        </label>
                        <input type="text" name="username" required placeholder="Entrez le nom d'utilisateur">
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Email
                        </label>
                        <input type="email" name="email" required placeholder="Entrez l'email">
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Mot de passe
                        </label>
                        <input type="password" name="password" required placeholder="Entrez le mot de passe">
                    </div>

                    <button type="submit" name="add_user" class="form-submit">
                        <i class="fas fa-user-plus"></i>
                        Ajouter l'utilisateur
                    </button>
                </form>
            </div>

            <!-- Liste des utilisateurs -->
            <div class="table-container">
                <h2><i class="fas fa-users"></i> Liste des utilisateurs</h2>
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> Utilisateur</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-calendar"></i> Date de création</th>
                            <th><i class="fas fa-cog"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($user = mysqli_fetch_assoc($users)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <div class="actions">
                                        <?php if($user['id'] != 1): ?>
                                            <a href="#" onclick="confirmDelete(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['username']); ?>')" class="btn btn-delete">
                                                <i class="fas fa-trash-alt"></i>
                                                Supprimer
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <footer>
            <p>© 2025 - Système de Gestion des Employés</p>
            <p>Développé par : Khadija DRIDER avec <i class="fas fa-heart"></i> pour votre entreprise</p>
        </footer>
    </div>

    <script>
    function confirmDelete(id, username) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            html: `Vous êtes sur le point de supprimer l'utilisateur <br><strong>${username}</strong>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53e3e',
            cancelButtonColor: '#718096',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `users.php?delete=${id}`;
            }
        });
    }
    </script>
</body>
</html> 