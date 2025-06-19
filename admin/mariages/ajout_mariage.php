<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registre Mariages Civils - Nouveau Mariage</title>
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
            <h1 class="header-title">Nouveau Mariage</h1>
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
                    <div class="page-title-icon"><i class="fas fa-plus"></i></div>
                    <div>
                        <h1>Ajouter un Nouveau Mariage</h1>
                        <div class="breadcrumb">
                            <a href="#">Mariages</a>
                            <span>→</span>
                            <span>Nouveau mariage</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h2>Informations du Mariage</h2>
                    <p>Veuillez remplir tous les champs requis pour enregistrer un nouveau mariage dans le système.</p>
                </div>

                <div class="form-content">
                    <form id="mariageForm" class="form-sections">

                        <!-- Informations Générales -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-info-circle"></i></span>
                                Informations Générales
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Numéro d'acte <span class="required">*</span></label>
                                    <input type="text" class="form-input" name="numero_acte_mariage" required placeholder="Ex: ACT-2024-001">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Date de célébration <span class="required">*</span></label>
                                    <input type="date" class="form-input" name="date_celebration" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Heure de célébration <span class="required">*</span></label>
                                    <input type="time" class="form-input" name="heure_celebration" required>
                                </div>
                            </div>
                        </div>

                        <!-- Époux et Épouse -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-users"></i></span>
                                Époux et Épouse
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Époux <span class="required">*</span></label>
                                    <select class="form-select" name="id_epoux" required>
                                        <option value="">Sélectionner l'époux</option>
                                        <!-- Options seront chargées dynamiquement depuis la base de données -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Épouse <span class="required">*</span></label>
                                    <select class="form-select" name="id_epouse" required>
                                        <option value="">Sélectionner l'épouse</option>
                                        <!-- Options seront chargées dynamiquement depuis la base de données -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Informations Supplémentaires -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-file-alt"></i></span>
                                Informations Supplémentaires
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Officier de célébration <span class="required">*</span></label>
                                    <select class="form-select" name="id_officier_celebration" required>
                                        <option value="">Sélectionner l'officier</option>
                                        <!-- Options seront chargées dynamiquement depuis la base de données -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Commune de célébration <span class="required">*</span></label>
                                    <select class="form-select" name="id_commune_celebration" required>
                                        <option value="">Sélectionner la commune</option>
                                        <!-- Options seront chargées dynamiquement depuis la base de données -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Régime matrimonial</label>
                                    <input type="text" class="form-input" name="regime_matrimonial" placeholder="Ex: Communauté réduite aux acquêts">
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="#" class="btn btn-outline">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Créer le Mariage
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>