<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registre Mariages Civils - Détails Personne</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Public Sans", sans-serif;
            background: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: #fff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e5e5e5;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-diamond {
            width: 32px;
            height: 32px;
            background: linear-gradient(45deg, #1976d2, #42a5f5);
            transform: rotate(45deg);
            margin-right: 15px;
            border-radius: 4px;
            position: relative;
        }

        .logo-diamond::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 1px;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 600;
            color: #1976d2;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 30px;
        }

        .nav-section-title {
            padding: 0 20px;
            font-size: 12px;
            font-weight: 600;
            color: #8a92a6;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover,
        .nav-item.active {
            background: #f8f9fa;
            color: #1976d2;
            border-left-color: #1976d2;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: #fff;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            padding: 8px 40px 8px 15px;
            border: 1px solid #ddd;
            border-radius: 20px;
            width: 250px;
            font-size: 14px;
        }

        .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(45deg, #1976d2, #42a5f5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        /* Page Content */
        .page-content {
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 600;
            color: #333;
        }

        .page-title-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(45deg, #1976d2, #42a5f5);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #666;
        }

        .breadcrumb a {
            color: #1976d2;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .page-actions {
            display: flex;
            gap: 10px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge.active {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge.inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Details Container */
        .details-container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }

        /* Photo Card */
        .photo-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            height: fit-content;
            text-align: center;
        }

        .person-photo {
            width: 200px;
            height: 200px;
            border-radius: 12px;
            object-fit: cover;
            margin: 0 auto 20px;
            display: block;
            border: 3px solid #e5e5e5;
        }

        .photo-placeholder {
            width: 200px;
            height: 200px;
            border: 2px dashed #ddd;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #666;
            font-size: 14px;
            text-align: center;
            margin: 0 auto 20px;
        }

        .person-name {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .person-id {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .person-type {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #f0f7ff;
            color: #1976d2;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        /* Info Container */
        .info-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .info-header {
            padding: 25px 30px;
            border-bottom: 1px solid #e5e5e5;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: between;
        }

        .info-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            flex: 1;
        }

        .info-content {
            padding: 30px;
        }

        /* Info Sections */
        .info-sections {
            display: flex;
            flex-direction: column;
            gap: 35px;
        }

        .info-section {
            position: relative;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e5e5;
        }

        .section-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-grid.full-width {
            grid-template-columns: 1fr;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .info-label {
            font-size: 14px;
            font-weight: 500;
            color: #666;
        }

        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        .info-value.empty {
            color: #999;
            font-style: italic;
        }
        /* Action Buttons */
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #1976d2;
            color: white;
        }

        .btn-primary:hover {
            background: #1565c0;
            transform: translateY(-1px);
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-outline {
            background: transparent;
            color: #666;
            border: 1px solid #ddd;
        }

        .btn-outline:hover {
            background: #f8f9fa;
            border-color: #1976d2;
            color: #1976d2;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .details-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .main-content {
                margin-left: 0;
            }

            .page-content {
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .page-actions {
                width: 100%;
            }

            .btn {
                flex: 1;
                justify-content: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .person-photo,
            .photo-placeholder {
                width: 150px;
                height: 150px;
            }
        }
    </style>
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
                <a href="#" class="nav-item">
                    <span class="nav-icon">📊</span>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon">💒</span>
                    Mariages
                </a>
                <a href="#" class="nav-item active">
                    <span class="nav-icon">👥</span>
                    Personnes
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon">👨‍⚖️</span>
                    Officiers
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Gestion</div>
                <a href="#" class="nav-item">
                    <span class="nav-icon">🏛️</span>
                    Communes
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon">👨‍👩‍👧‍👦</span>
                    Parents
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon">✍️</span>
                    Témoins
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <h1 class="header-title">Détails Personne</h1>
            <div class="header-actions">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Rechercher...">
                    <span class="search-icon">🔍</span>
                </div>
                <div class="user-profile">
                    <div class="user-avatar">OC</div>
                    <span>Officier Civil</span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <div class="page-title-icon">👤</div>
                    <div>
                        <h1>Marie MBEMBA</h1>
                        <div class="breadcrumb">
                            <a href="#">Personnes</a>
                            <span>→</span>
                            <span>Marie MBEMBA</span>
                        </div>
                    </div>
                </div>
                <div class="page-actions">
                    <button class="btn btn-primary">
                        ✏️ Modifier
                    </button>
                </div>
            </div>

            <!-- Details Container -->
            <div class="details-container">
                <!-- Photo Card -->
                <div class="photo-card">
                    <div class="photo-placeholder">
                        📷<br>
                        Aucune photo<br>
                        disponible
                    </div>
                    <!-- Alternative si photo disponible:
                    <img src="photo.jpg" alt="Marie MBEMBA" class="person-photo">
                    -->
                    
                    <h2 class="person-name">Marie MBEMBA</h2>
                    <div class="person-id">ID: PER-2024-001</div>
                    <div class="person-type">
                        <span>👩</span>
                        Femme
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <div class="status-badge active">
                            ✅ Actif
                        </div>
                    </div>
                </div>

                <!-- Info Container -->
                <div class="info-container">
                    <div class="info-header">
                        <h2>Informations Détaillées</h2>
                        <div class="status-badge active">
                            Dernière mise à jour: 15/06/2025
                        </div>
                    </div>

                    <div class="info-content">
                        <div class="info-sections">
                            <!-- Informations Personnelles -->
                            <div class="info-section">
                                <div class="section-title">
                                    <span class="section-icon">👤</span>
                                    Informations Personnelles
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Nom complet</div>
                                        <div class="info-value">Marie MBEMBA</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Sexe</div>
                                        <div class="info-value">Femme</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">État civil</div>
                                        <div class="info-value">Célibataire</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Âge</div>
                                        <div class="info-value">28 ans</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Naissance et Origine -->
                            <div class="info-section">
                                <div class="section-title">
                                    <span class="section-icon">🎂</span>
                                    Naissance et Origine
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Date de naissance</div>
                                        <div class="info-value">15 mars 1996</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Lieu de naissance</div>
                                        <div class="info-value">Brazzaville, République du Congo</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Nationalité</div>
                                        <div class="info-value">Congolaise</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Région d'origine</div>
                                        <div class="info-value empty">Non renseigné</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations Professionnelles -->
                            <div class="info-section">
                                <div class="section-title">
                                    <span class="section-icon">💼</span>
                                    Informations Professionnelles
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Profession</div>
                                        <div class="info-value">Enseignante</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Secteur d'activité</div>
                                        <div class="info-value">Éducation</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Employeur</div>
                                        <div class="info-value empty">Non renseigné</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Statut professionnel</div>
                                        <div class="info-value">Actif</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Adresse -->
                            <div class="info-section">
                                <div class="section-title">
                                    <span class="section-icon">📍</span>
                                    Adresse de Résidence
                                </div>
                                <div class="info-grid full-width">
                                    <div class="info-item">
                                        <div class="info-label">Adresse complète</div>
                                        <div class="info-value">123 Avenue de l'Indépendance, Quartier Moungali, Brazzaville, République du Congo</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>