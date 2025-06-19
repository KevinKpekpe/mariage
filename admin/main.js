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

document.getElementById('photoInput').addEventListener('change', function (e) {
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
        reader.onload = function (e) {
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