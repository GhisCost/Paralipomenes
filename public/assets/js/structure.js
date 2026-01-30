

// Injecter les corrections existantes
let contenu = `
{% for correction in corrections %}
<h3>Chapitre {{ correction.chapitres.id }}</h3>
{{ correction.contenu|raw }}
<!-- CORRECTION -->
{% endfor %}
`;

quill.root.innerHTML = contenu;

// Synchronisation avec le champ caché
const textarea = document.querySelector('#page_correction_contenu');

document.querySelector('form').addEventListener('submit', () => {
    textarea.value = quill.root.innerHTML;
});