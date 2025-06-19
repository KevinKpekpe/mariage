<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registre Mariages Civils - Détails Officier</title>
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
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-heart"></i></span>
                    Mariages
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-users"></i></span>
                    Personnes
                </a>
                <a href="#" class="nav-item active">
                    <span class="nav-icon"><i class="fas fa-user-tie"></i></span>
                    Officiers
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Gestion</div>
                <a href="#" class="nav-item">
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
            <h1 class="header-title">Détails Officier</h1>
            <div class="header-actions">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Rechercher...">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
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
                    <div class="page-title-icon"><i class="fas fa-user-tie"></i></div>
                    <div>
                        <h1>Jean Dupont</h1>
                        <div class="breadcrumb">
                            <a href="#">Officiers</a>
                            <span>→</span>
                            <span>Jean Dupont</span>
                        </div>
                    </div>
                </div>
                <div class="page-actions">
                    <button class="btn btn-primary">
                        <i class="fas fa-edit"></i> Modifier
                    </button>
                </div>
            </div>

            <!-- Details Container -->
            <div class="details-container">
                <!-- Photo Card -->
                <div class="photo-card">
                    <div class="photo-placeholder">
                        <i class="fas fa-camera"></i><br>
                        Aucune photo<br>
                        disponible
                    </div>
                    <!-- Alternative si photo disponible:
                    <img src="photo.jpg" alt="Jean Dupont" class="person-photo">
                    -->

                    <h2 class="person-name">Jean Dupont</h2>
                    <div class="person-id">ID: OFF-2024-001</div>
                    <div class="person-type">
                        <span><i class="fas fa-user-tie"></i></span>
                        Officier Civil
                    </div>

                    <div style="margin-top: 20px;">
                        <div class="status-badge active">
                            <i class="fas fa-check-circle"></i> Actif
                        </div>
                    </div>
                </div>

                <!-- Info Container -->
                <div class="info-container">
                    <div class="info-header">
                        <h2>Informations Détaillées</h2>
                        <div class="status-badge active">
                            Dernière mise à jour: 15/06/2024
                        </div>
                    </div>

                    <div class="info-content">
                        <div class="info-sections">
                            <!-- Informations Personnelles -->
                            <div class="info-section">
                                <div class="section-title">
                                    <span class="section-icon"><i class="fas fa-user"></i></span>
                                    Informations Personnelles
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Nom complet</div>
                                        <div class="info-value">Jean Dupont</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Sexe</div>
                                        <div class="info-value">Homme</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Matricule</div>
                                        <div class="info-value">MAT-2024-001</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Rôle</div>
                                        <div class="info-value">Officier Civil</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Naissance et Origine -->
                            <div class="info-section">
                                <div class="section-title">
                                    <span class="section-icon"><i class="fas fa-birthday-cake"></i></span>
                                    Naissance et Origine
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Date de naissance</div>
                                        <div class="info-value">10 avril 1980</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Lieu de naissance</div>
                                        <div class="info-value">Paris, France</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Nationalité</div>
                                        <div class="info-value">Française</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations de Contact -->
                            <div class="info-section">
                                <div class="section-title">
                                    <span class="section-icon"><i class="fas fa-envelope"></i></span>
                                    Informations de Contact
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Email</div>
                                        <div class="info-value">jean.dupont@example.com</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Téléphone</div>
                                        <div class="info-value">+33 1 23 45 67 89</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Adresse -->
                            <div class="info-section">
                                <div class="section-title">
                                    <span class="section-icon"><i class="fas fa-map-marker-alt"></i></span>
                                    Adresse de Résidence
                                </div>
                                <div class="info-grid full-width">
                                    <div class="info-item">
                                        <div class="info-label">Adresse complète</div>
                                        <div class="info-value">10 Rue de la Mairie, 75001 Paris, France</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Commune -->
                            <div class="info-section">
                                <div class="section-title">
                                    <span class="section-icon"><i class="fas fa-city"></i></span>
                                    Commune d'affectation
                                </div>
                                <div class="info-grid full-width">
                                    <div class="info-item">
                                        <div class="info-label">Commune</div>
                                        <div class="info-value">Paris 1er Arrondissement</div>
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