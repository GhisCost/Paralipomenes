
// JS bouton de soumission à la correction

let submitCorrection = document.getElementById('submitCorrection');
let modal = document.querySelector('.modalSubmitCorrec');
let nonSubCorrect = document.querySelector('.nonSubCorrect');


submitCorrection.addEventListener('click', function(e) {
    e.stopPropagation();
    modal.classList.remove("pasLa");
    modal.classList.add("la");
});


nonSubCorrect.addEventListener('click', function() {
    modal.classList.remove("la");
    modal.classList.add("pasLa");
});

document.addEventListener('click', function(e) {
    if (!modal.contains(e.target) && e.target !== submitCorrection) {
        modal.classList.remove("la");
        modal.classList.add("pasLa");
    }
});
