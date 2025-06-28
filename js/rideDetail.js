// Importation de la fonction domReady pour exécuter le code une fois le DOM chargé
import { domReady } from "./domReady.js";

// Exécution du code principal lorsque le DOM est prêt
domReady(() => {
  // Sélection du conteneur où seront affichés les détails du trajet
  const container = document.querySelector("#trajet-detail");
  // Récupération des paramètres de l'URL
  const params = new URLSearchParams(window.location.search);
  const id = params.get("id");
  const depart = params.get("depart");
  const arrivee = params.get("arrivee");
  const date = params.get("date");

  // Vérification de la présence de l'id du trajet, sinon message d'erreur
  if (!id) {
    container.textContent = "Erreur : aucun trajet sélectionné.";
    return;
  }

  // Requête pour obtenir les détails du trajet depuis l'API PHP
  fetch(`api/get_ride_detail.php?id=${encodeURIComponent(id)}`)
    .then((res) => res.json())
    .then((data) => {
      // Si le trajet n'est pas trouvé, affichage d'un message d'erreur
      if (!data.success) {
        container.innerHTML = `<p>Trajet introuvable.</p>`;
        return;
      }
      // Récupération des informations du trajet
      const t = data.trajet;
      // Génération dynamique du HTML pour afficher les informations du trajet et du conducteur
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
        <p><strong>Description :</strong> <span id="description-text">${
          t.description || "Aucune description"
        }</span></p>
            <!-- Préférences du conducteur (ambiance, musique, etc.) -->
            <div class="preferences-info">
              <p><strong>Ambiance :</strong> ${t.ambiance}</p>
              <p><strong>Musique :</strong> ${t.musique}</p>
              <p><strong>Fumeur :</strong> ${t.fumeur}</p>
              <p><strong>Animaux :</strong> ${t.animaux}</p>
            </div>
           <!-- Section pour les avis utilisateurs (à remplir dynamiquement) -->
           <div id="avis-section"></div>

            </div>
        </div>
      `;
      // Création et ajout du bouton de retour vers la liste des résultats de recherche
      const link = document.createElement("a");
      link.href = `rides.php?depart=${depart || ""}&arrivee=${
        arrivee || ""
      }&date=${date || ""}`;
      link.className = "btn-retour";
      link.textContent = "← Retour aux résultats";
      container.appendChild(link);
    })
    // Gestion des erreurs lors de la requête fetch
    .catch(() => {
      container.innerHTML = `<p>Erreur lors du chargement du trajet.</p>`;
    });
});
