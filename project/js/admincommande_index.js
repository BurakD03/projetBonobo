$(function(){
    $('#show').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        $.ajax({
            url : './script_ajaxcommande.html',
            type : 'POST',
            data : 'id='+id,
            dataType : 'json',
            success : function(donneesJSON, statut){
                $('#show_text').html(liste(donneesJSON));
                
       
            },
            error : function (error){
                console.log(error);
            }
        })
        
    });
    function liste(json){
        var p =json.tab;
        var m = json.meal;
        var str = '';
        var cout=0;
        for(var i=0;i<p.length;i++){
            var ligne = p[i];
            cout=cout+ligne.NB*ligne.PRIX;
            str = str + ligne.NB+"x"+ligne.NOM +" : "+new Intl.NumberFormat("fr-FR", {style: "currency",currency: "EUR"}).format(ligne.NB*ligne.PRIX)+"<br/>";
        }
        for(var k=0;k<m.length;k++){
            var ligne = m[k];
            cout=cout+ligne.NB*ligne.MENU_PRIX;
            str = str + ligne.NB+"x"+ligne.MENU_NOM +" : ";
            for(var j=0;j<ligne.COMPO.length;j++){
                str=str+ligne.COMPO[j]+", ";
            }
            str=str+new Intl.NumberFormat("fr-FR", {style: "currency",currency: "EUR"}).format(ligne.NB*ligne.MENU_PRIX)+"<br/>";
        }
        str=str+"<hr/>Total : "+new Intl.NumberFormat("fr-FR", {style: "currency",currency: "EUR"}).format(cout);
        return str;
    }
    
});
