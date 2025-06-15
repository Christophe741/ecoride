import { domReady } from "./domReady.js";

domReady(() => {
  const container = document.querySelector("#trajet-detail");
  const params = new URLSearchParams(window.location.search);
  const id = params.get("id");
  const depart = params.get("depart");
  const arrivee = params.get("arrivee");
  const date = params.get("date");

  if (!id) {
    container.textContent = "Erreur : aucun trajet sélectionné.";
    return;
  }

  fetch(`api/detail.php?id=${encodeURIComponent(id)}`)
    .then((res) => res.json())
    .then((data) => {
      if (!data.success) {
        container.textContent = "Trajet introuvable.";
        return;
      }
      const t = data.trajet;
      container.innerHTML = `
        <div class="trajet-detail-card">
          <div class="conducteur-info">
            <img src="assets/profils/${t.photo}" alt="Photo de ${
        t.pseudo
      }" class="photo-profil">
            <h2>${t.pseudo}</h2>
            <p>Note : ${t.note}/5</p>
          </div>
          <div class="trajet-info">
            <p><strong>Départ :</strong> ${t.ville_depart}</p>
            <p><strong>Arrivée :</strong> ${t.ville_arrivee}</p>
            <p><strong>Date et heure :</strong> ${new Date(
              t.date_depart
            ).toLocaleString("fr-FR", {
              day: "2-digit",
              month: "2-digit",
              year: "numeric",
              hour: "2-digit",
              minute: "2-digit",
            })}</p>
            <p><strong>Prix :</strong> ${t.prix} €</p>
            <p><strong>Places disponibles :</strong> ${t.places}</p>
          </div>
        </div>
      `;
      const link = document.createElement("a");
      link.href = `covoiturage.php?depart=${depart || ""}&arrivee=${
        arrivee || ""
      }&date=${date || ""}`;
      link.className = "btn-retour";
      link.textContent = "← Retour aux résultats";
      container.appendChild(link);
    })
    .catch(() => {
      container.textContent = "Erreur lors du chargement du trajet.";
    });
});
