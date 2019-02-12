var panier = getPanier();
$("#livraison_num_adresse").val(panier.adresse.numero);
$("#livraison_libelle_adresse").val(panier.adresse.adresse);
$("#livraison_ville").val(panier.adresse.ville);
$("#livraison_code_postal").val(panier.adresse.codePostal);

update();
