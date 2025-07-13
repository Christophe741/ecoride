db = db.getSiblingDB("ecoride");
db.rides.insertMany([
  {
    ride_id: 5,
    description: "Conducteur sérieux, bonne ambiance, ponctualité assurée.",
  },
  {
    ride_id: 4,
    description:
      "Conductrice attentive et souriante, j'aime proposer des trajets confortables et agréables. Ambiance détendue, musique douce en fond, papotages si on en a envie, et bien sûr, petite pause café si besoin. Au plaisir de partager un trajet avec vous !",
  },
]);
