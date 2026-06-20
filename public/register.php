<?php
session_start();
require_once(__DIR__ . "/../services/UserServices.php");

if (!empty($_SESSION["user_id"])) {
    header("Location: Biblio.php");
    exit;
}

$message = "";
$messageClass = "error";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $service = new UserServices();
    $result  = $service->inscrire(
        $_POST["email"]   ?? "",
        $_POST["mdp"]     ?? "",
        $_POST["mdp2"]    ?? "",
        $_POST["nom"]     ?? "",
        $_POST["prenom"]  ?? ""
    );
    $message      = $result["message"];
    $messageClass = $result["success"] ? "success" : "error";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — BU SAMA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0a4e2a 0%, #083c21 60%, #06301a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .auth-card {
            background: #fff;
            border-radius: 18px;
            width: 100%;
            max-width: 480px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(0,0,0,0.3);
        }
        .auth-header {
            background: linear-gradient(135deg, #0a4e2a, #128c51);
            padding: 28px 28px 24px;
            text-align: center;
            border-bottom: 4px solid #f5be18;
        }
        .auth-header img { height: 48px; margin-bottom: 12px; filter: drop-shadow(0 3px 8px rgba(0,0,0,.2)); }
        .auth-header h1 { color: #fff; font-family: 'Outfit', sans-serif; font-size: 1.4rem; margin-bottom: 4px; }
        .auth-header p { color: rgba(255,255,255,.75); font-size: 0.85rem; }
        .auth-body { padding: 24px 28px 28px; }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #128c51;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 18px;
        }
        .back-link:hover { color: #0a4e2a; }
        .alert-msg {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.88rem;
            margin-bottom: 18px;
            display: flex; align-items: center; gap: 8px;
        }
        .alert-msg.success { background:#e6f6ee; color:#0e7a3a; border-left:4px solid #1fa855; }
        .alert-msg.error   { background:#fef0f0; color:#c0392b; border-left:4px solid #ea0038; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px; }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-size: 0.82rem; font-weight: 600; color: #667781; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; }
        .form-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e9edef;
            border-radius: 8px;
            font-size: 0.92rem;
            font-family: 'Inter', sans-serif;
            color: #111b21;
            background: #fafbfc;
            transition: all .2s;
        }
        .form-group input:focus { outline: none; border-color: #128c51; background: #fff; box-shadow: 0 0 0 3px rgba(18,140,81,.12); }
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #128c51, #0a4e2a);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            transition: all .25s;
            margin-top: 4px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(18,140,81,.35); }
        .auth-footer { text-align: center; margin-top: 18px; font-size: 0.87rem; color: #667781; }
        .auth-footer a { color: #128c51; font-weight: 600; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }
        @media (max-width:500px) { .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <img src="../assets/image/Logo.png" alt="BU SAMA">
            <h1>Créer un compte</h1>
            <p>Rejoignez la Bibliothèque Universitaire SAMA</p>
        </div>
        <div class="auth-body">
            <a href="Biblio.php" class="back-link">
                <i class="fa-solid fa-arrow-left"></i> Retour à la bibliothèque
            </a>
            <?php if ($message): ?>
                <div class="alert-msg <?php echo $messageClass; ?>">
                    <i class="fa-solid <?php echo $messageClass === 'success' ? 'fa-circle-check' : 'fa-circle-xmark'; ?>"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <input type="email" id="email" name="email" placeholder="exemple@univ.fr" required>
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" id="mdp" name="mdp" placeholder="Min. 6 caractères" required>
                </div>
                <div class="form-group">
                    <label for="mdp2">Confirmer le mot de passe</label>
                    <input type="password" id="mdp2" name="mdp2" placeholder="Confirmez votre mot de passe" required>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-user-plus" style="margin-right:8px;"></i> Créer mon compte
                </button>
            </form>
            <p class="auth-footer">
                Déjà un compte ? <a href="login.php">Se connecter</a>
            </p>
        </div>
    </div>
</body>
</html>
