
// JS bouton de soumission à la correction



let submitCorrection = document.getElementById('submitCorrection');
let modal = document.querySelector('.modalSubmitCorrec');
let nonSubCorrect = document.querySelector('.nonSubCorrect');

if(submitCorrection){
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
}

// Js bouton de publication

let submitPubli = document.getElementById('submitPubli');
let modalPubli = document.querySelector('.modalPubli');
let nonPubli = document.querySelector('.nonPubli');

if(submitPubli){
    submitPubli.addEventListener('click', function(e) {
    e.stopPropagation();
    modalPubli.classList.remove("pasLa");
    modalPubli.classList.add("la");
});


nonPubli.addEventListener('click', function() {
    modalPubli.classList.remove("la");
    modalPubli.classList.add("pasLa");
});

document.addEventListener('click', function(e) {
    if (!modalPubli.contains(e.target) && e.target !== submitPubli) {
        modalPubli.classList.remove("la");
        modalPubli.classList.add("pasLa");
    }
});
}

// Js suppression message


document.querySelectorAll('.imgSup').forEach(imgSup => {
    imgSup.addEventListener('click', function(e) {
        e.stopPropagation();
        const messageId = this.getAttribute('data-id');
        const modalMess = document.querySelector(`.modalMess[data-id="${messageId}"]`);
        modalMess.classList.remove("pasLa");
        modalMess.classList.add("la");
    });
});

document.querySelectorAll('.nonMess').forEach(nonMess => {
    nonMess.addEventListener('click', function() {
        const modalMess = this.closest('.modalMess');
        modalMess.classList.remove("la");
        modalMess.classList.add("pasLa");
    });
});

document.addEventListener('click', function(e) {
    if (!e.target.closest('.modalMess') && !e.target.closest('.imgSup')) {
        document.querySelectorAll('.modalMess').forEach(modal => {
            modal.classList.remove("la");
            modal.classList.add("pasLa");
        });
    }
});
