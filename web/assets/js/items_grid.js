if ($('#productPage').length) {
    var lgView;
    //assumes user has preference cookie that writes class from server based on previous session
    if ($('#productPage').hasClass('list-view')) {
        lgView = "list-view";
    } else {
        lgView = "grid-view";
    };
    $('input[name="swap"]').on('click', function() {
        $('#productPage').removeClass(lgView);
        lgView = $(this).val();
        //value would be saved to cookie on a real website
        $('#productPage').addClass(lgView);
    });
}