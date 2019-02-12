$(function(){
    $("#valide_panier").click(function(){
        var panier = getPanier();
        panier.commentaire = $("#commande_commentaire").val();
        panier.paiement = $("#paiement").val();
        console.log(panier);
        $.ajax({
            url : './commande_create.html',
            type : 'POST',
            data : 'json='+JSON.stringify(panier),
            dataType : 'json',
            success : function(donneesJSON, statut){
                if(donneesJSON == " "){
                    alert('commande enregistré');
                    clear();
                    window.location.href='bonobo_index.html';
                }else{
                    alert('erreur');
                }
       
            },
            error : function (error){
                console.log(error);
                alert('erreur');
            }
        })
    });
});
