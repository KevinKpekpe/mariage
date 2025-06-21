<?php
require_once 'db.php';
require_once 'functions.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

// Récupérer les mariages pour les annonces
$result = getMariagesForAnnouncements($pdo, $limit, $offset);
$mariages = $result['data'];
$total_count = $result['total_count'];
$total_pages = ceil($total_count / $limit);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces de Mariages Civils - Congo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body>
    <header>
        <div class="container">
            <a href="/" class="logo">
                <img src="./images/logo.png" alt="Logo Registre des Mariages">
                <h1>Registre des Mariages Civils</h1>
            </a>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="annonces.php">Annonces</a></li>
                    <li><a href="verification.php">Vérification</a></li>
                    <li><a href="admin/login.php">Administration</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="announcements">
        <div class="container">
            <h2 class="section-title">Annonces de Mariages à Venir</h2>

            <div class="search-block">
                <form action="verification.php" method="GET">
                    <input type="text" name="search" placeholder="Rechercher une personne...">
                    <button type="submit">Vérifier</button>
                </form>
            </div>

            <?php if ($result['success'] && !empty($mariages)): ?>
                <div class="announcements-grid">
                    <?php foreach ($mariages as $mariage): ?>
                        <div class="announcement-card">
                            <div class="announcement-photos">
                                <div class="photo-container">
                                    <?php if (!empty($mariage['photo_epoux'])): ?>
                                        <img src="<?php echo htmlspecialchars($mariage['photo_epoux']); ?>" alt="Photo de <?php echo htmlspecialchars($mariage['nom_epoux']); ?>">
                                    <?php else: ?>
                                        <img src="./images/person1.jpg" alt="Photo de <?php echo htmlspecialchars($mariage['nom_epoux']); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="photo-container">
                                    <?php if (!empty($mariage['photo_epouse'])): ?>
                                        <img src="<?php echo htmlspecialchars($mariage['photo_epouse']); ?>" alt="Photo de <?php echo htmlspecialchars($mariage['nom_epouse']); ?>">
                                    <?php else: ?>
                                        <img src="./images/person2.jpg" alt="Photo de <?php echo htmlspecialchars($mariage['nom_epouse']); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="announcement-date"><?php echo formatDate($mariage['date_celebration']); ?></div>
                            <div class="announcement-details">
                                <h3><?php echo htmlspecialchars($mariage['nom_epoux'] . ' & ' . $mariage['nom_epouse']); ?></h3>
                                <p>Maison Communale de <?php echo htmlspecialchars($mariage['nom_commune']); ?></p>
                                <p>Célébration prévue le <?php echo formatDate($mariage['date_celebration']); ?> à <?php echo htmlspecialchars($mariage['heure_celebration']); ?></p>
                                <div class="objection-link">
                                    <a href="objection.php?id=<?php echo $mariage['id_mariage']; ?>">Faire une objection</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>" class="pagination-btn">Précédent</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="pagination-btn <?php echo $i === $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>" class="pagination-btn">Suivant</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="no-announcements">
                    <h3>Aucun mariage à venir</h3>
                    <p>Il n'y a actuellement aucun mariage prévu dans notre registre.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>© 2025 Registre des Mariages Civils - République Démocratique du Congo</p>
            <p>Une plateforme officielle pour la transparence et la légalité des mariages civils</p>
            <div class="footer-links">
                <a href="#">À propos</a>
                <a href="#">Contact</a>
                <a href="#">Confidentialité</a>
                <a href="#">Conditions d'utilisation</a>
            </div>
        </div>
    </footer>
</body>

</html>