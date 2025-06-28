import { domReady } from "./domReady.js";

function buildCard(trajet, query) {
  const card = document.createElement("div");
  card.className = "ride-card";

  // Partie gauche : photo du conducteur
  const left = document.createElement("div");
  left.className = "ride-card__left";
  const img = document.createElement("img");
  img.className = "ride-card__photo";
  img.src = `assets/profils/${trajet.photo}`;
  img.alt = `Photo de ${trajet.pseudo}`;
  left.appendChild(img);

  // Partie centrale : infos principales du trajet
  const middle = document.createElement("div");
  middle.className = "ride-card__middle";
  const title = document.createElement("h3");
  title.className = "ride-card__title";
  title.textContent = trajet.pseudo;
  middle.appendChild(title);
  const note = document.createElement("p");
  note.textContent = `Note : ${trajet.note} / 5`;
  const places = document.createElement("p");
  places.textContent = `Places restantes : ${trajet.places}`;
  const prix = document.createElement("p");
  prix.textContent = `Prix : ${trajet.prix} €`;
  const depart = document.createElement("p");
  depart.textContent = `Départ : ${trajet.ville_depart}`;
  const arrivee = document.createElement("p");
  arrivee.textContent = `Arrivée : ${trajet.ville_arrivee}`;

  middle.append(title, note, places, prix, depart, arrivee);

  // Partie droite : badge et bouton détail
  const right = document.createElement("div");
  right.className = "ride-card__right";
  const badge = document.createElement("span");
  badge.className = "ride-card__badge";
  badge.textContent = "✔ Écologique";
  const link = document.createElement("a");
  link.className = "ride-card__button";
  const params = new URLSearchParams(query);
  params.set("id", trajet.id);
  link.href = `rideDetail.php?${params.toString()}`;
  link.textContent = "Détail";
  right.append(badge, link);

  card.append(left, middle, right);
  return card;
}

domReady(() => {
  const container = document.querySelector("#results");

  const params = new URLSearchParams(window.location.search);
  const depart = params.get("depart");
  const arrivee = params.get("arrivee");
  const date = params.get("date");

  if (!(depart && arrivee && date)) {
    container.textContent =
      "Veuillez saisir une ville de départ, d'arrivée et une date.";
    return;
  }

  fetch(
    `api/get_rides.php?depart=${encodeURIComponent(
      depart
    )}&arrivee=${encodeURIComponent(arrivee)}&date=${encodeURIComponent(date)}`
  )
    .then((res) => res.json())
    .then((data) => {
      if (data.success && data.trajets.length) {
        data.trajets.forEach((t) =>
          container.appendChild(buildCard(t, { depart, arrivee, date }))
        );
      } else {
        container.textContent = "Aucun trajet trouvé pour cette recherche.";
      }
    })

    .catch(() => {
      container.textContent = "Erreur lors du chargement des trajets.";
    });
});
