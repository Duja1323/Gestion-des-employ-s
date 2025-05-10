<?php
include_once "connexion.php";

mysqli_query($con, "DROP TABLE IF EXISTS users");

$sql = "CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    reset_token VARCHAR(64) DEFAULT NULL,
    reset_expiry DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($con, $sql)) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; margin: 10px; border-radius: 5px;'>
        ✅ Table users créée avec succès
    </div>";
    
    // Créer un utilisateur par défaut (Admin/Admin123)
    $username = "Admin";
    $password = password_hash("Admin123", PASSWORD_DEFAULT);
    $email = "admin@example.com";
    
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    if (mysqli_query($con, $sql)) {
        echo "<div style='background: #d4edda; color: #155724; padding: 15px; margin: 10px; border-radius: 5px;'>
            ✅ Utilisateur admin créé avec succès<br>
            👤 Nom d'utilisateur : Admin<br>
            🔑 Mot de passe : Admin123
        </div>";
        
        echo "<div style='background: #cce5ff; color: #004085; padding: 15px; margin: 10px; border-radius: 5px;'>
            ℹ️ Vous pouvez maintenant vous connecter en utilisant ces identifiants sur la <a href='login.php' style='color: #004085; font-weight: bold;'>page de connexion</a>.
        </div>";
    }
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px; border-radius: 5px;'>
        ❌ Erreur lors de la création de la table: " . mysqli_error($con) . "
    </div>";
}
?> 