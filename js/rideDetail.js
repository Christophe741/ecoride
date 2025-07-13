import { domReady } from "./domReady.js";

function buildLine(key, value) {
  const p = document.createElement("p");
  p.className = "ride-detail__line";
  if (key) {
    const strong = document.createElement("strong");
    strong.textContent = key;
    p.appendChild(strong);
    p.append(` ${value}`);
  } else {
    p.textContent = value;
  }
  return p;
}

function renderRideDetail(ride, container) {
  const card = document.createElement("div");
  card.className = "ride-detail__card";

  const driver = document.createElement("div");
  driver.className = "ride-detail__driver-info";

  const img = document.createElement("img");
  img.className = "ride-detail__profile-photo";
  img.src = `assets/profils/${ride.photo}`;
  img.alt = `Photo de ${ride.username}`;

  const username = document.createElement("h2");
  username.className = "ride-detail__username";
  username.textContent = ride.username;

  const note = buildLine(null, `Note : ${ride.rating}/5`);

  const prefs = document.createElement("div");
  prefs.className = "ride-detail__preferences";
  if (Array.isArray(ride.preferences)) {
    ride.preferences.forEach((pref) => {
      prefs.appendChild(buildLine(pref.key + " :", pref.value));
    });
  }

  driver.append(img, username, note, prefs);

  const info = document.createElement("div");
  info.className = "ride-detail__info";

  info.append(
    buildLine("Départ :", ride.departure_city),
    buildLine("Arrivée :", ride.arrival_city),
    buildLine(
      "Date et heure :",
      new Date(ride.departure_time).toLocaleString("fr-FR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      })
    ),
    buildLine("Durée :", ride.duration.substring(0, 5)),
    buildLine("Prix :", `${ride.price} €`),
    buildLine("Places disponibles :", ride.seats)
  );
  if (ride.vehicle) {
    if (ride.vehicle.brand || ride.vehicle.model || ride.vehicle.fuel_type) {
      const veh = `${ride.vehicle.brandt} ${ride.vehicle.model} ${ride.vehicle.fuel_type}`;
      info.appendChild(buildLine("Véhicule :", veh));
    }
  }
  if (ride.description) {
    info.append(buildLine("Description :", ride.description));
  }

  card.append(driver, info);
  container.appendChild(card);
}

function renderBackButton(container, from, to, date) {
  const link = document.createElement("a");
  link.href = `rides.php?departure_city=${encodeURIComponent(
    from || ""
  )}&arrival_city=${encodeURIComponent(
    to || ""
  )}&departure_time=${encodeURIComponent(date || "")}`;
  link.className = "ride-detail__back-button";
  link.textContent = "← Retour aux résultats";
  container.appendChild(link);
}

domReady(() => {
  const container = document.getElementById("ride-detail");

  const params = new URLSearchParams(window.location.search);
  const rideId = params.get("id");
  const from = params.get("departure_city");
  const to = params.get("arrival_city");
  const date = params.get("departure_time");

  if (!rideId) {
    container.innerHTML = `<p class="ride-detail__error">Erreur : aucun trajet sélectionné.<p>`;
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
      renderBackButton(container, from, to, date);
    })
    .catch(() => {
      container.innerHTML = `<p class="ride-detail__error">Erreur lors du chargement du trajet.</p>`;
    });
});
