<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../functions.php';
// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Get user data from session
$prenom = $_SESSION['prenom'];
$nom = $_SESSION['nom'];
$role = $_SESSION['role'];

// Determine user initials for avatar
$user_initials = strtoupper(substr($prenom, 0, 1) . substr($nom, 0, 1));

// Determine role display text
$role_display = $role === 'admin' ? 'Administrateur' : 'Officier Civil';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registre Mariages Civils - Dashboard</title>
    <link rel="stylesheet" href="/admin/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <div class="logo-diamond"></div>
                <div class="logo-text">Mariage</div>
            </div>
        </div>
        <nav class="sidebar-nav">
    <div class="nav-section">
        <div class="nav-section-title">Menu Principal</div>
        <a href="/admin/index.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
            <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
            Dashboard
        </a>
        <a href="/admin/mariages/mariages.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'mariages.php' ? 'active' : ''; ?>">
            <span class="nav-icon"><i class="fas fa-heart"></i></span>
            Mariages
        </a>
        <a href="/admin/personnes/personnes.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'personnes.php' ? 'active' : ''; ?>">
            <span class="nav-icon"><i class="fas fa-users"></i></span>
            Personnes
        </a>
        <?php if (hasRole('admin')): ?>
            <a href="/admin/officiers/officiers.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'officiers.php' ? 'active' : ''; ?>">
                <span class="nav-icon"><i class="fas fa-user-tie"></i></span>
                Officiers
            </a>
        <?php endif; ?>
    </div>

    <div class="nav-section">
        <div class="nav-section-title">Gestion</div>
        <a href="/admin/communes/communes.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'communes.php' ? 'active' : ''; ?>">
            <span class="nav-icon"><i class="fas fa-city"></i></span>
            Communes
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon"><i class="fas fa-handshake"></i></span>
            Parents
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon"><i class="fas fa-file-signature"></i></span>
            Témoins
        </a>
    </div>
</nav>

    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <h1 class="header-title">Dashboard</h1>
            <div class="header-actions">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Rechercher...">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
                </div>
                <div class="user-profile">
                    <div class="user-avatar"><?php echo htmlspecialchars($user_initials); ?></div>
                    <span><?php echo htmlspecialchars($prenom . ' ' . $nom); ?> (<?php echo htmlspecialchars($role_display); ?>)</span>
                </div>
                <a href="logout.php" class="logout-button">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </header>
