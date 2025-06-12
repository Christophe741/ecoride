import { domReady } from "./domReady.js";

function buildCard(trajet, query) {
  const card = document.createElement("div");
  card.className = "trajet-card";

  const left = document.createElement("div");
  left.className = "trajet-left";
  const img = document.createElement("img");
  img.className = "photo-profil";
  img.src = `assets/profils/${trajet.photo}`;
  img.alt = `Photo de ${trajet.pseudo}`;
  left.appendChild(img);

  const middle = document.createElement("div");
  middle.className = "trajet-middle";
  middle.innerHTML = `<h3>${trajet.pseudo}</h3>
    <p>Note : ${trajet.note} / 5</p>
    <p>Places restantes : ${trajet.places}</p>
    <p>Prix : ${trajet.prix} €</p>
    <p>Départ : ${trajet.ville_depart}</p>
    <p>Arrivée : ${trajet.ville_arrivee}</p>`;

  const right = document.createElement("div");
  right.className = "trajet-right";
  const badge = document.createElement("span");
  badge.className = "badge-green";
  badge.textContent = "✔ Écologique";
  const link = document.createElement("a");
  link.className = "detail-btn";
  const params = new URLSearchParams(query);
  params.set("id", trajet.id);
  link.href = `detail.php?${params.toString()}`;
  link.textContent = "Détail";
  right.append(badge, link);

  card.append(left, middle, right);
  return card;
}

domReady(() => {
  const container = document.querySelector("#results");
  if (!container) return;

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
    `api/search.php?depart=${encodeURIComponent(
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
