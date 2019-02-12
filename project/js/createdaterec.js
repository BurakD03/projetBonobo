var panier = getPanier();
$("#daterec").val(panier.recuperation.date);
$("#heurerec").val(panier.recuperation.heure);
$("#livraison").prop("checked", panier.recuperation.liv);
update();
