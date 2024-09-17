
const rechercheTitre = document.getElementById('rechercheHeader');
const rechercheForm = document.getElementById('formRecherche');

console.log(rechercheTitre);
rechercheTitre.addEventListener('click', function (e) {
    const buttonPlus = this.querySelector('.buttonPlus');
    const buttonMoins = this.querySelector('.buttonMoins');
    rechercheForm.classList.toggle('hide');
    buttonMoins.classList.toggle('hide');
    buttonPlus.classList.toggle('hide');
});
