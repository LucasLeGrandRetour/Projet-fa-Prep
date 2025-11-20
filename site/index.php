<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musée de Fâ - Le passé comme si vous y étiez</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>

    <header class="main-header">
        <div class="logo">
            <span class="logo-text">Fâ</span>
            <span class="logo-small">LE</span>
        </div>

        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="index.php?controleur=Event&action=afficherTous">Liste des évènements</a></li>
            </ul>
        </nav>

        <div class="burger-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    
        <?php
			// si aucune information n'est présente dans l'url, le controleur par défaut sera 'accueil'
			if (isset($_GET['controleur']))
				$controleur = filter_var($_GET['controleur'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			else
				$controleur = 'general';

			switch ($controleur) {
				case 'general':
					include_once 'vues/accueil.html';
					break;
				case 'Event':
					include_once 'controleurs/gestionEvent.php';
					break;
			}
		?>

    <footer>
        <p>@copyright par Champiau Annaëlle, Dogny Yann, Garcia Lucas et Zhou Tiago</p>
    </footer>

</body>
</html>