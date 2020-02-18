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
    $requestInfoModal = $('#requestInfoModal');

    if ($requestInfoModal) {
      requestInfoIntervalId = setInterval(addClasses, 100);
    }
  }

  $(degreePageInit);

}(jQuery));
