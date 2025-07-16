import { domReady } from "./domReady.js";

function buildCard(ride, query) {
  const card = document.createElement("div");
  card.className = "ride-card";

  // Partie gauche : photo du conducteur
  const left = document.createElement("div");
  left.className = "ride-card__left";
  const img = document.createElement("img");
  img.className = "ride-card__photo";
  img.src = `assets/profile-pictures/${ride.photo}`;
  img.alt = `Photo de ${ride.username}`;
  left.appendChild(img);

  // Partie centrale : infos principales du trajet
  const middle = document.createElement("div");
  middle.className = "ride-card__middle";
  const title = document.createElement("h3");
  title.className = "ride-card__title";
  title.textContent = ride.username;
  middle.appendChild(title);
  const note = document.createElement("p");
  note.appendChild(document.createElement("strong")).textContent = "Note :";
  note.append(` ${ride.rating} / 5`);
  const places = document.createElement("p");
  places.appendChild(document.createElement("strong")).textContent =
    "Places restantes :";
  places.append(` ${ride.seats}`);
  const prix = document.createElement("p");
  prix.appendChild(document.createElement("strong")).textContent = "Prix :";
  prix.append(` ${ride.price} €`);
  const departure_city = document.createElement("p");
  departure_city.appendChild(document.createElement("strong")).textContent =
    "Départ :";
  departure_city.append(` ${ride.departure_city}`);
  const arrival_city = document.createElement("p");
  arrival_city.appendChild(document.createElement("strong")).textContent =
    "Arrivée :";
  arrival_city.append(` ${ride.arrival_city}`);

  middle.append(title, note, places, prix, departure_city, arrival_city);

  // Partie droite : badge et bouton détail
  const right = document.createElement("div");
  right.className = "ride-card__right";
  const badge = document.createElement("span");
  badge.className = "ride-card__badge";
  badge.textContent = "✔ Écologique";
  const link = document.createElement("a");
  link.className = "ride-card__button";
  const params = new URLSearchParams(query);
  params.set("id", ride.id);
  link.href = `rideDetail.php?${params.toString()}`;
  link.textContent = "Détail";
  right.append(badge, link);

  card.append(left, middle, right);
  return card;
}

domReady(() => {
  const container = document.getElementById("results");

  const params = new URLSearchParams(window.location.search);
  const departure_city = params.get("from");
  const arrival_city = params.get("to");
  const departure_time = params.get("date");

  if (!(departure_city && arrival_city && departure_time)) {
    container.textContent =
      "Veuillez saisir une ville de départ, d'arrivée et une date.";
    return;
  }

  fetch(
    `api/get_rides.php?from=${encodeURIComponent(
      departure_city
    )}&to=${encodeURIComponent(arrival_city)}&date=${encodeURIComponent(
      departure_time
    )}`
  )
    .then((res) => res.json())
    .then((data) => {
      if (data.success && data.rides.length) {
        data.rides.forEach((ride) =>
          container.appendChild(
            buildCard(ride, { departure_city, arrival_city, departure_time })
          )
        );
      } else {
        container.textContent = "Aucun trajet trouvé pour cette recherche.";
      }
    })

    .catch(() => {
      container.textContent = "Erreur lors du chargement des trajets.";
    });
});
