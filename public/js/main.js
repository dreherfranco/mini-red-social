var url = 'http://127.0.0.1:8000';
window.addEventListener("load", function () {

    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');
    //boton de like
    function like() {
        $('.btn-like').unbind('click').click(function () {
            console.log('like');
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', url+'/assets/like.png');
            $.ajax({
                url: url + '/like/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    if (response.like) {
                        console.log('Has dado like correctamente');
                    } else
                        console.log('Error al dar like');
                }
            });
            dislike();
        });
    }
    like();
    //boton de dislike
    function dislike() {
        $('.btn-dislike').unbind('click').click(function () {
            console.log('dislike');
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', url+'/assets/dislike.png');
            $.ajax({
                url: url + '/dislike/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    if (response.like) {
                        console.log('Has dado dislike correctamente');
                    } else
                        console.log('Error al dar dislike');
                }
            });
            like();
        });
    }
    dislike();
    
    //BUSCADOR DE USUARIOS
    $('#buscador').submit(function(){
        $(this).attr('action', url+'/usuarios/'+$('#buscador #search').val());
    });
    
});




