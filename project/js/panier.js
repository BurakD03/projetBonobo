var defaultPanier = {
  utilisateur: {
    prenom: "",
    nom: "",
    email: "",
    telephone: "",
    newsletter: false
  },
  adresse: {
    numero: "",
    adresse: "",
    codePostal: "",
    ville: ""
  },
  commande: {
    date: "",
    modePaiement: ""
  },
  produits: [],
  menus: [],
  date: Date.now(),
  version: 2
};

function getPanier() {
  var panier = localStorage.getItem("panier");
  if (panier == null) {
    panier = defaultPanier;
    setPanier(panier);
  } else {
    try {
      panier = JSON.parse(panier);
      /*
        Si le panier a plus de 48 heures ou si il est d'une version precedente, il est supprimé.
      */
      if (
        Date.now() - panier.date > 172800000 ||
        panier.version < defaultPanier.version ||
        panier.version == null
      ) {
        panier = defaultPanier;
        setPanier(panier);
      }
    } catch (e) {
      panier = defaultPanier;
      setPanier(panier);
    }
  }
  return panier;
}

function setPanier(panier) {
  localStorage.setItem("panier", JSON.stringify(panier));
}

function addProduct(productId) {
  var panier = getPanier();
  var p_id = +productId.substring(2);
  var p_price = $("#" + productId + "_price").data("price");
  var p_name = $("#" + productId + "_name").text();
  var existe = false;

  /**
   * Si le produit est déjà ajouté, incremente le nombre de produits.
   */
  for (var produit of panier.produits) {
    if (produit.id === p_id) {
      existe = true;
      produit.nb += 1;
      produit.prix = p_price;
      produit.nom = p_name;
      break;
    }
  }

  /**
   * Si le produit n'existe pas, alors creation d'une nouvelle entité.
   */
  if (existe === false) {
    panier.produits.push({
      id: p_id,
      nom: p_name,
      prix: p_price,
      nb: 1
    });
  }

  setPanier(panier);
  update();
}

function addMenu(menuId) {
  var menu = {
    id: menuId,
    nom: $("#m_" + menuId + "_name").text(),
    prix: $("#m_" + menuId + "_price").data("price"),
    nb: 1,
    entree: {
      nom: $("#entree" + menuId + " option:selected").text()
    },
    plat: {
      nom: $("#plat" + menuId + " option:selected").text()
    },
    dessert: {
      nom: $("#dessert" + menuId + " option:selected").text()
    },
    boisson: {
      nom: $("#boisson" + menuId + " option:selected").text()
    }
  };
  var panier = getPanier();
  var existe = false;
  for (var m of panier.menus) {
    if (
      m.id === menuId &&
      menu.entree.nom === m.entree.nom &&
      menu.plat.nom === m.plat.nom &&
      menu.dessert.nom === m.dessert.nom &&
      menu.boisson.nom === m.boisson.nom
    ) {
      existe = true;
      m.nb += 1;
      m.nom = menu.nom;
      m.prix = menu.prix;
      break;
    }
  }

  if (existe === false) {
    panier.menus.push(menu);
  }

  setPanier(panier);
  update();
}

function removeMenu(menuIndex) {
  var panier = getPanier();

  panier.menus = panier.menus.filter((menu, index) => {
    if (menuIndex === index) {
      if (menu.nb === 1) {
        return false;
      } else {
        menu.nb--;
        return true;
      }
    } else {
      return true;
    }
  });

  setPanier(panier);
  update();
}

function removeProduct(productId) {
  var panier = getPanier();
  panier.produits = panier.produits.filter(produit => {
    if (produit.id === productId) {
      if (produit.nb === 1) {
        return false;
      } else {
        produit.nb--;
        return true;
      }
    } else {
      return true;
    }
  });

  setPanier(panier);
  update();
}

function update(edit = true) {
  var panier = getPanier();
  var str = "";
  var str2 = "";
  var total = 0;
  if (panier.produits.length > 0) {
    for (var produit of panier.produits) {
      str +=
        '<li class="list-group-item">' +
        produit.nom +
        "<span class='float-right'>" +
        produit.nb +
        " x " +
        new Intl.NumberFormat("fr-FR", {
          style: "currency",
          currency: "EUR"
        }).format(produit.prix) +
        " ";
      if (edit) {
        str +=
          '<button type="button" class="btn btn-warning" onclick="removeProduct(' +
          produit.id +
          ')"><i class="fa fa-times"></i></button>';
      }
      str += "</span></li>";
      total += produit.nb * produit.prix;
    }
  } else {
    $("#panier_ligne").html('<li class="list-group-item">vide</li>');
  }

  if (panier.menus.length > 0) {
    for (var i = 0; i < panier.menus.length; i++) {
      var menu = panier.menus[i];
      str2 +=
        '<li class="list-group-item">' +
        menu.nom +
        "<div class='float-right'>" +
        menu.nb +
        " x " +
        new Intl.NumberFormat("fr-FR", {
          style: "currency",
          currency: "EUR"
        }).format(menu.prix) +
        " ";
      if (edit) {
        str2 +=
          '<button type="button" class="btn btn-warning" onclick="removeMenu(' +
          i +
          ')"><i class="fa fa-times"></i></button>';
      }
      str2 +=
        "</div><div class='mt-5'><ul><li>" +
        menu.entree.nom +
        "</li><li>" +
        menu.plat.nom +
        "</li><li>" +
        menu.dessert.nom +
        "</li><li>" +
        menu.boisson.nom +
        "</li></ul></div></li>";
      total += menu.nb * menu.prix;
    }
  } else {
    $("#menu_ligne").html('<li class="list-group-item">vide</li>');
  }

  $("#panier_ligne").html(str);
  $("#menu_ligne").html(str2);
  $("#panier_montant").html(
    new Intl.NumberFormat("fr-FR", {
      style: "currency",
      currency: "EUR"
    }).format(total)
  );
}

function clear() {
  var panier = getPanier();
  panier.produits = [];
  panier.menus = [];
  setPanier(panier);
}
