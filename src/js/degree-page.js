(function ($) {

  let requestInfoIntervalId;
  let $requestInfoModal;

  function addClasses() {
    if ($requestInfoModal.find('.default').length) {
      const $requestInfoSelect = $requestInfoModal.find('select');

      clearInterval(requestInfoIntervalId);
      $requestInfoModal.find('.default').addClass('btn btn-primary');
      $requestInfoModal.find('.form_question, input[type=text], input[type=email]').addClass('w-100');
      $requestInfoSelect.addClass('custom-select');
    }
  }

  function degreePageInit() {
    $requestInfoModal = $('#requestInfoModal, .slate-modal');

    if ($requestInfoModal) {
      requestInfoIntervalId = setInterval(addClasses, 100);
    }

    // Open the modal if the URL hash is #requestInfoModal or #catalogModal
    if (window.location.hash === '#requestInfoModal') {
      $requestInfoModal.modal('show');
    }
    if (window.location.hash === '#catalogModal') {
      $('#catalogModal').modal('show');
    }
  }

  $(degreePageInit);

}(jQuery));

