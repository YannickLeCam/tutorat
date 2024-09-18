console.log("Je suis la ");
document.addEventListener('DOMContentLoaded', (event) => {
    let isObserverInitialized = false;

    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'childList' && !isObserverInitialized) {
                console.log('Changement de page détecté');
                isObserverInitialized = true;

                const rechercheTitre = document.getElementById('rechercheHeader');
                const rechercheForm = document.getElementById('formRecherche');
                console.log(rechercheForm, rechercheTitre);

                if (rechercheTitre && rechercheForm) {
                    rechercheTitre.addEventListener('click', function (e) {
                        console.log("L'event se passe");
                        const buttonPlus = this.querySelector('.buttonPlus');
                        const buttonMoins = this.querySelector('.buttonMoins');
                        if (buttonPlus && buttonMoins) {
                            rechercheForm.classList.toggle('hide');
                            buttonMoins.classList.toggle('hide');
                            buttonPlus.classList.toggle('hide');
                        } else {
                            console.error('Buttons Plus or Moins not found');
                        }
                    });
                } else {
                    console.error('rechercheTitre or rechercheForm not found');
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
