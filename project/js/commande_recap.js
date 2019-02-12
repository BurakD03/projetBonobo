var panier = getPanier();
$("#nom_client").text(panier.utilisateur.nom);
$("#prenom_client").text(panier.utilisateur.prenom);
$("#email_client").text(panier.utilisateur.email);
$("#tel_client").text(panier.utilisateur.telephone);
$("#daterec_commande").text(panier.recuperation.date);
$("#heure_commande").text(panier.recuperation.heure);
if (panier.recuperation.liv === true) {
  $("#num_adresse").text(panier.adresse.numero);
  $("#adresse").text(panier.adresse.adresse);
  $("#codepostal").text(panier.adresse.codePostal);
  $("#ville").text(panier.adresse.ville);
  $("#typecomm").text("La commande est livrée.");
} else {
  $("#typecomm").text("Récupération au restaurant.");
}

var total = 0;
var str = "";
for (var produit of panier.produits) {
  str +=
    "<tr><td>" +
    produit.nom +
    "</td><td>" +
    new Intl.NumberFormat("fr-FR", {
      style: "currency",
      currency: "EUR"
    }).format(produit.prix) +
    "</td><td>" +
    produit.nb +
    "</td><td>" +
    new Intl.NumberFormat("fr-FR", {
      style: "currency",
      currency: "EUR"
    }).format(produit.prix * produit.nb) +
    "</td></tr>";
  total += produit.prix;
}

str += "<tr><th>Menu</th><th>Prix</th><th>Quantité</th><th>Total</th></tr>";

for (var menu of panier.menus) {
  var str2 =
    "<ul><li>" +
    menu.entree.nom +
    "</li><li>" +
    menu.plat.nom +
    "</li><li>" +
    menu.dessert.nom +
    "</li><li>" +
    menu.boisson.nom +
    "</li></ul>";
  str +=
    "<tr><td>" +
    menu.nom +
    str2 +
    "</td><td>" +
    new Intl.NumberFormat("fr-FR", {
      style: "currency",
      currency: "EUR"
    }).format(menu.prix) +
    "</td><td>" +
    menu.nb +
    "</td><td>" +
    new Intl.NumberFormat("fr-FR", {
      style: "currency",
      currency: "EUR"
    }).format(menu.prix * menu.nb) +
    "</td></tr>";
  total += menu.prix;
}

str += "<tr><th colspan='4'>Total de la commande</th></tr>";

str +=
  "<tr><td colspan='3'></td><td>" +
  new Intl.NumberFormat("fr-FR", {
    style: "currency",
    currency: "EUR"
  }).format(total) +
  "</td></tr>";

$("#liste_produits").html(str);
$("#total_commande").text(
  new Intl.NumberFormat("fr-FR", {
    style: "currency",
    currency: "EUR"
  }).format(total)
);
$("#paiement_commande").text(panier.commande.modePaiement);
$("#date_commande").text(panier.commande.date);
