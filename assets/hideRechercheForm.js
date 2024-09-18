document.addEventListener('DOMContentLoaded', (event) => {
    let isObserverInitialized = false;

    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'childList' && !isObserverInitialized) {
                isObserverInitialized = true;

                const rechercheTitre = document.getElementById('rechercheHeader');
                const rechercheForm = document.getElementById('formRecherche');

                if (rechercheTitre && rechercheForm) {
                    rechercheTitre.addEventListener('click', function (e) {
                        const buttonPlus = this.querySelector('.buttonPlus');
                        const buttonMoins = this.querySelector('.buttonMoins');
                        if (buttonPlus && buttonMoins) {
                            rechercheForm.classList.toggle('hide');
                            buttonMoins.classList.toggle('hide');
                            buttonPlus.classList.toggle('hide');
                        }
                    });
                } 
                const filleulTitre = document.getElementById('titreFilleuls');
                const filleulListe = document.getElementById('listeFilleuls');

                if (filleulListe && filleulTitre) {
                    filleulTitre.addEventListener('click', function (e) {
                        const buttonPlus = this.querySelector('.buttonPlus');
                        const buttonMoins = this.querySelector('.buttonMoins');
                        filleulListe.classList.toggle('hide');
                        buttonMoins.classList.toggle('hide');
                        buttonPlus.classList.toggle('hide');
                    });
                }

                const parrainTitre = document.getElementById('titreParrains');
                const parrainListe = document.getElementById('listeParrains');

                if (parrainTitre && parrainListe) {
                    parrainTitre.addEventListener('click', function (e) {
                        const buttonPlus = this.querySelector('.buttonPlus');
                        const buttonMoins = this.querySelector('.buttonMoins');
                        parrainListe.classList.toggle('hide');
                        buttonMoins.classList.toggle('hide');
                        buttonPlus.classList.toggle('hide');
                    })
                }
            }
        });
    });

    // Configuration de l'observation
    const config = { childList: true, subtree: true };

    // Sélectionnez l'élément à observer pour les mutations
    const targetNode = document.querySelector('body');

    // Commencez à observer le DOM
    observer.observe(targetNode, config);
});
