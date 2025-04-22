<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoRide - Accueil</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <header>
    <div class="logo">EcoRide</div>
    <nav>
      <ul>
        <li><a href="recherche.php">Covoiturage</a></li>
        <li><a href="inscription.php">Créer un compte</a></li>
        <li><a href="connexion.php">Se connecter</a></li>
      </ul>
    </nav>
  </header>

  <section class="search-section">
    <h1>Trouvez votre prochain covoiturage</h1>
    <form action="recherche.php" method="get">
      <input type="text" name="depart" placeholder="Ville de départ">
      <input type="text" name="arrivee" placeholder="Ville d'arrivée">
      <input type="date" name="date">
      <button type="submit">Rechercher</button>
    </form>
  </section>

  <section class="presentation">
    <h2>Réinventons les trajets du quotidien</h2>
    <p>
      EcoRide est une plateforme de covoiturage pensée pour ceux qui veulent bouger autrement.
      Ensemble, réduisons notre impact environnemental tout en rendant les trajets plus économiques et conviviaux.
    </p>
    <img src="assets/images/voiture.png" alt="Illustration d'une voiture écologique">
  </section>

  <footer>
    <p>Mail : <a href="mailto:EcoRide@fakemail.com">EcoRide@fakemail.com</a></p>
    <a href="mentions-legales.html">Mentions légales</a>
  </footer>
test4
</body>
</html>