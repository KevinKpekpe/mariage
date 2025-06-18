// Animation au chargement des cartes
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.stat-card, .chart-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Gestion de la recherche
document.querySelector('.search-input').addEventListener('input', function (e) {
    const searchTerm = e.target.value.toLowerCase();
    if (searchTerm.length > 2) {
        console.log('Recherche:', searchTerm);
        // Ici vous pouvez implémenter la logique de recherche
    }
});

// Gestion du menu mobile
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('open');
}

// Ajout d'un bouton menu mobile si nécessaire
if (window.innerWidth <= 768) {
    const mobileMenuBtn = document.createElement('button');
    mobileMenuBtn.innerHTML = '☰';
    mobileMenuBtn.style.cssText = `
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 1001;
                background: #1976d2;
                color: white;
                border: none;
                padding: 10px;
                border-radius: 5px;
                cursor: pointer;
            `;
    mobileMenuBtn.onclick = toggleSidebar;
    document.body.appendChild(mobileMenuBtn);
}