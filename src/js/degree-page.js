(function ($) {

  let requestInfoIntervalId;
  let $requestInfoModal;

  function addClasses() {
    if ($requestInfoModal.find('.default').length) {
      clearInterval(requestInfoIntervalId);
      $requestInfoModal.find('.default').addClass('btn btn-primary');
      $requestInfoModal.find('.form_question, input[type=text], input[type=email]').addClass('w-100');
      $requestInfoModal.find('select').addClass('custom-select');
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
