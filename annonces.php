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
                <form action="verification.html" method="GET">
                    <input type="text" name="search" placeholder="Rechercher une personne...">
                    <button type="submit">Vérifier</button>
                </form>
            </div>

            <div class="announcements-grid">
                <div class="announcement-card">
                    <div class="announcement-photos">
                        <div class="photo-container">
                            <img src="./images/person1.jpg" alt="Photo de Personne 1">
                        </div>
                        <div class="photo-container">
                            <img src="./images/person2.jpg" alt="Photo de Personne 2">
                        </div>
                    </div>
                    <div class="announcement-date">15/05/2025</div>
                    <div class="announcement-details">
                        <h3>Nom Personne 1 & Nom Personne 2</h3>
                        <p>Maison Communale de Ville</p>
                        <p>Célébration prévue le 15/05/2025 à 10h00</p>
                        <div class="objection-link">
                            <a href="objection.html">Faire une objection</a>
                        </div>
                    </div>
                </div>

                <div class="announcement-card">
                    <div class="announcement-photos">
                        <div class="photo-container">
                            <img src="./images/person1.jpg" alt="Photo de Personne 1">
                        </div>
                        <div class="photo-container">
                            <img src="./images/person2.jpg" alt="Photo de Personne 2">
                        </div>
                    </div>
                    <div class="announcement-date">22/05/2025</div>
                    <div class="announcement-details">
                        <h3>Nom Personne 3 & Nom Personne 4</h3>
                        <p>Maison Communale de Ville</p>
                        <p>Célébration prévue le 22/05/2025 à 14h30</p>
                        <div class="objection-link">
                            <a href="objection.html">Faire une objection</a>
                        </div>
                    </div>
                </div>

                <div class="announcement-card">
                    <div class="announcement-photos">
                    <div class="photo-container">
                            <img src="./images/person1.jpg" alt="Photo de Personne 1">
                        </div>
                        <div class="photo-container">
                            <img src="./images/person2.jpg" alt="Photo de Personne 2">
                        </div>  
                    </div>
                    <div class="announcement-date">28/05/2025</div>
                    <div class="announcement-details">
                        <h3>Nom Personne 5 & Nom Personne 6</h3>
                        <p>Maison Communale de Ville</p>
                        <p>Célébration prévue le 28/05/2025 à 11h00</p>
                        <div class="objection-link">
                            <a href="objection.html">Faire une objection</a>
                        </div>
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
                <a href="#">À propos</a>
                <a href="#">Contact</a>
                <a href="#">Confidentialité</a>
                <a href="#">Conditions d'utilisation</a>
            </div>
        </div>
    </footer>
</body>

</html>