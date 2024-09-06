const parrainTitre = document.getElementById('titreParrains');
const parrainListe = document.getElementById('listeParrains');

parrainTitre.addEventListener('click', function (e) {
    const buttonPlus = this.querySelector('.buttonPlus');
    const buttonMoins = this.querySelector('.buttonMoins');
    parrainListe.classList.toggle('hide');
    buttonMoins.classList.toggle('hide');
    buttonPlus.classList.toggle('hide');
})
