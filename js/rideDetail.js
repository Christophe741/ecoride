import { domReady } from "./domReady.js";

function escapeHTML(str) {
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

function renderRideDetail(t, container) {
  container.innerHTML = `
    <div class="ride-detail__card">
      <div class="ride-detail__driver-info">
        <img src="assets/profils/${escapeHTML(
          t.photo
        )}" alt="Photo de ${escapeHTML(
    t.pseudo
  )}" class="ride-detail__profile-photo">
        <h2 class="ride-detail__username">${escapeHTML(t.pseudo)}</h2>
        <p class="ride-detail__line">Note : ${escapeHTML(t.note)}/5</p>
      </div>
      <div class="ride-detail__info">
        <p class="ride-detail__line"><strong>Départ :</strong> ${escapeHTML(
          t.ville_depart
        )}</p>
        <p class="ride-detail__line"><strong>Arrivée :</strong> ${escapeHTML(
          t.ville_arrivee
        )}</p>
        <p class="ride-detail__line"><strong>Date et heure :</strong> ${new Date(
          t.date_depart
        ).toLocaleString("fr-FR", {
          day: "2-digit",
          month: "2-digit",
          year: "numeric",
          hour: "2-digit",
          minute: "2-digit",
        })}</p>
         <p class="ride-detail__line"><strong>Durée :</strong> ${escapeHTML(
           t.duree.substring(0, 5)
         )}</p>
        <p class="ride-detail__line"><strong>Prix :</strong> ${escapeHTML(
          t.prix
        )} €</p>
        <p class="ride-detail__line"><strong>Places disponibles :</strong> ${escapeHTML(
          t.places
        )}</p>
        <p class="ride-detail__line"><strong>Description :</strong> <span id="description-text">${escapeHTML(
          t.description || "Aucune description"
        )}</span></p>
        <div class="ride-detail__preferences">
          <p class="ride-detail__line"><strong>Ambiance :</strong> ${escapeHTML(
            t.ambiance
          )}</p>
          <p class="ride-detail__line"><strong>Musique :</strong> ${escapeHTML(
            t.musique
          )}</p>
          <p class="ride-detail__line"><strong>Fumeur :</strong> ${escapeHTML(
            t.fumeur
          )}</p>
          <p class="ride-detail__line"><strong>Animaux :</strong> ${escapeHTML(
            t.animaux
          )}</p>
        </div>
        <div id="avis-section"></div>
      </div>
    </div>
  `;
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
    container.textContent = "Erreur : aucun trajet sélectionné.";
    return;
  }

  fetch(`api/get_ride_detail.php?id=${encodeURIComponent(rideId)}`)
    .then((res) => res.json())
    .then((data) => {
      if (!data.success) {
        container.innerHTML = `<p>Trajet introuvable.</p>`;
        return;
      }

      renderRideDetail(data.trajet, container);
      renderBackButton(container, from, to, date);
    })
    .catch(() => {
      container.innerHTML = `<p>Erreur lors du chargement du trajet.</p>`;
    });
});
