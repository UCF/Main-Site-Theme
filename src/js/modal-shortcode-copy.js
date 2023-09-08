(function ($) {
  const slugify = (title) => {
    title = title.replace(/^\s+|\s+$/g, '');
    title = title.toLowerCase();

    // Remove shortcodes
    title = title.replace(/\[.*\]/g, '');

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

  const init = () => {
    $('.acf-repeater[data-orig_name="page_modals"] .acf-row').each((idx, row) => {
      addCopyLogic($(row));
    });
  };

  const addCopyLogic = ($row) => {
    const $btn = $row.find('.copy-modal-toggle').first();

    $btn.on('click', () => {
      const $message = $row.find('.copy-modal-message');
      const idx = $row.index();
      const title = $row
        .find('.acf-field[data-name="modal_heading"] input')
        .val();

      const modalId = $row
        .find('.acf-field[data-name="modal_id"] input')
        .val();

      let slug = modalId;

      if (!slug) {
        slug = slugify(title);
        slug += idx !== 0 ? `-${idx}` : '';
      }

      console.log(slug);

      const textToCopy = `[modal-toggle id="${slug}-toggle" class="btn btn-primary" target="#${slug}"]${title}[/modal-toggle]`;
      navigator.clipboard.writeText(textToCopy);

      $message.removeClass('hidden');

      setTimeout(() => {
        $message.addClass('hidden');
      }, 5000);
    });
  };

  $(document).ready(() => {
    init();
  });

  acf.addAction('append', ($el) => {
    addCopyLogic($el);
  });
}(jQuery));
