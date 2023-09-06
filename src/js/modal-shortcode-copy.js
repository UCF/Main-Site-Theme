(function ($) {
  const slugify = (title) => {
    title = title.replace(/^\s+|\s+$/g, '');
    title = title.toLowerCase();

    // remove accents, swap ñ for n, etc
    const from = 'àáäâèéëêìíïîòóöôùúüûñçěščřžýúůďťň·/_,:;';
    const to   = 'aaaaeeeeiiiioooouuuuncescrzyuudtn------';

    for (let i = 0; i < from.length; i++) {
      title = title.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    title = title.replace('.', '-')
      .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
      .replace(/\s+/g, '-') // collapse whitespace and replace by a dash
      .replace(/-+/g, '-') // collapse dashes
      .replace(/\//g, ''); // collapse all forward-slashes

    return title;
  };

  $('.copy-modal-toggle').on('click', (e) => {
    const $btn = $(e.target);
    const $parent = $btn.closest('.acf-row');
    const $message = $parent.find('.copy-modal-message');
    const idx = $parent.data('id').substr(4, $parent.data('id').length);
    const title = $parent.find('input')
      .not('.acf-order-input')
      .first()
      .val();

    let slug = slugify(title);
    slug += idx > 0 ? `-${idx}` : '';

    const textToCopy = `[modal-toggle id="${slug}-toggle" class="btn btn-primary" target="#${slug}"]${title}[/modal-toggle]`;
    navigator.clipboard.writeText(textToCopy);

    $message.removeClass('hidden');

    setTimeout(() => {
      $message.addClass('hidden');
    }, 5000);
  });
}(jQuery));
