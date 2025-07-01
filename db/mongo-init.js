db = db.getSiblingDB("ecoride");
db.users.insertMany([
  {
    user_id: 5,
    description: "Conducteur sérieux, bonne ambiance, ponctualité assurée.",
  },
  {
    user_id: 1,
    description:
      "Conductrice attentive et souriante, j'aime proposer des trajets confortables et agréables. Ambiance détendue, musique douce en fond, papotages si on en a envie, et bien sûr, petite pause café si besoin. Au plaisir de partager un trajet avec vous !",
  },
]);
