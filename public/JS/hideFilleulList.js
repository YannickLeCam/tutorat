const filleulTitre = document.getElementById('titreFilleuls');
const filleulListe = document.getElementById('listeFilleuls');

console.log(filleulListe);

filleulTitre.addEventListener('click', function (e) {
    const buttonPlus = this.querySelector('.buttonPlus');
    const buttonMoins = this.querySelector('.buttonMoins');
    filleulListe.classList.toggle('hide');
    buttonMoins.classList.toggle('hide');
    buttonPlus.classList.toggle('hide');
})
