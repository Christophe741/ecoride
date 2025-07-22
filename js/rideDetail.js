import { domReady } from "./domReady.js";

function renderRideDetail(ride, container) {
  const tpl = document.getElementById("ride-detail-template");
  const card = tpl.content.firstElementChild.cloneNode(true);

  const img = card.querySelector(".ride-detail__profile-photo");
  img.src = `assets/profile-pictures/${ride.photo}`;
  img.alt = `Photo de ${ride.username}`;

  img.src = `assets/profile-pictures/${ride.photo}`;
  img.alt = `Photo de ${ride.username}`;

  card.querySelector(".ride-detail__username").textContent = ride.username;
  card.querySelector(".ride-note").textContent = `Note : ${ride.rating}/5`;

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

  const badge = card.querySelector(".ride-card__badge");
  if (ride["is_eco_friendly"]) {
    badge.textContent = "✔ Écologique";
  } else {
    badge.remove();
  }

  card.querySelector(".ride-departure").textContent = ride.departure_city;
  card.querySelector(".ride-arrival").textContent = ride.arrival_city;
  card.querySelector(".ride-date").textContent = new Date(
    ride.departure_time
  ).toLocaleString("fr-FR", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
  card.querySelector(".ride-duration").textContent = ride.duration.substring(
    0,
    5
  );
  card.querySelector(".ride-price").textContent = `${ride.price} €`;
  card.querySelector(".ride-seats").textContent = ride.seats;

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

  const descContainer = card.querySelector(".ride-description-container");
  if (ride.description) {
    card.querySelector(".ride-description").textContent = ride.description;
  } else {
    descContainer.remove();
  }

  container.appendChild(card);
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

domReady(() => {
  const container = document.getElementById("ride-detail");

  const params = new URLSearchParams(window.location.search);
  const rideId = params.get("id");

  if (!rideId) {
    container.innerHTML = `<p class="ride-detail__error">Erreur : aucun trajet sélectionné.</p>`;
    return;
  }

  fetch(`api/get_ride_detail.php?id=${encodeURIComponent(rideId)}`)
    .then((res) => res.json())
    .then((data) => {
      if (!data.success) {
        container.innerHTML = `<p class="ride-detail__error">Trajet introuvable.</p>`;
        return;
      }

      renderRideDetail(data.ride, container);
      renderBackButton(container);
    })
    .catch(() => {
      container.innerHTML = `<p class="ride-detail__error">Erreur lors du chargement du trajet.</p>`;
    });
});
