// Stops YouTube video from playing whenever modal is closed
(function($) {
    $('.modal').each(function(){
        var src = $(this).find('iframe').attr('src');

        $(this).on('click', function(){
            $(this).find('iframe').attr('src', '');
            $(this).find('iframe').attr('src', src);

        });
    });
})( jQuery );


