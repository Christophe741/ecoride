import { domReady } from "./domReady.js";

function buildCard(ride) {
  const tpl = document.getElementById("ride-card-template");
  const card = tpl.content.firstElementChild.cloneNode(true);

  const img = card.querySelector(".ride-card__photo");
  img.src = `assets/profile-pictures/${ride.photo}`;
  img.alt = `Photo de ${ride.username}`;

  card.querySelector(".ride-card__title").textContent = ride.username;
  card.querySelector(".ride-rating").textContent = `${ride.rating} / 5`;
  card.querySelector(".ride-seats").textContent = ride.seats;
  card.querySelector(".ride-price").textContent = `${ride.price} €`;
  card.querySelector(".ride-departure").textContent = ride.departure_city;
  card.querySelector(".ride-arrival").textContent = ride.arrival_city;

  const badge = card.querySelector(".ride-card__badge");
  if (ride["is_eco_friendly"]) {
    badge.textContent = "✔ Écologique";
  } else {
    badge.remove();
  }

  const link = card.querySelector(".ride-card__button");
  const params = new URLSearchParams();
  params.set("from", ride.departure_city);
  params.set("to", ride.arrival_city);
  params.set("date", ride.departure_time);
  params.set("id", ride.id);
  link.href = `ride.php?${params.toString()}`;
  link.textContent = "Détail";

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
        data.rides.forEach((ride) => container.appendChild(buildCard(ride)));
      } else {
        container.textContent = "Aucun trajet trouvé pour cette recherche.";
      }
    })

    .catch(() => {
      container.textContent = "Erreur lors du chargement des trajets.";
    });
});
