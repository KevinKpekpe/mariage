<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de Statut Matrimonial - Registre des Mariages Civils</title>
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
            <a href="index.php" class="logo">
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

    <section class="verification-container">
        <div class="container">
            <h2 class="section-title">Vérification de Statut Matrimonial</h2>

            <div class="verification-info">
                <h3>Pourquoi vérifier un statut matrimonial?</h3>
                <p>Cette vérification permet de confirmer si une personne est légalement mariée ou non, afin de prévenir les
                    cas de bigamie et garantir la légalité des unions civiles au Congo.</p>
            </div>

            <div class="verification-form">
                <h3>Rechercher une personne</h3>
                <form action="verification.html" method="GET">
                    <div class="form-group">
                        <label for="search">Nom, prénom ou numéro d'identité:</label>
                        <input type="text" id="search" name="search" value="">
                    </div>
                    <button type="submit">Rechercher</button>
                </form>
            </div>

            <div class="search-results">
                <div class="no-results">
                    <h3>Aucun résultat trouvé</h3>
                    <p>Aucune personne correspondant à votre recherche n'a été trouvée dans notre registre.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>© 2025 Registre des Mariages Civils - République Démocratique du Congo</p>
            <p>Une plateforme officielle pour la transparence et la légalité des mariages civils</p>
            <div class="footer-links">
                <a href="about.html">À propos</a>
                <a href="contact.html">Contact</a>
                <a href="privacy.html">Confidentialité</a>
                <a href="terms.html">Conditions d'utilisation</a>
            </div>
        </div>
    </footer>
</body>

</html>