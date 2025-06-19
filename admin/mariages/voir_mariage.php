<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registre Mariages Civils - Détails Mariage</title>
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
                <a href="#" class="nav-item active">
                    <span class="nav-icon"><i class="fas fa-heart"></i></span>
                    Mariages
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-users"></i></span>
                    Personnes
                </a>
                <a href="#" class="nav-item">
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
            <h1 class="header-title">Détails Mariage</h1>
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
                    <div class="page-title-icon"><i class="fas fa-heart"></i></div>
                    <div>
                        <h1>Mariage ACT-2024-001</h1>
                        <div class="breadcrumb">
                            <a href="#">Mariages</a>
                            <span>→</span>
                            <span>ACT-2024-001</span>
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

                <!-- Info Container -->
                <div class="info-container">
                    <div class="info-header">
                        <h2>Informations Détaillées</h2>
                        <div class="status-badge active">
                            Dernière mise à jour: 16/07/2024
                        </div>
                    </div>

                    <div class="info-content">
                        <div class="info-sections">
                            <!-- Informations Générales -->
                            <div class="info-section">
                                <div class="section-title">
                                    <span class="section-icon"><i class="fas fa-info-circle"></i></span>
                                    Informations Générales
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Numéro d'acte</div>
                                        <div class="info-value">ACT-2024-001</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Date de célébration</div>
                                        <div class="info-value">15 juillet 2024</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Heure de célébration</div>
                                        <div class="info-value">11:00</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">État de l'acte</div>
                                        <div class="info-value">
                                            <span class="person-type-badge homme">Actif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Époux et Épouse -->
                            <div class="info-section">
                                <div class="section-title">
                                    <span class="section-icon"><i class="fas fa-users"></i></span>
                                    Époux et Épouse
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Époux</div>
                                        <div class="info-value">Jean Dupont</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Épouse</div>
                                        <div class="info-value">Marie Mbemba</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations Supplémentaires -->
                            <div class="info-section">
                                <div class="section-title">
                                    <span class="section-icon"><i class="fas fa-file-alt"></i></span>
                                    Informations Supplémentaires
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Officier de célébration</div>
                                        <div class="info-value">Pierre Martin</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Commune de célébration</div>
                                        <div class="info-value">Kinshasa</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Régime matrimonial</div>
                                        <div class="info-value">Communauté réduite aux acquêts</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dissolution/Annulation (si applicable) -->
                            <div class="info-section" style="display: none;">
                                <div class="section-title">
                                    <span class="section-icon"><i class="fas fa-times-circle"></i></span>
                                    Dissolution / Annulation
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Date de dissolution/annulation</div>
                                        <div class="info-value">N/A</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Motif de dissolution/annulation</div>
                                        <div class="info-value">N/A</div>
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