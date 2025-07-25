// === Import des dépendances ===

import { domReady } from "./domReady.js";

// === Fonctions liées au rendu DOM ===

function buildCard(ride) {
  const card = cloneTemplate();
  updateCardImage(card, ride);
  updateCardText(card, ride);
  updateCardBadge(card, ride);
  updateCardLink(card, ride);

  return card;
}

function cloneTemplate() {
  const tpl = document.getElementById("ride-card-template");
  return tpl.content.firstElementChild.cloneNode(true);
}

function updateCardImage(card, ride) {
  const img = card.querySelector(".ride-card__photo");
  img.src = `assets/profile-pictures/${ride.photo}`;
  img.alt = `Photo de ${ride.username}`;
}

function updateCardText(card, ride) {
  card.querySelector(".ride-card__title").textContent = ride.username;
  card.querySelector(".ride-rating").textContent = `${ride.rating} / 5`;
  card.querySelector(".ride-seats").textContent = ride.seats;
  card.querySelector(".ride-price").textContent = `${ride.price} €`;
  card.querySelector(".ride-departure").textContent = ride.departure_city;
  card.querySelector(".ride-arrival").textContent = ride.arrival_city;
}

function updateCardBadge(card, ride) {
  const badge = card.querySelector(".ride-card__badge");
  if (ride.is_eco_friendly) {
    badge.textContent = "✔ Écologique";
  } else {
    badge.remove();
  }
}

function updateCardLink(card, ride) {
  const link = card.querySelector(".ride-card__button");
  const params = new URLSearchParams({
    from: ride.departure_city,
    to: ride.arrival_city,
    date: ride.departure_time.split(" ")[0],
    id: ride.id,
  });
  link.href = `ride.php?${params.toString()}`;
  link.textContent = "Détail";
}

// === Fonctions utilitaires ===

function getPageParams() {
  const params = new URLSearchParams(window.location.search);
  return {
    from: params.get("from"),
    to: params.get("to"),
    date: params.get("date"),
  };
}

function updateHistory(from, to, date) {
  const searchParams = new URLSearchParams();
  searchParams.set("from", from);
  searchParams.set("to", to);
  searchParams.set("date", date);

  const newUrl = `${window.location.pathname}?${searchParams.toString()}`;
  window.history.pushState(null, "", newUrl);
}

// === Fonctions métier ===

function fetchRides(from, to, date, container, title) {
  if (title) {
    title.hidden = false;
  }
  container.innerHTML = "";
  fetch(
    `api/get_rides.php?from=${encodeURIComponent(from)}&to=${encodeURIComponent(
      to
    )}&date=${encodeURIComponent(date)}`
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
}

function handleFormSubmit(e, form, container, title) {
  e.preventDefault();
  const from = form.elements.from.value;
  const to = form.elements.to.value;
  const date = form.elements.date.value;

  if (!(from && to && date)) {
    container.textContent =
      "Veuillez saisir une ville de départ, d'arrivée et une date.";
    return;
  }

  updateHistory(from, to, date);
  fetchRides(from, to, date, container, title);
}

function handlePopState(form, container, title) {
  const { from, to, date } = getPageParams();

  form.elements.from.value = from;
  form.elements.to.value = to;
  form.elements.date.value = date;

  if (from && to && date) {
    fetchRides(from, to, date, container, title);
  } else if (title) {
    title.hidden = true;
  }
}

// === Point d’entrée du script ===

domReady(() => {
  const container = document.getElementById("results");
  const form = document.getElementById("search-form");
  const title = document.getElementById("results-title");
  const { from, to, date } = getPageParams();
  if (from && to && date) {
    fetchRides(from, to, date, container, title);
  }

  form.addEventListener("submit", (e) =>
    handleFormSubmit(e, form, container, title)
  );
  window.addEventListener("popstate", () =>
    handlePopState(form, container, title)
  );
});
