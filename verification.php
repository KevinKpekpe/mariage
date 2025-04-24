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
    <style>
        /* Reset & General Styles */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #17a2b8;
            --secondary-color: #343a40;
            --accent-color: #ffc107;
            --light-color: #e9ecef;
            /* Changed light color */
            --dark-color: #212529;
            --text-color: #495057;
            --shadow-color: rgba(0, 0, 0, 0.15);
            --border-radius: 0.5rem;
            --font-family: 'Poppins', sans-serif;
            --transition-duration: 0.3s;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--light-color);
            color: var(--text-color);
            line-height: 1.7;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: var(--primary-color);
            transition: color var(--transition-duration) ease;
        }

        a:hover {
            color: var(--secondary-color);
        }

        /* Utility Classes */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .section-title {
            font-size: 2.75rem;
            color: var(--secondary-color);
            text-align: center;
            margin-bottom: 2.5rem;
            font-weight: 700;
            text-shadow: 0 2px 4px var(--shadow-color);
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--primary-color);
            color: white;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: all var(--transition-duration) ease;
            box-shadow: 0 4px 6px var(--shadow-color);
            border: none;
            cursor: pointer;
            font-family: var(--font-family);
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 10px var(--shadow-color);
        }

        /* Header Styles */
        header {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 5px var(--shadow-color);
            padding: 1.25rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            transition: transform var(--transition-duration) ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo img {
            height: 55px;
            margin-right: 15px;
        }

        .logo h1 {
            font-size: 1.85rem;
            color: var(--dark-color);
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-left: 30px;
        }

        nav ul li a {
            color: var(--dark-color);
            font-weight: 500;
            padding: 10px 15px;
            border-radius: var(--border-radius);
            transition: background-color var(--transition-duration) ease, color var(--transition-duration) ease;
        }

        nav ul li a:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Verification Section Styles */
        .verification-container {
            padding: 5rem 0;
        }

        .verification-info {
            max-width: 800px;
            margin: 0 auto 3rem;
            padding: 2rem;
            background-color: #e8f4ff;
            border-radius: var(--border-radius);
            border-left: 5px solid var(--primary-color);
            animation: fadeInUp 0.8s ease-out;
        }

        .verification-info h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .verification-form {
            max-width: 800px;
            margin: 0 auto 3rem;
            padding: 3rem;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 8px var(--shadow-color);
            animation: slideInDown 0.8s ease-out;
        }

        .verification-form h3 {
            color: var(--primary-color);
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 500;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 1.25rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-family: var(--font-family);
            outline: none;
        }

        .verification-form button {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 1.25rem 2rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 500;
            transition: background-color var(--transition-duration) ease, color var(--transition-duration) ease;
            font-family: var(--font-family);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .verification-form button:hover {
            background-color: #a82626;
        }

        .search-results {
            max-width: 800px;
            margin: 0 auto;
        }

        .result-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 8px var(--shadow-color);
            padding: 2rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            animation: zoomIn 0.7s ease-out;
        }

        .result-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 2rem;
            flex-shrink: 0;
        }

        .result-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .result-details {
            flex: 1;
        }

        .result-details h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .result-details p {
            margin-bottom: 0.5rem;
        }

        .result-status {
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            display: inline-block;
            margin-top: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-single {
            background-color: #4CAF50;
            color: white;
        }

        .status-married {
            background-color: var(--secondary-color);
            color: white;
        }

        .status-engaged {
            background-color: var(--accent-color);
            color: var(--dark-color);
        }

        .no-results {
            text-align: center;
            padding: 4rem;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 8px var(--shadow-color);
            font-size: 1.2rem;
            color: var(--text-color);
        }

        /* Footer Styles */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 3.5rem 0;
            text-align: center;
        }

        footer p {
            margin-bottom: 1rem;
            font-size: 0.95rem;
            opacity: 0.8;
        }

        .footer-links {
            margin-top: 2rem;
        }

        .footer-links a {
            color: var(--light-color);
            margin: 0 1.25rem;
            font-weight: 500;
            transition: color var(--transition-duration) ease;
        }

        .footer-links a:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header .container {
                flex-direction: column;
                align-items: center;
            }

            .logo {
                margin-bottom: 1.25rem;
            }

            nav ul {
                margin-top: 1.25rem;
                justify-content: center;
            }

            nav ul li {
                margin-left: 20px;
            }

            .verification-form {
                padding: 2rem;
            }

            .result-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .result-photo {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <a href="/" class="logo">
                <img src="logo.png" alt="Logo Registre des Mariages">
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