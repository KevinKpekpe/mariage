<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre des Mariages Civils - Congo</title>
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

    <section class="hero">
        <h2>Transparence et Légalité des Mariages Civils</h2>
        <p>Un registre public des mariages pour garantir la transparence et prévenir les mariages frauduleux au Congo.</p>
        <a href="verification.php" class="btn">Vérifier un Statut Matrimonial</a>
    </section>

    <div class="container">
        <form class="search-form" action="verification.php" method="GET">
            <input type="text" name="search" placeholder="Rechercher une personne par nom ou numéro d'identité...">
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <section class="features">
        <div class="container">
            <h2 class="section-title">Nos Services</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-bullhorn"></i>
                    <h3>Annonces Publiques</h3>
                    <p>Consultez les prochains mariages civils qui auront lieu dans les maisons communales, avec les photos et
                        identités des futurs époux.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-check-circle"></i>
                    <h3>Vérification de Statut</h3>
                    <p>Vérifiez si une personne est déjà engagée dans un mariage civil, pour éviter les pratiques illégales de
                        polygamie.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-database"></i>
                    <h3>Base de Données Nationale</h3>
                    <p>Accédez à un répertoire centralisé des mariages civils pour plus de transparence et de sécurité
                        juridique.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="recent-announcements">
        <div class="container">
            <h2 class="section-title">Annonces Récentes</h2>
            <div class="announcements-grid">
                <!-- Ces éléments seront générés dynamiquement par PHP -->
                <div class="announcement-card">
                    <div class="announcement-image">
                        <img src="./images/mariage.jpg" alt="Sarah Mutombo & Jean Mukendi">
                        <div class="announcement-date">15/05/2025</div>
                    </div>
                    <div class="announcement-details">
                        <h3>Sarah Mutombo & Jean Mukendi</h3>
                        <p>Maison Communale de Kinshasa</p>
                        <p>Célébration prévue le 15/05/2025 à 10h00</p>
                    </div>
                </div>

                <div class="announcement-card">
                    <div class="announcement-image">
                        <img src="./images/mariage.jpg" alt="Marie Ngalula & Paul Ilunga">
                        <div class="announcement-date">22/05/2025</div>
                    </div>
                    <div class="announcement-details">
                        <h3>Marie Ngalula & Paul Ilunga</h3>
                        <p>Maison Communale de Lubumbashi</p>
                        <p>Célébration prévue le 22/05/2025 à 14h30</p>
                    </div>
                </div>

                <div class="announcement-card">
                    <div class="announcement-image">
                        <img src="./images/mariage.jpg" alt="Sophie Nkandu & Marc Lukeba">
                        <div class="announcement-date">28/05/2025</div>
                    </div>
                    <div class="announcement-details">
                        <h3>Sophie Nkandu & Marc Lukeba</h3>
                        <p>Maison Communale de Goma</p>
                        <p>Célébration prévue le 28/05/2025 à 11h00</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>© 2025 Registre des Mariages Civils - République Démocratique du Congo</p>
            <p>Une plateforme officielle pour la transparence et la légalité des mariages civils</p>
            <div class="footer-links">
                <a href="about.php">À propos</a>
                <a href="contact.php">Contact</a>
                <a href="privacy.php">Confidentialité</a>
                <a href="terms.php">Conditions d'utilisation</a>
            </div>
        </div>
    </footer>
</body>

</html>