/* NaturMagazin  loeschen js
 * 
 * 09102020 oehna
 * 
 * */

"use strict";
(function (){
    $('#magazin').on('click', function (){
        // Ausgabe in Modal lesen/schreiben
        console.log($('#ausgabe').val());
        $('#ausgabespan').html($('#ausgabe').val());        
    });
    
    
    $('#magazinloeschen').on('click', function (){
        let magazinid=$('#galerien_id').val();
        console.log(magazinid);
        $.get('magazin_loeschen.php', {'magazinid': magazinid}, function (response){
            let myResponse=JSON.parse(response);
            console.log(myResponse);
            console.log(myResponse.magazindel);
            if(myResponse.magazindel == 'OK'){
                console.log($('#postform'));
                $('#aendernheader, #postform, #loescharea').hide();
                let htmlstring = '<h3>Naturmagazin Ausgabe: '+myResponse.ausgabe+' wurde gelöscht</h3>';
                htmlstring += '<p><br><br><a href="index.php?id=14&galerie_id=0">zurück zur Übersicht</a></p>';
                $('#response').html(htmlstring);
                
            }
        });
    });
})();