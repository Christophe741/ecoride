// Importation de la fonction domReady pour exécuter le code une fois le DOM chargé
import { domReady } from "./domReady.js";

// Fonction pour construire dynamiquement une carte de trajet
function buildCard(trajet, query) {
  const card = document.createElement("div");
  card.className = "trajet-card";

  // Partie gauche : photo du conducteur
  const left = document.createElement("div");
  left.className = "trajet-left";
  const img = document.createElement("img");
  img.className = "photo-profil";
  img.src = `assets/profils/${trajet.photo}`;
  img.alt = `Photo de ${trajet.pseudo}`;
  left.appendChild(img);

  // Partie centrale : infos principales du trajet
  const middle = document.createElement("div");
  middle.className = "trajet-middle";
  middle.innerHTML = `<h3>${trajet.pseudo}</h3>
    <p>Note : ${trajet.note} / 5</p>
    <p>Places restantes : ${trajet.places}</p>
    <p>Prix : ${trajet.prix} €</p>
    <p>Départ : ${trajet.ville_depart}</p>
    <p>Arrivée : ${trajet.ville_arrivee}</p>`;

  // Partie droite : badge et bouton détail
  const right = document.createElement("div");
  right.className = "trajet-right";
  const badge = document.createElement("span");
  badge.className = "badge-green";
  badge.textContent = "✔ Écologique";
  const link = document.createElement("a");
  link.className = "detail-btn";
  // Construction de l'URL avec les paramètres de recherche et l'id du trajet
  const params = new URLSearchParams(query);
  params.set("id", trajet.id);
  link.href = `rideDetail.php?${params.toString()}`;
  link.textContent = "Détail";
  right.append(badge, link);

  // Assemblage des trois parties dans la carte
  card.append(left, middle, right);
  return card;
}

// Exécution du code principal lorsque le DOM est prêt
domReady(() => {
  const container = document.querySelector("#results"); // conteneur des résultats

  // Récupération des paramètres de recherche dans l'URL
  const params = new URLSearchParams(window.location.search);
  const depart = params.get("depart");
  const arrivee = params.get("arrivee");
  const date = params.get("date");

  // Vérification que tous les champs sont renseignés
  if (!(depart && arrivee && date)) {
    container.textContent =
      "Veuillez saisir une ville de départ, d'arrivée et une date.";
    return;
  }

  // Requête pour récupérer les trajets correspondant à la recherche
  fetch(
    `api/get_rides.php?depart=${encodeURIComponent(
      depart
    )}&arrivee=${encodeURIComponent(arrivee)}&date=${encodeURIComponent(date)}`
  )
    .then((res) => res.json())
    .then((data) => {
      // Si des trajets sont trouvés, on les affiche
      if (data.success && data.trajets.length) {
        data.trajets.forEach((t) =>
          container.appendChild(buildCard(t, { depart, arrivee, date }))
        );
      } else {
        container.textContent = "Aucun trajet trouvé pour cette recherche.";
      }
    })
    // Gestion des erreurs lors de la requête
    .catch(() => {
      container.textContent = "Erreur lors du chargement des trajets.";
    });
});
