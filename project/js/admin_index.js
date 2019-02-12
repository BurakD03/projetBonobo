$(function(){
    $('#view').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('whatever');
        $.ajax({
            url : './script_ajaxproduct.html',
            type : 'POST',
            data : 'id='+id,
            dataType : 'json',
            success : function(donneesJSON, statut){
                $('#p_title').text(donneesJSON[0]['NOM']);
                $('#p_image').attr('src',donneesJSON[0]['IMAGE']); 
                $('#p_price').text(
                    new Intl.NumberFormat("fr-FR", {
                    style: "currency",
                    currency: "EUR"
                  }).format(donneesJSON[0]['PRIX'])
                ); 
                $('#p_description').text(donneesJSON[0]['DESCRIPTION']); 
       
            },
            error : function (error){
                console.log(error);
            }
        })
        
    });
    $('#delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('whatever');
        $('#delete_link').attr('href',"./admin_delete_"+id+".html");
        
    });
    var search = $('#searchajax');
    var tab = $("#table_product");
    search.keyup(function(){
        console.log("keyup");
        $.ajax({
            url : './script_ajaxsearch.html',
            type : 'POST',
            data : 'val='+search.val(),
            dataType : 'json',
            success : function(donneesJSON, statut){
                console.log("oui");
                if(donneesJSON[0]!=null){
                    var resultat=listeTable(donneesJSON);
                    tab.html(resultat);
                }else{
                    tab.html("<tr><th>RIEN</th></tr>");
                }
                
             },
            error : function (statut){
                console.log("non");
                tab.html("<tr><th>RIEN</th></tr>");
            }
        }) 
    });
    function listeTable(json){
        var str="";
        for(var i=0;i<json.length;i++){
            var ligne = json[i];
            str=str+"<tr><td>"+ligne.DATE_CREATION+"</td><td>"+ligne.NOM+"</td><td>"+ligne.DESCRIPTION+"</td><td>"+ligne.PRIX+"</td>";
            str=str+"<td>"+ligne.CATEGORIE+"</td><td><button type='button' class='btn btn-outline-dark' data-toggle='modal' data-target='#view'";
            str=str+" data-whatever='"+ligne.ID_PRODUIT+"'><i class='far fa-eye'></i> Voir</button><a class='btn btn-primary' href='./admin_edit_";
            str=str+ligne.ID_PRODUIT+".html'><i class='far fa-edit'></i></span> Modifier</a><button type='button' class='btn btn-danger' data-toggle='modal'";
            str=str+" data-target='#delete' data-whatever='"+ligne.ID_PRODUIT+"'><i class='far fa-trash-alt'></i> Supprimer</a></button></td></tr>";
        }
        return str;
    }
});
