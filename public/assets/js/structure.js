
// JS bouton de soumission à la correction

let submitCorrection= document.getElementById('submitCorrection');
let modal = document.querySelector('.modalSubmitCorrec');

submitCorrection.addEventListener('click', function(){

    modal.classList.remove("montrer");
    modal.classList.add("la")

});

document.addEventListener('click', function(e)
{
    if (!e.target.matches(".modalSubmitCorrec")){
        
    }
})