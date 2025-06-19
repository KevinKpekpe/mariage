<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registre Mariages Civils - Nouvelle Personne</title>
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
                <a href="#" class="nav-item active">
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
            <h1 class="header-title">Nouvel Officier</h1>
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
                        <h1>Ajouter un Nouvel Officier</h1>
                        <div class="breadcrumb">
                            <a href="#">Officiers</a>
                            <span>→</span>
                            <span>Nouvel officier</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h2>Informations de l'Officier</h2>
                    <p>Veuillez remplir tous les champs requis pour enregistrer un nouvel officier dans le système.</p>
                </div>

                <div class="form-content">
                    <form id="officierForm" class="form-sections">
                        <!-- Photo Section -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-camera"></i></span>
                                Photo d'Identité
                            </div>
                            <div class="photo-upload-section">
                                <div class="photo-preview">
                                    <div class="photo-placeholder" id="photoPlaceholder" onclick="document.getElementById('photoInput').click()">
                                        <div>
                                            <i class="fas fa-camera"></i><br>
                                            Cliquez pour ajouter<br>
                                            une photo
                                        </div>
                                    </div>
                                    <input type="file" id="photoInput" class="photo-upload-input" accept="image/*">
                                    <div class="photo-actions" id="photoActions" style="display: none;">
                                        <button type="button" class="photo-upload-btn" onclick="document.getElementById('photoInput').click()">
                                            Changer
                                        </button>
                                        <button type="button" class="photo-upload-btn remove" onclick="removePhoto()">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group" style="flex: 1;">
                                    <p class="form-help">
                                        • Format accepté : JPG, PNG (max 2MB)<br>
                                        • Dimensions recommandées : 300x300px<br>
                                        • Photo récente en couleur sur fond clair
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Informations Personnelles -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-user"></i></span>
                                Informations Personnelles
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Nom <span class="required">*</span></label>
                                    <input type="text" class="form-input" name="nom" required placeholder="Nom de famille">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Prénom <span class="required">*</span></label>
                                    <input type="text" class="form-input" name="prenom" required placeholder="Prénom(s)">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Matricule</label>
                                    <input type="text" class="form-input" name="matricule" placeholder="Numéro de matricule">
                                    <div class="form-help">Si applicable</div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations de Contact -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-envelope"></i></span>
                                Informations de Contact
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Email <span class="required">*</span></label>
                                    <input type="email" class="form-input" name="email" required placeholder="Adresse email">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Téléphone</label>
                                    <input type="tel" class="form-input" name="telephone" placeholder="Numéro de téléphone">
                                </div>
                            </div>
                        </div>

                        <!-- Informations de Compte -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-lock"></i></span>
                                Informations de Compte
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Mot de Passe <span class="required">*</span></label>
                                    <input type="password" class="form-input" name="mot_de_passe" required placeholder="Mot de passe">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirmer le Mot de Passe <span class="required">*</span></label>
                                    <input type="password" class="form-input" name="confirmer_mot_de_passe" required placeholder="Confirmer le mot de passe">
                                </div>
                            </div>
                        </div>

                        <!-- Affectation -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-city"></i></span>
                                Affectation
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Commune <span class="required">*</span></label>
                                    <select class="form-select" name="commune" required>
                                        <option value="">Sélectionner la commune</option>
                                        <option value="Kinshasa">Kinshasa</option>
                                        <option value="Lubumbashi">Lubumbashi</option>
                                        <!-- Ajouter d'autres communes ici -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Rôle <span class="required">*</span></label>
                                    <select class="form-select" name="role" required>
                                        <option value="">Sélectionner le rôle</option>
                                        <option value="officier_communal">Officier Communal</option>
                                        <option value="admin">Administrateur</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Adresse -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-map-marker-alt"></i></span>
                                Adresse Actuelle
                            </div>
                            <div class="form-grid full-width">
                                <div class="form-group">
                                    <label class="form-label">Adresse Complète</label>
                                    <textarea class="form-textarea" name="adresse_actuelle" placeholder="Numéro, rue, quartier, commune, ville..."></textarea>
                                    <div class="form-help">Adresse de résidence actuelle complète</div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="#" class="btn btn-outline">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Créer l'Officier
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="main.js"></script>
</body>
</html>

