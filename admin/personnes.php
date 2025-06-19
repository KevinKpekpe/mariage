<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registre Mariages Civils - Personnes</title>
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
            background: linear-gradient(45deg, #8b5cf6, #a78bfa);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .add-person-btn {
            background: #10b981;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .add-person-btn:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        /* Filters Section */
        .filters-section {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        .filters-row {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-label {
            font-size: 12px;
            font-weight: 500;
            color: #666;
            text-transform: uppercase;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            background: white;
            min-width: 150px;
        }

        .search-filter {
            flex: 1;
        }

        .search-filter .search-input {
            width: 100%;
            border-radius: 6px;
        }

        /* Table Section */
        .table-section {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e5e5e5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .table-count {
            font-size: 14px;
            color: #666;
            background: #f1f5f9;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .persons-table {
            width: 100%;
            border-collapse: collapse;
        }

        .persons-table th {
            background: #f8f9fa;
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: #333;
            font-size: 14px;
            border-bottom: 1px solid #e5e5e5;
        }

        .persons-table td {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }

        .persons-table tr:hover {
            background: #f8f9fa;
        }

        .person-photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e5e5;
        }

        .person-photo.placeholder {
            background: linear-gradient(45deg, #94a3b8, #cbd5e1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .person-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 3px;
        }

        .person-details {
            font-size: 12px;
            color: #666;
        }

        .person-type-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            text-transform: capitalize;
        }

        .person-type-badge.homme {
            background: #dbeafe;
            color: #1976d2;
        }

        .person-type-badge.femme {
            background: #fce7f3;
            color: #ec4899;
        }

        .actions-cell {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .action-btn.view {
            background: #e0f2fe;
            color: #0277bd;
        }

        .action-btn.edit {
            background: #fff3cd;
            color: #b45309;
        }

        .action-btn.delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .action-btn:hover {
            transform: translateY(-1px);
        }

        /* Pagination */
        .pagination {
            padding: 20px 25px;
            display: flex;
            justify-content: between;
            align-items: center;
            border-top: 1px solid #e5e5e5;
        }

        .pagination-info {
            font-size: 14px;
            color: #666;
        }

        .pagination-controls {
            display: flex;
            gap: 5px;
        }

        .pagination-btn {
            padding: 6px 12px;
            border: 1px solid #ddd;
            background: white;
            color: #666;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }

        .pagination-btn:hover,
        .pagination-btn.active {
            background: #1976d2;
            color: white;
            border-color: #1976d2;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 20px;
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

            .filters-row {
                flex-direction: column;
                align-items: stretch;
            }

            .persons-table {
                font-size: 12px;
            }

            .persons-table th,
            .persons-table td {
                padding: 10px;
            }

            .page-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
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
            <h1 class="header-title">Personnes</h1>
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
                    <div class="page-title-icon">👥</div>
                    <h1>Liste des Personnes</h1>
                </div>
                <a href="#" class="add-person-btn">
                    <span>➕</span>
                    Ajouter une Personne
                </a>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <div class="filters-row">
                    <div class="filter-group search-filter">
                        <label class="filter-label">Rechercher</label>
                        <div class="search-box">
                            <input type="text" class="search-input" placeholder="Nom, prénom, profession..." id="searchInput">
                            <span class="search-icon">🔍</span>
                        </div>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Type</label>
                        <select class="filter-select" id="typeFilter">
                            <option value="">Tous</option>
                            <option value="homme">Homme</option>
                            <option value="femme">Femme</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Nationalité</label>
                        <select class="filter-select" id="nationalityFilter">
                            <option value="">Toutes</option>
                            <option value="Congolaise">Congolaise</option>
                            <option value="Française">Française</option>
                            <option value="Belge">Belge</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h2 class="table-title">Personnes Enregistrées</h2>
                    <div class="table-count" id="personCount">2,894 personnes</div>
                </div>

                <table class="persons-table">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Nom & Prénom</th>
                            <th>Type</th>
                            <th>Date de Naissance</th>
                            <th>Lieu de Naissance</th>
                            <th>Nationalité</th>
                            <th>Profession</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="personsTableBody">
                        <!-- Sample data -->
                        <tr>
                            <td>
                                <div class="person-photo placeholder">ML</div>
                            </td>
                            <td>
                                <div class="person-name">MBALA Lucie</div>
                                <div class="person-details">ID: 00001</div>
                            </td>
                            <td>
                                <span class="person-type-badge femme">Femme</span>
                            </td>
                            <td>15/03/1992</td>
                            <td>Kinshasa</td>
                            <td>Congolaise</td>
                            <td>Infirmière</td>
                            <td>
                                <div class="actions-cell">
                                    <button class="action-btn view">👁️</button>
                                    <button class="action-btn edit">✏️</button>
                                    <button class="action-btn delete">🗑️</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="person-photo placeholder">KJ</div>
                            </td>
                            <td>
                                <div class="person-name">KABONGO Jean</div>
                                <div class="person-details">ID: 00002</div>
                            </td>
                            <td>
                                <span class="person-type-badge homme">Homme</span>
                            </td>
                            <td>22/08/1988</td>
                            <td>Lubumbashi</td>
                            <td>Congolaise</td>
                            <td>Ingénieur</td>
                            <td>
                                <div class="actions-cell">
                                    <button class="action-btn view">👁️</button>
                                    <button class="action-btn edit">✏️</button>
                                    <button class="action-btn delete">🗑️</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="person-photo placeholder">NM</div>
                            </td>
                            <td>
                                <div class="person-name">NGUYEN Marie</div>
                                <div class="person-details">ID: 00003</div>
                            </td>
                            <td>
                                <span class="person-type-badge femme">Femme</span>
                            </td>
                            <td>07/12/1990</td>
                            <td>Paris, France</td>
                            <td>Française</td>
                            <td>Professeure</td>
                            <td>
                                <div class="actions-cell">
                                    <button class="action-btn view">👁️</button>
                                    <button class="action-btn edit">✏️</button>
                                    <button class="action-btn delete">🗑️</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination-info">
                        Affichage de 1-20 sur 2,894 personnes
                    </div>
                    <div class="pagination-controls">
                        <button class="pagination-btn" disabled>‹ Précédent</button>
                        <button class="pagination-btn active">1</button>
                        <button class="pagination-btn">2</button>
                        <button class="pagination-btn">3</button>
                        <button class="pagination-btn">...</button>
                        <button class="pagination-btn">145</button>
                        <button class="pagination-btn">Suivant ›</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample persons data (in a real app, this would come from your database)
        const personsData = [
            {
                id: 1,
                nom: 'MBALA',
                prenom: 'Lucie',
                type_personne: 'femme',
                date_naissance: '1992-03-15',
                lieu_naissance: 'Kinshasa',
                nationalite: 'Congolaise',
                profession: 'Infirmière',
                photo: null
            },
            {
                id: 2,
                nom: 'KABONGO',
                prenom: 'Jean',
                type_personne: 'homme',
                date_naissance: '1988-08-22',
                lieu_naissance: 'Lubumbashi',
                nationalite: 'Congolaise',
                profession: 'Ingénieur',
                photo: null
            },
            {
                id: 3,
                nom: 'NGUYEN',
                prenom: 'Marie',
                type_personne: 'femme',
                date_naissance: '1990-12-07',
                lieu_naissance: 'Paris, France',
                nationalite: 'Française',
                profession: 'Professeure',
                photo: null
            }
        ];

        // Function to format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR');
        }

        // Function to get initials from name
        function getInitials(nom, prenom) {
            return (nom.charAt(0) + (prenom ? prenom.charAt(0) : '')).toUpperCase();
        }

        // Function to render persons table
        function renderPersonsTable(persons) {
            const tableBody = document.getElementById('personsTableBody');
            
            if (persons.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon">👥</div>
                                <h3>Aucune personne trouvée</h3>
                                <p>Aucune personne ne correspond à vos critères de recherche.</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = persons.map(person => `
                <tr>
                    <td>
                        ${person.photo ? 
                            `<img src="${person.photo}" alt="${person.nom}" class="person-photo">` :
                            `<div class="person-photo placeholder">${getInitials(person.nom, person.prenom)}</div>`
                        }
                    </td>
                    <td>
                        <div class="person-name">${person.nom} ${person.prenom || ''}</div>
                        <div class="person-details">ID: ${String(person.id).padStart(5, '0')}</div>
                    </td>
                    <td>
                        <span class="person-type-badge ${person.type_personne}">${person.type_personne.charAt(0).toUpperCase() + person.type_personne.slice(1)}</span>
                    </td>
                    <td>${person.date_naissance ? formatDate(person.date_naissance) : '-'}</td>
                    <td>${person.lieu_naissance || '-'}</td>
                    <td>${person.nationalite}</td>
                    <td>${person.profession || '-'}</td>
                    <td>
                        <div class="actions-cell">
                            <button class="action-btn view" onclick="viewPerson(${person.id})" title="Voir">👁️</button>
                            <button class="action-btn edit" onclick="editPerson(${person.id})" title="Modifier">✏️</button>
                            <button class="action-btn delete" onclick="deletePerson(${person.id})" title="Supprimer">🗑️</button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Filter functions
        function filterPersons() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const typeFilter = document.getElementById('typeFilter').value;
            const nationalityFilter = document.getElementById('nationalityFilter').value;

            const filteredPersons = personsData.filter(person => {
                const matchesSearch = !searchTerm || 
                    person.nom.toLowerCase().includes(searchTerm) ||
                    (person.prenom && person.prenom.toLowerCase().includes(searchTerm)) ||
                    (person.profession && person.profession.toLowerCase().includes(searchTerm));
                
                const matchesType = !typeFilter || person.type_personne === typeFilter;
                const matchesNationality = !nationalityFilter || person.nationalite === nationalityFilter;

                return matchesSearch && matchesType && matchesNationality;
            });

            renderPersonsTable(filteredPersons);
            updatePersonCount(filteredPersons.length);
        }

        // Update person count
        function updatePersonCount(count) {
            document.getElementById('personCount').textContent = 
                `${count.toLocaleString()} personne${count > 1 ? 's' : ''}`;
        }

        // Action functions
        function viewPerson(id) {
            console.log('Viewing person:', id);
            // In a real app, this would navigate to person details page
            alert(`Voir les détails de la personne ID: ${id}`);
        }

        function editPerson(id) {
            console.log('Editing person:', id);
            // In a real app, this would navigate to edit person page
            alert(`Modifier la personne ID: ${id}`);
        }

        function deletePerson(id) {
            console.log('Deleting person:', id);
            if (confirm('Êtes-vous sûr de vouloir supprimer cette personne ?')) {
                // In a real app, this would make an API call to delete the person
                alert(`Personne ID: ${id} supprimée`);
            }
        }

        // Event listeners
        document.getElementById('searchInput').addEventListener('input', filterPersons);
        document.getElementById('typeFilter').addEventListener('change', filterPersons);
        document.getElementById('nationalityFilter').addEventListener('change', filterPersons);

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderPersonsTable(personsData);
            updatePersonCount(personsData.length);
        });
    </script>
</body>

</html>