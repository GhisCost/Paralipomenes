// JS bouton de soumission à la correction

let submitCorrection = document.getElementById("submitCorrection");
let modal = document.querySelector(".modalSubmitCorrec");
let nonSubCorrect = document.querySelector(".nonSubCorrect");

if (submitCorrection) {
    submitCorrection.addEventListener("click", function (e) {
        e.stopPropagation();
        modal.classList.remove("pasLa");
        modal.classList.add("la");
    });

    nonSubCorrect.addEventListener("click", function () {
        modal.classList.remove("la");
        modal.classList.add("pasLa");
    });

    document.addEventListener("click", function (e) {
        if (!modal.contains(e.target) && e.target !== submitCorrection) {
            modal.classList.remove("la");
            modal.classList.add("pasLa");
        }
    });
}

// Js bouton de publication

let submitPubli = document.getElementById("submitPubli");
let modalPubli = document.querySelector(".modalPubli");
let nonPubli = document.querySelector(".nonPubli");

if (submitPubli) {
    submitPubli.addEventListener("click", function (e) {
        e.stopPropagation();
        modalPubli.classList.remove("pasLa");
        modalPubli.classList.add("la");
    });

    nonPubli.addEventListener("click", function () {
        modalPubli.classList.remove("la");
        modalPubli.classList.add("pasLa");
    });

    document.addEventListener("click", function (e) {
        if (!modalPubli.contains(e.target) && e.target !== submitPubli) {
            modalPubli.classList.remove("la");
            modalPubli.classList.add("pasLa");
        }
    });
}

// Js suppression message

document.querySelectorAll(".imgSup").forEach((imgSup) => {
    imgSup.addEventListener("click", function (e) {
        e.stopPropagation();
        const messageId = this.getAttribute("data-id");
        const modalMess = document.querySelector(
            `.modalMess[data-id="${messageId}"]`,
        );
        modalMess.classList.remove("pasLa");
        modalMess.classList.add("la");
    });
});

document.querySelectorAll(".nonMess").forEach((nonMess) => {
    nonMess.addEventListener("click", function () {
        const modalMess = this.closest(".modalMess");
        modalMess.classList.remove("la");
        modalMess.classList.add("pasLa");
    });
});

document.addEventListener("click", function (e) {
    if (!e.target.closest(".modalMess") && !e.target.closest(".imgSup")) {
        document.querySelectorAll(".modalMess").forEach((modal) => {
            modal.classList.remove("la");
            modal.classList.add("pasLa");
        });
    }
});

// Ajax recherche

let inputRecherche = document.getElementById("recherche");

if (inputRecherche) {

   document.addEventListener('DOMContentLoaded', function() {
   
    const container = document.querySelector('.divRecherche').parentNode; // ou un conteneur plus précis

    inputRecherche.addEventListener('input', async function(e) {
        const mot = e.target.value.trim();

        if (mot.length < 3) {
            // Si moins de 3 caractères, on affiche tout
            document.querySelectorAll('.carte-biblio').forEach(carte => {
                carte.style.display = 'block';
            });
            return;
        }

        try {
            const response = await fetch(`/recherche-histoires?mot=${encodeURIComponent(mot)}`);
            const ids = await response.json();

            // Masquer toutes les cartes
            document.querySelectorAll('.carte-biblio').forEach(carte => {
                carte.style.display = 'none';
            });

            // Afficher uniquement celles dont l'ID est dans la réponse
            ids.forEach(id => {
                const carte = document.querySelector(`.carte-biblio[href*="/histoire/${id}"]`);
                if (carte) carte.style.display = 'block';
            });
        } catch (error) {
            console.error('Erreur lors de la recherche:', error);
        }
    });
});
}
