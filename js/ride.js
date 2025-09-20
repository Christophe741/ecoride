// === Import des dépendances ===

import { cloneTemplate, renderMessage } from "./utils/dom.js";

// === Fonctions liées au rendu DOM ===

function buildRideDetail(ride) {
  const card = cloneTemplate("ride-detail-template");
  updateProfile(card, ride);
  updateRideInfo(card, ride);
  updatePreferences(card, ride);
  updateVehicle(card, ride);
  updateDescription(card, ride);
  updateEcoBadge(card, ride);

  return card;
}

function updateProfile(card, ride) {
  const img = card.querySelector(".ride-detail__profile-photo");
  img.src = `assets/profile-pictures/${ride.photo}`;
  img.alt = `Photo de ${ride.username}`;

  card.querySelector(".ride-detail__username").textContent = ride.username;
  card.querySelector(".ride-note").textContent = `${ride.rating}/5`;
}

function updateRideInfo(card, ride) {
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
}

function updatePreferences(card, ride) {
  const prefsContainer = card.querySelector(".ride-detail__preferences");
  const model = prefsContainer.querySelector(".ride-detail__preference-item");
  if (Array.isArray(ride.preferences) && ride.preferences.length > 0) {
    ride.preferences.forEach((pref) => {
      const line = model.cloneNode(true);
      line.querySelector(
        ".ride-detail__preference-key"
      ).textContent = `${pref.key} :`;
      line.querySelector(".ride-detail__preference-value").textContent =
        pref.value;
      prefsContainer.appendChild(line);
    });
    model.remove();
  } else {
    prefsContainer.remove();
  }
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
  const vehContainer = card.querySelector(".ride-detail__vehicle");
  card.querySelector(
    ".ride-vehicle"
  ).textContent = `${ride.vehicle.brand} ${ride.vehicle.model} ${ride.vehicle.fuel_type}`;
}

function updateDescription(card, ride) {
  const descContainer = card.querySelector(".ride-detail__description");
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
        renderMessage(data.message, container);
        return;
      }

      renderRideDetail(data.ride, container);
      renderBackButton(container);
    })
    .catch(() => {
      renderMessage(
        "Erreur lors du chargement du trajet.",
        container,
        "clear",
        "error"
      );
    });
}

// === Point d’entrée du script ===

const container = document.getElementById("ride-detail");
const rideId = new URLSearchParams(window.location.search).get("id");

if (!rideId) {
  renderMessage("Aucun trajet sélectionné.", container);
} else {
  fetchRideDetail(rideId, container);
}
