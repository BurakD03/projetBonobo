update(false);

function saveUser() {
  var nom = $("#client_nom").val();
  var prenom = $("#client_prenom").val();
  var email = $("#client_email").val();
  var telephone = $("#client_telephone").val();
  var newsletter = $("#client_newsletter").is(":checked");
  var panier = getPanier();
  panier.utilisateur = {
    nom,
    prenom,
    email,
    telephone,
    newsletter
  };
  setPanier(panier);
  window.location.href = "commande_createdaterec.html";
}

function saveDateRec() {
  var date = $("#daterec").val();
  var heure = $("#heurerec").val();
  var liv = $("#livraison").is(":checked");

  var panier = getPanier();
  panier.recuperation = {
    date,
    heure,
    liv
  };
  setPanier(panier);
  $("#jason").val(JSON.stringify(panier));
  if (liv === true) {
    window.location.href = "commande_createadresse.html";
  } else {
    window.location.href = "commande_index.html";
  }
}

function saveAddress() {
  var numero = $("#livraison_num_adresse").val();
  var adresse = $("#livraison_libelle_adresse").val();
  var codePostal = $("#livraison_code_postal").val();
  var ville = $("#livraison_ville").val();
  var panier = getPanier();
  panier.adresse = {
    numero,
    adresse,
    codePostal,
    ville
  };
  setPanier(panier);
  $("#jason").val(JSON.stringify(panier));
  $("#address_form").submit();
}
