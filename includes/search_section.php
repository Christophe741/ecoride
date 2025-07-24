<section class="search-hero">
  <h1 class="search-hero__title">Trouvez votre prochain covoiturage</h1>

  <form id="search-form" class="search-hero__form" action="<?= $basePath ?>search.php" method="get">
    <input class="search-hero__input" type="text" name="from" placeholder="Ville de départ" value="<?= htmlspecialchars($_GET['from'] ?? '') ?>">
    <input class="search-hero__input" type="text" name="to" placeholder="Ville d'arrivée" value="<?= htmlspecialchars($_GET['to'] ?? '') ?>">
    <input class="search-hero__input" type="date" name="date" value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
    <button class="search-hero__button" type="submit">Rechercher</button>
  </form>
</section>
