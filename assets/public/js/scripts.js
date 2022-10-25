// Stops YouTube video from playing whenever modal is closed
(function($) {

    //Stops video on modal close
    $(".modal").on('hidden.bs.modal', function (e) {
        $(".modal iframe").attr("src", $(".modal iframe").attr("src"));
    });

    //Closes modal when button is clicked
    $('.modal').on('click', 'button.close', function (eventObject) {
        $('.modal').modal('hide');
    });
})( jQuery );

