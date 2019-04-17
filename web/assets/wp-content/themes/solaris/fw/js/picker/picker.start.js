jQuery(document).ready(function () {
(function($) {
/*jshint
 debug: true,
 devel: true,
 browser: true,
 asi: true,
 unused: false
 */



/*
 * Initialize all the others
 */

$( '.js__datepicker' ).pickadate({

    // Work-around for some mobile browsers clipping off the picker.
    onOpen: function() { $('pre').css('overflow', 'hidden') },
    onClose: function() { $('pre').css('overflow', '') },
    firstDay: 1,
    monthsShort: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec' ],
    showMonthsShort: true,
    format: 'dd.mm.yyyy',
    formatSubmit: 'yyyy/mm/dd',
    min: true
});
$( '.js__timepicker' ).pickatime()


})(jQuery);
});