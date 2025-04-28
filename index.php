<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoRide - Accueil</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

</head>
<body>

  <header>
    <a href="index.php" class="logo"><span class="green">E</span>co<span><span class="green">R</span>ide</span></a>
    <nav>
      <ul>
        <li><a href="recherche.php">Covoiturage</a></li>
        <li><a href="inscription.php">Créer un compte</a></li>
        <li><a href="connexion.php">Se connecter</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
  </header>
<main>
  <section class="hero-search">
    <h1>Trouvez votre prochain covoiturage</h1>
    <form class="search-form" action="recherche.php" method="get">
      <input type="text" name="depart" placeholder="Ville de départ">
      <input type="text" name="arrivee" placeholder="Ville d'arrivée">
      <input type="date" name="date">
      <button type="submit">Rechercher</button>
    </form>
  </section>

  <section class="hero-presentation">
    <h2>Réinventons les trajets du quotidien</h2>
    <p>
      EcoRide est une plateforme de covoiturage pensée pour ceux qui veulent bouger autrement.<br>
      Ensemble, réduisons notre impact environnemental tout en rendant les trajets plus économiques et conviviaux.
    </p>
    <img src="assets/images/voiture.png" class="car-image" alt="Illustration d'une voiture écologique">
  </section>
</main>
  <footer>
  <div class="logo"><span class="green">E</span>co<span><span class="green">R</span>ide</span></div>
  <a href="mailto:EcoRide@fakemail.com" class="mail">EcoRide@fakemail.com</a>
    <a href="mentions-legales.html" class="mentions">Mentions légales</a>
  </footer>

</body>
</html>