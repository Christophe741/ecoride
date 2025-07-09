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
  img.alt = `Photo de ${ride.pseudo}`;

  const username = document.createElement("h2");
  username.className = "ride-detail__username";
  username.textContent = ride.pseudo;

  const note = buildLine(null, `Note : ${ride.note}/5`);

  const prefs = document.createElement("div");
  prefs.className = "ride-detail__preferences";
  prefs.append(
    buildLine("Ambiance :", ride.ambiance),
    buildLine("Musique :", ride.musique),
    buildLine("Fumeur :", ride.fumeur),
    buildLine("Animaux :", ride.animaux)
  );

  driver.append(img, username, note, prefs);

  const info = document.createElement("div");
  info.className = "ride-detail__info";

  info.append(
    buildLine("Départ :", ride.ville_depart),
    buildLine("Arrivée :", ride.ville_arrivee),
    buildLine(
      "Date et heure :",
      new Date(ride.date_depart).toLocaleString("fr-FR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      })
    ),
    buildLine("Durée :", ride.duree.substring(0, 5)),
    buildLine("Prix :", `${ride.prix} €`),
    buildLine("Places disponibles :", ride.places)
  );

  const desc = document.createElement("p");
  desc.className = "ride-detail__line";
  const strongDesc = document.createElement("strong");
  strongDesc.textContent = "Description :";
  const descSpan = document.createElement("span");
  descSpan.id = "description-text";
  descSpan.textContent = ride.description || "Aucune description";
  desc.append(strongDesc, " ", descSpan);
  info.appendChild(desc);

  card.append(driver, info);
  container.appendChild(card);
}

function renderBackButton(container, from, to, date) {
  const link = document.createElement("a");
  link.href = `rides.php?depart=${encodeURIComponent(
    from || ""
  )}&arrivee=${encodeURIComponent(to || "")}&date=${encodeURIComponent(
    date || ""
  )}`;
  link.className = "ride-detail__back-button";
  link.textContent = "← Retour aux résultats";
  container.appendChild(link);
}

domReady(() => {
  const container = document.getElementById("ride-detail");

  const params = new URLSearchParams(window.location.search);
  const rideId = params.get("id");
  const from = params.get("depart");
  const to = params.get("arrivee");
  const date = params.get("date");

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

      renderRideDetail(data.trajet, container);
      renderBackButton(container, from, to, date);
    })
    .catch(() => {
      container.innerHTML = `<p class="ride-detail__error">Erreur lors du chargement du trajet.</p>`;
    });
});
