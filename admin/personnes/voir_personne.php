<?php
require_once __DIR__ . '/../header.php';

?>
<!-- Page Content -->
<div class="page-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <div class="page-title-icon"><i class="fas fa-user"></i></div>
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
                    <img src="photo.jpg" alt="Marie MBEMBA" class="person-photo">
                    -->

            <h2 class="person-name">Marie MBEMBA</h2>
            <div class="person-id">ID: PER-2024-001</div>
            <div class="person-type">
                <span><i class="fas fa-female"></i></span>
                Femme
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
                    Dernière mise à jour: 15/06/2025
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
                            <span class="section-icon"><i class="fas fa-birthday-cake"></i></span>
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
                            <span class="section-icon"><i class="fas fa-briefcase"></i></span>
                            Informations Professionnelles
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Profession</div>
                                <div class="info-value">Enseignante</div>
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