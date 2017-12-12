$(function() {
    var $countyModal = $('#county-modal');
    $countyModal.find('br').remove();
    $('#county-selector').change(function() {
        $countyModal.find('.modal-body').html($($(this).val()).html());
        $countyModal.modal();
    });
});