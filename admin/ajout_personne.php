<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registre Mariages Civils - Nouvelle Personne</title>
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
            background: linear-gradient(45deg, #10b981, #34d399);
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

        /* Form Container */
        .form-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-header {
            padding: 25px 30px;
            border-bottom: 1px solid #e5e5e5;
            background: #f8f9fa;
        }

        .form-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .form-header p {
            color: #666;
            font-size: 14px;
        }

        .form-content {
            padding: 30px;
        }

        /* Form Layout */
        .form-sections {
            display: flex;
            flex-direction: column;
            gap: 35px;
        }

        .form-section {
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .form-grid.full-width {
            grid-template-columns: 1fr;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .required {
            color: #dc2626;
        }

        .form-input,
        .form-select,
        .form-textarea {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #1976d2;
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-help {
            font-size: 12px;
            color: #666;
        }

        /* Photo Upload Section */
        .photo-upload-section {
            display: flex;
            gap: 25px;
            align-items: flex-start;
        }

        .photo-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .photo-placeholder {
            width: 120px;
            height: 120px;
            border: 2px dashed #ddd;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #666;
            font-size: 14px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .photo-placeholder:hover {
            border-color: #1976d2;
            color: #1976d2;
        }

        .photo-placeholder.has-image {
            border-style: solid;
            border-color: #10b981;
            padding: 0;
            overflow: hidden;
        }

        .photo-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-upload-input {
            display: none;
        }

        .photo-upload-btn {
            background: #1976d2;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .photo-upload-btn:hover {
            background: #1565c0;
        }

        .photo-upload-btn.remove {
            background: #dc2626;
        }

        .photo-upload-btn.remove:hover {
            background: #b91c1c;
        }

        /* Type Selection */
        .type-selection {
            display: flex;
            gap: 15px;
        }

        .type-option {
            flex: 1;
            position: relative;
        }

        .type-radio {
            display: none;
        }

        .type-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            border: 2px solid #e5e5e5;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .type-radio:checked + .type-label {
            border-color: #1976d2;
            background: #f0f7ff;
            color: #1976d2;
        }

        .type-icon {
            font-size: 20px;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            padding-top: 25px;
            border-top: 1px solid #e5e5e5;
            margin-top: 30px;
        }

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
            background: #10b981;
            color: white;
        }

        .btn-primary:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
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

        /* Success/Error Messages */
        .message {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .message.success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .message.error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Responsive */
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

            .form-content {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .photo-upload-section {
                flex-direction: column;
                align-items: center;
            }

            .type-selection {
                flex-direction: column;
            }

            .form-actions {
                flex-direction: column;
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
            <h1 class="header-title">Nouvelle Personne</h1>
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
                    <div class="page-title-icon">➕</div>
                    <div>
                        <h1>Ajouter une Nouvelle Personne</h1>
                        <div class="breadcrumb">
                            <a href="#">Personnes</a>
                            <span>→</span>
                            <span>Nouvelle personne</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h2>Informations de la Personne</h2>
                    <p>Veuillez remplir tous les champs requis pour enregistrer une nouvelle personne dans le système.</p>
                </div>

                <div class="form-content">
                    <form id="personForm" class="form-sections">
                        <!-- Photo Section -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon">📸</span>
                                Photo d'Identité
                            </div>
                            <div class="photo-upload-section">
                                <div class="photo-preview">
                                    <div class="photo-placeholder" id="photoPlaceholder" onclick="document.getElementById('photoInput').click()">
                                        <div>
                                            📷<br>
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
                                    <label class="form-label">Type de Personne <span class="required">*</span></label>
                                    <div class="type-selection">
                                        <div class="type-option">
                                            <input type="radio" id="homme" name="type_personne" value="homme" class="type-radio" required>
                                            <label for="homme" class="type-label">
                                                <span class="type-icon">👨</span>
                                                Homme
                                            </label>
                                        </div>
                                        <div class="type-option">
                                            <input type="radio" id="femme" name="type_personne" value="femme" class="type-radio" required>
                                            <label for="femme" class="type-label">
                                                <span class="type-icon">👩</span>
                                                Femme
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Naissance et Origine -->
                        <div class="form-section">
                            <div class="section-title">
                              
                                Naissance et Origine
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Date de Naissance</label>
                                    <input type="date" class="form-input" name="date_naissance">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Lieu de Naissance</label>
                                    <input type="text" class="form-input" name="lieu_naissance" placeholder="Ville, Province/État, Pays">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nationalité <span class="required">*</span></label>
                                    <select class="form-select" name="nationalite" required>
                                        <option value="">Sélectionner la nationalité</option>
                                        <option value="Congolaise" selected>Congolaise</option>
                                        <option value="Française">Française</option>
                                        <option value="Belge">Belge</option>
                                        <option value="Américaine">Américaine</option>
                                        <option value="Canadienne">Canadienne</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Informations Professionnelles -->
                        <div class="form-section">
                            <div class="section-title">
                             
                                Informations Professionnelles
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Profession</label>
                                    <input type="text" class="form-input" name="profession" placeholder="Ex: Enseignant, Médecin, Ingénieur...">
                                    <div class="form-help">Profession actuelle ou principale activité</div>
                                </div>
                            </div>
                        </div>

                        <!-- Adresse -->
                        <div class="form-section">
                            <div class="section-title">
                
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
                                Créer la Personne
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Photo upload handling
        document.getElementById('photoInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('La taille du fichier ne doit pas dépasser 2MB.');
                    return;
                }

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Veuillez sélectionner un fichier image valide.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const placeholder = document.getElementById('photoPlaceholder');
                    placeholder.innerHTML = `<img src="${e.target.result}" alt="Photo">`;
                    placeholder.classList.add('has-image');
                    document.getElementById('photoActions').style.display = 'flex';
                };
                reader.readAsDataURL(file);
            }
        });

        function removePhoto() {
            const placeholder = document.getElementById('photoPlaceholder');
            placeholder.innerHTML = `
                <div>
                    📷<br>
                    Cliquez pour ajouter<br>
                    une photo
                </div>
            `;
            placeholder.classList.remove('has-image');
            document.getElementById('photoInput').value = '';
            document.getElementById('photoActions').style.display = 'none';
        }
    </script>

</body>
</html>
