let mySearchControl;

window.__gcse = {
  callback: function () {
    mySearchControl = google.search.cse.element.getElement('ucf-phonebook');
    document.getElementById('gsc-search-button').addEventListener('click', (e) => {
      e.preventDefault();
      const query = document.getElementById('gsc-input').value;
      if (mySearchControl && query) {
        mySearchControl.execute(query);
      }
    });

    document.getElementById('gsc-input').addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('gsc-search-button').click();
      }
    });
  }
};
