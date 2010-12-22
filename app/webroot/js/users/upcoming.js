$(document).ready( function() {
    $('.hidden').hide();
});

function show_details(id) {
    $('.' + id).slideToggle();
}
