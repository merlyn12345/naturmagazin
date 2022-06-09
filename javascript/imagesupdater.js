(function (){
    function update(){
        $('input[type="radio"]').removeAttr('disabled');
        var magazinid = $('#galerie').val();
        //hier jetzt die Abfragefunktion starten
        $.ajax({
           dataType: 'json',
           type: 'get',
           url: 'imgpositions.php',
           async: true,
           data: { magazinid : magazinid},
           success: function (data){
               if(data){
                   console.log(data);
                   for(let position of data){
                       $('input[value="'+position+'"]').attr('disabled', 'disabled');
                   }
               }
           }

       });         
    }
    $('#galerie').bind('change', update);
    update();
})();
