// Fonction pour détruire les instances TomSelect existantes
function destroyTomSelect() {
    document.querySelectorAll('.tomselect').forEach(function(el) {
        if (el.tomselect) {
            el.tomselect.destroy();
        }
    });
}

// Assurer que TomSelect est bien initialisé
function initTomSelect() {
    // Vérifier si TomSelect est disponible
    if (typeof TomSelect === 'undefined') {
        console.error('TomSelect n\'est pas chargé');
        return;
    }

    // Détruire les instances existantes pour éviter les conflits
    destroyTomSelect();

    // Initialiser Tom Select sur les éléments avec la classe 'tomselect'
    document.querySelectorAll('.tomselect').forEach(function(el) {
        if (!el.tomselect) {
            new TomSelect(el, {
                plugins: ['dropdown_input'],
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                allowEmptyOption: true,
                placeholder: 'Rechercher...',
            });
        }
    });
}

// S'assurer que le document est prêt avant d'initialiser
$(document).ready(function() {
    // Initialiser TomSelect après un court délai pour s'assurer que le DOM est prêt
    setTimeout(initTomSelect, 100);
});
