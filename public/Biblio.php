<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIBLIOTH7QUE</title>
    <img src="" alt="">
</head>
<body>
    <nav>
        <ul>
            <li>
                <strong>
                 Bibliothèque
                </strong>
                <li>
                <button id="login" onclick="">
                 se connecter
                </button>
                <button id="inscrire">
                    s'inscrire
                </button>
                </li>
           
                <strong>
                    Explorer
                </strong>
            </li>
            <li> 
                <button id="menu">
                   Thèmes
                </button>
            </li>
            <li> <button id="menu">
                   En vogue
                </button>
            </li>
            <li>
                 <button id="menu">
                   Listes
                </button>
            </li>
            <li> <button id="menu">
                   Livres au hasard
                </button>
            </li>
            <li>
                <button id="menu">
                  Recherche avancé
                </button>
             </li>
                <strong>
                    Contribuer
                </strong>
            </li>
            <li>  
                <button id="menu">
                  Ajouter Livre
                </button>
            </li>
            <li>
                <strong>
                    Ressources
                </strong>
            </li>
            <li> <button id="menu">
                   Développeurs
                </button>
            </li>
          
        </ul>
    </nav>

<h1>Rechercher les livres</h1>

<form method="get" action="biblio.php">
    <input type="text" name ="recherche" placeholder="Rechercher un livre...">
    <button id="search" type= "submit">Rechercher</button>
</form>
<div>
    <textarea name="Nbresult" id="Nb">

    </textarea>
</div>
<div class="card">
    <div id="details">

    </div>
</div>




























</body>
</html>