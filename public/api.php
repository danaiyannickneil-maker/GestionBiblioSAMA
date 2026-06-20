<?php
session_start();
require_once(__DIR__ . "/../services/LivreService.php");
require_once(__DIR__ . "/../services/UserServices.php");
require_once(__DIR__ . "/../services/EmpruntService.php");

header("Content-Type: application/json");

$action = $_GET["action"] ?? "";
$response = ["success" => false, "message" => "Action non spécifiée ou invalide."];

$livreService = new LivreService();
$userService = new UserServices();
$empruntService = new EmpruntService();

switch ($action) {
    case "login":
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"] ?? "";
            $mdp = $_POST["mdp"] ?? "";
            $result = $userService->connecter($email, $mdp);
            
            if ($result["success"]) {
                $_SESSION["user"] = $result["user"];
                $_SESSION["user_id"] = $result["user"]["id"];
                $_SESSION["type_user"] = $result["user"]["type_user"];
                
                $response = [
                    "success" => true,
                    "message" => "Connexion réussie.",
                    "user" => [
                        "id" => $result["user"]["id"],
                        "nom" => $result["user"]["nom"],
                        "prenom" => $result["user"]["prenom"],
                        "email" => $result["user"]["email"],
                        "type_user" => $result["user"]["type_user"]
                    ]
                ];
            } else {
                $response = ["success" => false, "message" => $result["message"]];
            }
        }
        break;

    case "register":
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nom = $_POST["nom"] ?? "";
            $prenom = $_POST["prenom"] ?? "";
            $email = $_POST["email"] ?? "";
            $mdp = $_POST["mdp"] ?? "";
            $mdp2 = $_POST["mdp2"] ?? "";
            
            $result = $userService->inscrire($email, $mdp, $mdp2, $nom, $prenom);
            $response = [
                "success" => $result["success"],
                "message" => $result["message"]
            ];
        }
        break;

    case "logout":
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        $response = ["success" => true, "message" => "Déconnexion réussie."];
        break;

    case "get_books":
        $recherche = $_GET["recherche"] ?? "";
        if ($recherche !== "") {
            $books = $livreService->rechercherLivres($recherche);
        } else {
            $books = $livreService->listerLivres();
        }
        $response = ["success" => true, "books" => $books];
        break;

    case "advanced_search":
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $criteres = [
                'titre' => $_POST["titre"] ?? "",
                'auteur' => $_POST["auteur"] ?? "",
                'isbn' => $_POST["isbn"] ?? "",
                'editeur' => $_POST["editeur"] ?? "",
                'annee' => $_POST["annee"] ?? "",
                'categorie' => $_POST["categorie"] ?? "",
                'description' => $_POST["description"] ?? "",
                'nb_pages' => $_POST["nb_pages"] ?? "",
                'langue' => $_POST["langue"] ?? ""
            ];
            $books = $livreService->rechercherLivresAvance($criteres);
            $response = ["success" => true, "books" => $books];
        }
        break;

    case "get_favorites":
        if (empty($_SESSION["user_id"])) {
            $response = ["success" => false, "message" => "Connexion requise pour voir les favoris."];
        } else {
            $books = $empruntService->listerFavoris($_SESSION["user_id"]);
            $response = ["success" => true, "books" => $books];
        }
        break;

    case "emprunter":
        if (empty($_SESSION["user_id"])) {
            $response = ["success" => false, "message" => "Connexion requise pour emprunter un livre."];
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            $docId = $_POST["document_id"] ?? null;
            if ($docId) {
                $result = $empruntService->emprunterLivre($_SESSION["user_id"], $docId);
                $response = [
                    "success" => $result["success"],
                    "message" => $result["message"]
                ];
            } else {
                $response = ["success" => false, "message" => "ID du document manquant."];
            }
        }
        break;

    case "favori":
        if (empty($_SESSION["user_id"])) {
            $response = ["success" => false, "message" => "Connexion requise pour ajouter aux favoris."];
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            $docId = $_POST["document_id"] ?? null;
            if ($docId) {
                $result = $empruntService->ajouterFavori($_SESSION["user_id"], $docId);
                $response = [
                    "success" => $result["success"],
                    "message" => $result["message"]
                ];
            } else {
                $response = ["success" => false, "message" => "ID du document manquant."];
            }
        }
        break;

    case "add_book":
        if (empty($_SESSION["user_id"])) {
            $response = ["success" => false, "message" => "Connexion requise pour ajouter un livre."];
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            $titre = $_POST["titre"] ?? "";
            $auteur = $_POST["auteur"] ?? "";
            $isbn = $_POST["isbn"] ?? "";
            $editeur = $_POST["editeur"] ?? "";
            $annee = $_POST["annee"] ?? null;
            $categorie = $_POST["categorie"] ?? "";
            $description = $_POST["description"] ?? "";
            $nb_pages = $_POST["nb_pages"] ?? null;
            $langue = $_POST["langue"] ?? "";

            $image = null;
            if (!empty($_FILES["image"]["name"])) {
                $targetDir = __DIR__ . "/../uploads/";
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $safeName = uniqid("cover_", true) . "_" . basename($_FILES["image"]["name"]);
                $targetFile = $targetDir . $safeName;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    $image = "../uploads/" . $safeName;
                }
            }

            $result = $livreService->ajouterLivre($titre, $auteur, $isbn, $editeur, $annee, $categorie, $description, $nb_pages, $langue, $image);
            if ($result) {
                $response = ["success" => true, "message" => "Livre ajouté avec succès au catalogue."];
            } else {
                $response = ["success" => false, "message" => "Erreur lors de l'ajout du livre. Veuillez vérifier les champs obligatoires (*)."];
            }
        }
        break;

    case "get_stats":
        if (empty($_SESSION["user_id"])) {
            $response = ["success" => false, "message" => "Connexion requise."];
        } else {
            $userId = $_SESSION["user_id"];
            $userType = $_SESSION["type_user"];
            
            $stats = [];
            if (in_array($userType, ["admin", "bibliothecaire"], true)) {
                $stats = [
                    "total_livres" => $livreService->compterLivres(),
                    "utilisateurs" => $userService->compterUtilisateursActifs(),
                    "emprunts" => $empruntService->compterEmpruntsEnCours()
                ];
            } else {
                $stats = [
                    "emprunts" => $empruntService->compterEmpruntsUtilisateur($userId),
                    "favoris" => $empruntService->compterFavorisUtilisateur($userId),
                    "notifications" => $empruntService->compterNotificationsNonLues($userId)
                ];
            }
            
            $response = [
                "success" => true,
                "stats" => $stats,
                "user" => [
                    "nom" => $_SESSION["user"]["nom"] ?? "",
                    "prenom" => $_SESSION["user"]["prenom"] ?? "",
                    "email" => $_SESSION["user"]["email"] ?? "",
                    "type_user" => $_SESSION["user"]["type_user"] ?? ""
                ]
            ];
        }
        break;
}

echo json_encode($response);
exit;
?>
