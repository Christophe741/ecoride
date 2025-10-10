<section class="search-hero">
  <h1 class="search-hero__title">Trouvez votre prochain covoiturage</h1>

  <form id="search-form" class="search-hero__form" action="<?= $basePath ?>search.php" method="get">
    <label for="from" class="sr-only">Ville de départ</label>
    <input
      id="from"
      class="search-hero__input"
      type="text"
      name="from"
      placeholder="Ville de départ"
      value="<?= htmlspecialchars($_GET['from'] ?? '') ?>"
      required
    >

    <label for="to" class="sr-only">Ville d'arrivée</label>
    <input
      id="to"
      class="search-hero__input"
      type="text"
      name="to"
      placeholder="Ville d'arrivée"
      value="<?= htmlspecialchars($_GET['to'] ?? '') ?>"
      required
    >

    <label for="date" class="sr-only">Date du trajet</label>
    <input
      id="date"
      class="search-hero__input"
      type="date"
      name="date"
      value="<?= htmlspecialchars($_GET['date'] ?? '') ?>"
      required
    >

    <button class="search-hero__button" type="submit">Rechercher</button>
  </form>
</section>
