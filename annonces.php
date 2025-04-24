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
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #17a2b8;
            --secondary-color: #343a40;
            --accent-color: #ffc107;
            --light-color: #e9ecef;
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

        .announcements {
            padding: 5rem 0;
        }

        .search-block {
            margin-bottom: 3rem;
            text-align: center;
        }

        .search-block form {
            display: inline-flex;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 4px 8px var(--shadow-color);
            animation: slideInDown 0.8s ease-out;
        }

        .search-block input {
            padding: 1.25rem;
            border: none;
            font-size: 1.1rem;
            font-family: var(--font-family);
            outline: none;
        }

        .search-block button {
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

        .search-block button:hover {
            background-color: #e0a800;
            color: var(--dark-color);
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
            position: relative;
        }

        .announcement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px var(--shadow-color);
        }

        .announcement-photos {
            display: flex;
            justify-content: space-around;
            padding: 1rem;
        }

        .photo-container {
            width: 45%;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 2px 4px var(--shadow-color);
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
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

        .objection-link {
            margin-top: 1.5rem;
            text-align: center;
        }

        .objection-link a {
            display: inline-block;
            background-color: var(--accent-color);
            color: var(--dark-color);
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: background-color var(--transition-duration) ease, color var(--transition-duration) ease;
        }

        .objection-link a:hover {
            background-color: #e0a800;
            color: var(--dark-color);
        }

        .no-results {
            text-align: center;
            font-size: 1.2rem;
            color: var(--text-color);
        }

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

            .announcements-grid {
                grid-template-columns: 1fr;
            }

            .announcement-photos {
                flex-direction: column;
                align-items: center;
            }

            .photo-container {
                width: 100%;
                margin-bottom: 1rem;
            }

            .search-block form {
                flex-direction: column;
                align-items: stretch;
            }

            .search-block input {
                margin-bottom: 1rem;
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
                            <img src="person1.jpg" alt="Photo de Personne 1">
                        </div>
                        <div class="photo-container">
                            <img src="person2.jpg" alt="Photo de Personne 2">
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
                            <img src="person1.jpg" alt="Photo de Personne 3">
                        </div>
                        <div class="photo-container">
                            <img src="person2.jpg" alt="Photo de Personne 4">
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
                            <img src="person1.jpg" alt="Photo de Personne 5">
                        </div>
                        <div class="photo-container">
                            <img src="person2.jpg" alt="Photo de Personne 6">
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