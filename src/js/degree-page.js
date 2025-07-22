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

    // Open the modal if the URL hash is "#requestInfoModal"
    if (window.location.hash === '#requestInfoModal') {
      $requestInfoModal.modal('show');
    }

    // Clear the hash when the modal is closed
    $requestInfoModal.on('hidden.bs.modal', () => {
      if (window.location.hash === '#requestInfoModal') {
        history.replaceState(null, null, window.location.pathname + window.location.search);
      }
    });
  }

  $(degreePageInit);

}(jQuery));

