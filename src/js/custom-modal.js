// Custom Modal toggle script for when we need to use something homegrown
// instead of the built in bootstrap modal
const customModalOnClick = (e) => {
  e.preventDefault();

  const $toggle = $(e.target);
  const $target = $($toggle.data('target'));

  if (!$target) {
    return;
  }

  if ($target.hasClass('show')) {
    $target.removeClass('show');
  } else {
    $target.addClass('show');
  }
};

if (typeof jQuery !== 'undefined') {
  jQuery(document).ready(($) => {
    $('[data-toggle="custom-modal"]').click(customModalOnClick);
  });
}
