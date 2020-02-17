(function ($) {

  let requestInfoIntervalId;
  let $requestInfoModal;

  function selectDefault($options) {
    // Attempt to update degree names to match.
    const degree = $requestInfoModal.data('degree')
      .replace(/\(|\)| Track/gi, '')
      .replace(/\//gi, ' ');

    $($options).each((i, option) => {
      let optionDegree = $(option).data('text');

      if (optionDegree) {
        optionDegree = optionDegree.replace(' Certificate', '');

        if (degree === optionDegree) {
          $(option).attr('selected', 'selected');
          return false;
        }
      }
      return true;
    });
  }

  function addClasses() {
    if ($requestInfoModal.find('.default').length) {
      const $requestInfoSelect = $requestInfoModal.find('select');
      clearInterval(requestInfoIntervalId);
      $requestInfoModal.find('.default').addClass('btn btn-primary');
      $requestInfoModal.find('.form_question, input[type=text], input[type=email]').addClass('w-100');
      $requestInfoSelect.addClass('custom-select');
      selectDefault($requestInfoModal.find('select > option'));
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
