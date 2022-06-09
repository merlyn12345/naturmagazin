/* NaturMagazin  ausgabenchecker js
 * 
 * 17102020 oehna
 * 
 * */

"use strict";
(function (){
    var uniqueId='ausgabe'; 
    
    $('#ausgabe').on('change', function (){
        let ausgabe=$('#ausgabe').val();
            $.get('ausgabencheck.php', {'ausgabe': ausgabe}, function (response){
                let myResponse=JSON.parse(response);
                document.querySelector('input[type="submit"]').removeAttribute('disabled');
                var $outputdiv = $('#output');
                var feld = document.getElementById(uniqueId);;
                if(myResponse.status == '200' && myResponse.found == 'true'){
                    document.querySelector('input[type="submit"]').setAttribute('disabled', 'disabled');
                    var ausgabetext = '<p><b>Dieser Wert für '+feld.name.toUpperCase()+'  ist bereits registriert</b><br>Bitte Wert ändern, oder die alte Auagabe löschen.</p>';
                    $outputdiv.html(ausgabetext).addClass('error');
                    feld.style.backgroundColor = '#ff0000';
                    feld.dataset.registered='true';
                }else {
                    feld.dataset.registered='false';
                    feld.style.backgroundColor = '#fff';
                    $outputdiv.html('').removeClass();
                }

            });

        });
        
})();