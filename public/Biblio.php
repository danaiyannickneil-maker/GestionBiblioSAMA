<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque</title>
    <link rel="stylesheet" href="../assets/css/Biblio.css"> <!-- ton fichier CSS -->
</head>
<body>
    <!-- En-tête -->
    <header>
        <h1>📚 Bibliothèque</h1>
    </header>

    <!-- Menu de navigation -->
    <nav>
        <ul>
            <li><button onclick="window.location.href='login.php'">Se connecter</button></li>
            <li><button onclick="window.location.href='register.php'">S'inscrire</button></li>
            <li><button>Thèmes</button></li>
            <li><button>En vogue</button></li>
            <li><button>Listes</button></li>
            <li><button>Livres au hasard</button></li>
            <li><button onclick="window.location.href='SearchAvancé.php'">Recherche avancée</button></li>
            <li><button onclick="window.location.href='AjouterLivre.php'">Ajouter un livre</button></li>
            <li><button onclick="window.location.href='Développeurs.txt'">Développeurs</button></li>
        </ul>
    </nav>

    <!-- Formulaire de recherche -->
    <section>
        <h2>🔎 Rechercher des livres</h2>
        <form method="get" action="biblio.php">
            <input type="text" name="recherche" placeholder="Rechercher un livre...">
            <button type="submit">Rechercher</button>
        </form>
    </section>

    <!-- Résultats -->
    <section id="resultats">
        <p id="Nbresult">Aucun résultat pour l’instant.</p>
        <div class="card">
            <div id="details"></div>
        </div>
    </section>

    <!-- Pied de page -->
    <?php include("../includes/footer.php"); ?>
</body>
</html>
