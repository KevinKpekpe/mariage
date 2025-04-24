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

        /* Hero Section Styles */
        .hero {
            background: linear-gradient(rgba(52, 58, 64, 0.7), rgba(52, 58, 64, 0.7)), url('hero-image.jpg') center/cover no-repeat;
            color: white;
            text-align: center;
            padding: 8rem 2rem;
            border-radius: var(--border-radius);
            margin-bottom: 4rem;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom right, rgba(23, 162, 184, 0.4), rgba(52, 58, 64, 0.6));
            z-index: 1;
        }

        .hero * {
            z-index: 2;
        }

        .hero h2 {
            font-size: 3.5rem;
            margin-bottom: 2rem;
            font-weight: 700;
            text-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease-out;
        }

        .hero p {
            font-size: 1.3rem;
            max-width: 850px;
            margin: 0 auto 2.5rem;
            animation: fadeInUp 1.2s ease-out;
        }

        .hero .btn {
            animation: fadeInUp 1.4s ease-out;
        }

        /* Search Form Styles */
        .search-form {
            display: flex;
            margin: 3rem auto;
            max-width: 650px;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 4px 8px var(--shadow-color);
            animation: slideInDown 0.8s ease-out;
        }

        .search-form input {
            flex: 1;
            padding: 1.25rem;
            border: none;
            font-size: 1.1rem;
            font-family: var(--font-family);
            outline: none;
        }

        .search-form button {
            background-color: var(--accent-color);
            color: var(--dark-color);
            border: none;
            padding: 0 2rem;
            cursor: pointer;
            font-weight: 600;
            transition: background-color var(--transition-duration) ease, color var(--transition-duration) ease;
            font-family: var(--font-family);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .search-form button:hover {
            background-color: #e0a800;
            color: var(--dark-color);
        }

        /* Features Section Styles */
        .features {
            padding: 5rem 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 3rem;
        }

        .feature-card {
            background-color: white;
            padding: 2.5rem;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 8px var(--shadow-color);
            transition: transform var(--transition-duration) ease, box-shadow var(--transition-duration) ease;
            animation: zoomIn 0.7s ease-out;
        }

        .feature-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 6px 12px var(--shadow-color);
        }

        .feature-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1.25rem;
        }

        .feature-card h3 {
            font-size: 1.6rem;
            color: var(--secondary-color);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        /* Announcements Section Styles */
        .recent-announcements {
            padding: 5rem 0;
            background-color: var(--light-color);
        }

        .announcements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(370px, 1fr));
            gap: 3rem;
        }

        .announcement-card {
            background-color: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 4px 8px var(--shadow-color);
            transition: transform var(--transition-duration) ease, box-shadow var(--transition-duration) ease;
            animation: fadeInUp 0.8s ease-out;
        }

        .announcement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px var(--shadow-color);
        }

        .announcement-image {
            height: 250px;
            background-color: #ddd;
            position: relative;
            overflow: hidden;
        }

        .announcement-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-duration) ease;
        }

        .announcement-card:hover .announcement-image img {
            transform: scale(1.1);
        }

        .announcement-date {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 0.85rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .announcement-details {
            padding: 2rem;
        }

        .announcement-details h3 {
            font-size: 1.4rem;
            color: var(--secondary-color);
            margin-bottom: 0.75rem;
            font-weight: 600;
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

            .hero h2 {
                font-size: 3rem;
            }

            .hero p {
                font-size: 1.2rem;
            }

            .features-grid,
            .announcements-grid {
                grid-template-columns: 1fr;
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
                        <img src="mariage.jpg" alt="Sarah Mutombo & Jean Mukendi">
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
                        <img src="mariage.jpg" alt="Marie Ngalula & Paul Ilunga">
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
                        <img src="mariage.jpg" alt="Sophie Nkandu & Marc Lukeba">
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