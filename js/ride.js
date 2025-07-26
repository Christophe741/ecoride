// === Import des dépendances ===

import { domReady } from "./domReady.js";
import { cloneTemplate, renderError } from "./utils/dom.js";

// === Fonctions liées au rendu DOM ===

function buildRideDetail(ride) {
  const card = cloneTemplate("ride-detail-template");
  updateProfile(card, ride);
  updateRideInfo(card, ride);
  return card;
}

function updateProfile(card, ride) {
  const img = card.querySelector(".ride-detail__profile-photo");
  img.src = `assets/profile-pictures/${ride.photo}`;
  img.alt = `Photo de ${ride.username}`;

  card.querySelector(".ride-detail__username").textContent = ride.username;
  card.querySelector(".ride-note").textContent = `Note : ${ride.rating}/5`;
  updatePreferences(card, ride);
}

function updatePreferences(card, ride) {
  const prefsContainer = card.querySelector(".ride-detail__preferences");
  const model = prefsContainer.querySelector(".pref-item");
  if (Array.isArray(ride.preferences) && ride.preferences.length > 0) {
    ride.preferences.forEach((pref) => {
      const line = model.cloneNode(true);
      line.querySelector(".pref-key").textContent = `${pref.key} :`;
      line.querySelector(".pref-value").textContent = pref.value;
      prefsContainer.appendChild(line);
    });
    model.remove();
  } else {
    prefsContainer.remove();
  }
}

function updateRideInfo(card, ride) {
  updateEcoBadge(card, ride);
  card.querySelector(".ride-departure").textContent = ride.departure_city;
  card.querySelector(".ride-arrival").textContent = ride.arrival_city;
  card.querySelector(".ride-date").textContent = formatDate(
    ride.departure_time
  );
  card.querySelector(".ride-duration").textContent = ride.duration.substring(
    0,
    5
  );
  card.querySelector(".ride-price").textContent = `${ride.price} €`;
  card.querySelector(".ride-seats").textContent = ride.seats;
  updateVehicle(card, ride);
  updateDescription(card, ride);
}

function updateEcoBadge(card, ride) {
  const badge = card.querySelector(".ride-card__badge");
  if (ride.is_eco_friendly) {
    badge.textContent = "✔ Écologique";
  } else {
    badge.remove();
  }
}

function updateVehicle(card, ride) {
  const vehContainer = card.querySelector(".ride-vehicle-container");
  if (
    ride.vehicle &&
    (ride.vehicle.brand || ride.vehicle.model || ride.vehicle.fuel_type)
  ) {
    card.querySelector(
      ".ride-vehicle"
    ).textContent = `${ride.vehicle.brand} ${ride.vehicle.model} ${ride.vehicle.fuel_type}`;
  } else {
    vehContainer.remove();
  }
}

function updateDescription(card, ride) {
  const descContainer = card.querySelector(".ride-description-container");
  if (ride.description) {
    card.querySelector(".ride-description").textContent = ride.description;
  } else {
    descContainer.remove();
  }
}

function renderRideDetail(ride, container) {
  container.appendChild(buildRideDetail(ride));
}

function renderBackButton(container) {
  const params = new URLSearchParams(window.location.search);
  params.delete("id");

  const link = document.createElement("a");
  link.href = `search.php?${params.toString()}`;
  link.className = "ride-detail__back-button";
  link.textContent = "← Retour aux résultats";

  container.appendChild(link);
}

// === Fonctions utilitaires ===

function formatDate(date) {
  return new Date(date).toLocaleString("fr-FR", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
}

// === Fonctions métier ===

function fetchRideDetail(rideId, container) {
  fetch(`api/get_ride_detail.php?id=${encodeURIComponent(rideId)}`)
    .then((res) => res.json())
    .then((data) => {
      if (!data.success) {
        renderError("Trajet introuvable.", container);
        return;
      }

      renderRideDetail(data.ride, container);
      renderBackButton(container);
    })
    .catch(() => {
      renderError("Erreur lors du chargement du trajet.", container);
    });
}

// === Point d’entrée du script ===

domReady(() => {
  const container = document.getElementById("ride-detail");
  const rideId = new URLSearchParams(window.location.search).get("id");

  if (!rideId) {
    renderError("Erreur : aucun trajet sélectionné.", container);
    return;
  }

  fetchRideDetail(rideId, container);
});
