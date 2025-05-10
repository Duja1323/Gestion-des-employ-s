<?php 
include_once "auth.php";
include_once "connexion.php";

// Récupération des employés avec gestion des erreurs
try {
    $req = mysqli_query($con, "SELECT * FROM Employe ORDER BY nom, prenom");
    if (!$req) {
        throw new Exception(mysqli_error($con));
    }
} catch (Exception $e) {
    die("Erreur lors de la récupération des employés : " . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Application de gestion des employés - Gérez efficacement votre personnel">
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="Votre Entreprise">
    <title>Gestion des Employés - Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-..." crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="user-info">
                <span>Compte : <?= htmlspecialchars($username) ?></span>
                <?php if($_SESSION['user_id'] == 1): ?>
                    <a href="users.php" class="btn btn-users">
                        <i class="fas fa-users-cog"></i> Gérer les utilisateurs
                    </a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
            <h1>Gestion des Employés</h1>
            <p>Votre plateforme intelligente de gestion du personnel</p>
        </div>

        <a href="ajouter.php" class="add-btn">
            <i class="fas fa-user-plus"></i> Ajouter un employé
        </a>

        <?php if(mysqli_num_rows($req) == 0): ?>
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>Aucun employé pour le moment</h3>
                <p>Commencez par ajouter votre premier employé</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> Nom</th>
                            <th><i class="fas fa-user"></i> Prénom</th>
                            <th><i class="fas fa-calendar-alt"></i> Âge</th>
                            <th><i class="fas fa-cog"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($req)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nom']) ?></td>
                                <td><?= htmlspecialchars($row['prenom']) ?></td>
                                <td><span class="age-badge"><?= (int)$row['age'] ?> ans</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="modifier.php?id=<?= (int)$row['id'] ?>" class="btn btn-edit">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        <a href="#" onclick="confirmDelete(<?= (int)$row['id'] ?>, '<?= htmlspecialchars($row['nom']) ?>', '<?= htmlspecialchars($row['prenom']) ?>')" class="btn btn-delete">
                                            <i class="fas fa-trash-alt"></i> Supprimer
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <footer>
            <p>© 2025 - Système de Gestion des Employés</p>
            <p>Développé par : Khadija DRIDER avec <i class="fas fa-heart"></i> pour votre entreprise</p>
        </footer>
    </div>

    <script>
    // Fonction de confirmation de suppression
    function confirmDelete(id, nom, prenom) {
        const employeInfo = `${nom} ${prenom}`.trim();
        
        Swal.fire({
            title: 'Confirmation de suppression',
            html: `Voulez-vous vraiment supprimer l'employé <br><strong>${employeInfo}</strong> ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53e3e',
            cancelButtonColor: '#718096',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            focusCancel: true 
        }).then(result => {
            if (result.isConfirmed) {
                window.location.href = `supprimer.php?id=${encodeURIComponent(id)}`;
            }
        });
        return false;
    }
    </script>
</body>
</html>