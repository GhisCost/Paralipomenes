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

document.addEventListener("DOMContentLoaded", function () {
    let inputRecherche = document.getElementById("recherche");
    if (!inputRecherche) return;

    let lastSearch = "";
    let timeout = null;

    inputRecherche.addEventListener("input", function (e) {
        clearTimeout(timeout);

        timeout = setTimeout(async () => {
            let mot = e.target.value.trim();
            let cartes = document.querySelectorAll(".carte-biblio");

            lastSearch = mot;

            if (mot.length === 0) {
                cartes.forEach((carte) => {
                    carte.style.display = "block";
                });
                return;
            }

            try {
                let response = await fetch(
                    `/recherche-histoires?mot=${encodeURIComponent(mot)}`,
                );

                let ids = await response.json();

                if (mot !== lastSearch) return;

                cartes.forEach((carte) => {
                    carte.style.display = "none";
                });

                ids.forEach((id) => {
                    let carte = document.querySelector(
                        `.carte-biblio[data-id="${id}"]`,
                    );
                    if (carte) carte.style.display = "block";
                });
            } catch (error) {
                console.error(error);
                cartes.forEach((carte) => {
                    carte.style.display = "block";
                });
            }
        }, 300);
    });
});

// Js navigation Mobile

document.addEventListener("DOMContentLoaded", function () {
    let menuNavMobile = document.querySelector(".menuNavMobile");
    let divImgNav = document.querySelector(".divImgNav");

    divImgNav.addEventListener("click", function (e) {
        e.stopPropagation();
        menuNavMobile.classList.remove("cacher");
        menuNavMobile.classList.add("la");
    });

    document.addEventListener("click", function (e) {
        if (!menuNavMobile.contains(e.target) && e.target !== divImgNav) {
            menuNavMobile.classList.remove("la");
            menuNavMobile.classList.add("cacher");
        }
    });
});

//Limitation du nombre de mots pour les histoires

let divLimit = document.querySelectorAll(".limitMot");
divLimit.forEach((el) => {
    let mots = el.innerHTML.split(" ");
    el.innerHTML = mots.slice(0, 50).join(" ") + "...";
});
