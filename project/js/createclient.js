var panier = getPanier();
$("#client_nom").val(panier.utilisateur.nom);
$("#client_prenom").val(panier.utilisateur.prenom);
$("#client_email").val(panier.utilisateur.email);
$("#client_telephone").val(panier.utilisateur.telephone);
$("#client_newsletter").prop("checked", panier.utilisateur.newsletter);
