const dbName = process.env.MONGO_DB;
const appUser = process.env.MONGO_USER;
const appPass = process.env.MONGO_PASS;

db = db.getSiblingDB(dbName);

db.createUser({
  user: appUser,
  pwd: appPass,
  roles: [{ role: "readWrite", db: dbName }],
});

db.rides.insertMany([
  {
    ride_id: 5,
    description: "Conducteur sérieux, bonne ambiance, ponctualité assurée.",
  },
  {
    ride_id: 4,
    description:
      "Conductrice attentive et souriante, j'aime proposer des trajets confortables et agréables. " +
      "Ambiance détendue, musique douce en fond, papotages si on en a envie, et bien sûr, petite pause café si besoin. " +
      "Au plaisir de partager un trajet avec vous !",
  },
]);
