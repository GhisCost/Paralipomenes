<header>

    <div class="titre-logo">
        <div class="logo"><img src="" alt="logo du site"></div>
        <div class="titres">
            <h1 class="lavish">Paralipomènes</h1>
            <h2 class="eagle">Chroniques des travailleurs anonymes</h2>
        </div>
    </div>

    <nav>
        <ul>
            <a href="">
                <li>Accueil</li>
            </a>
            <a href="">
                <li>Bibliothèque</li>
            </a>
            {% if app.user %}
            <a href="">
                <li>Mon compte</li>
            </a>
            {% else %}
            <a href="">
                <li>S'inscrire</li>
            </a>
            <a href="">
                <li>Se connecter</li>
            </a>
            {% endif %}
        </ul>
    </nav>


</header>


<footer>
    <nav>
        <ul>
            <a href="">
                <li>Mentions Légales</li>
            </a>
            <a href="">
                <li>Contacts</li>
            </a>
            <a href="">
                <li>F.A.Q</li>
            </a>
        </ul>
    </nav>
</footer>
<script src="{{asset('assets/js/structure.js')}}"></script>




<div class="text-presentation eagle">
    <p> Bienvenue sur Paralipomènes, ce site a été crée dans le but de rassembler des histoires, mais pas n’importe quel
        type d’histoire. Les histoires rassemblées ici, sont des histoires de carrières professionnelles. Des personnes
        comme vous sont venus avant vous ici pour écrire leur histoire. Vous pouvez les lire pour le plaisir, pour vous
        en inspirer ou pour tout autre raison qui vous appartient. Puis si le cœur vous en dit vous pouvez partager
        votre histoire.</p>
    <p>
        Les histoires partagées ici sont entièrement anonymes, aucune entreprise ou organisation ne peut être cité ou
        ciblé. Évidement les textes doivent respectés les lois ainsi que le respect du à tout un chacun (donc aucun
        propos racistes, sexistes, homophobes, etc.). Les opinions exprimés sont celles exclusivement celles des auteurs
        et ne saurait refléter l’opinion des créateurs ou des modérateurs du site.
    </p>
</div>

<div class="derniers-textes" >
   
</div>

<a href="">
    <div>
        <div><img src="" alt=""></div>
        <div>
            <p> </p>
        </div>
    </div>
</a>