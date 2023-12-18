(function(){
    $('.submit-edit-weight').on('submit', function(){
        $('.submit-edit-weight-button').attr('disabled', 'true');
    });

    $('.submit-create-weight').on('submit', function(){
        //alert('Hola');
        $('.submit-create-weight-button').attr('disabled', 'true');
    });
})();