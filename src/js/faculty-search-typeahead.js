(function ($) {

  const facultyLimit = 5;
  const collegeLimit = 3;
  const departmentLimit = 5;

  const typeaheadFacultySource = new Bloodhound({
    datumTokenizer: function (datum) {
      return Bloodhound.tokenizers.whitespace(datum.title.rendered);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: `${FACULTY_SEARCH_SETTINGS.faculty.dataEndpoint}?search=%QUERY`, // TODO filter by faculty
      wildcard: '%QUERY'
    },
    identify: function (data) {
      return `degree_${data.id}`;
    }
  });

  const typeaheadCollegesSource = new Bloodhound({
    datumTokenizer: function (datum) {
      return Bloodhound.tokenizers.whitespace(datum.name);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: FACULTY_SEARCH_SETTINGS.colleges.dataEndpoint,
    identify: function (data) {
      return `college_${data.id}`;
    }
  });

  const typeaheadDepartmentsSource = new Bloodhound({
    datumTokenizer: function (datum) {
      return Bloodhound.tokenizers.whitespace(datum.name);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: FACULTY_SEARCH_SETTINGS.departments.dataEndpoint,
    identify: function (data) {
      return `department_${data.id}`;
    }
  });

  $('.faculty-search-typeahead').each(function () {
    const $input = $(this);

    $input.typeahead(
      {
        highlight: true,
        minLength: 2
      },
      {
        name: 'results-faculty',
        source: typeaheadFacultySource.ttAdapter(),
        limit: facultyLimit,
        displayKey: function (obj) {
          return $('<span>').html(obj.title.rendered).text();
        },
        templates: {
          pending: '<span>Loading...</span>', // TODO
          footer: '<span>More results</span>' // TODO
        }
      },
      {
        name: 'results-colleges',
        source: typeaheadCollegesSource.ttAdapter(),
        limit: collegeLimit,
        displayKey: function (obj) {
          return $('<span>').html(obj.name).text();
        },
        templates: {
          header: '<strong class="d-block h6 text-uppercase">Faculty by College:</strong>'
        }
      },
      {
        name: 'results-departments',
        source: typeaheadDepartmentsSource.ttAdapter(),
        limit: departmentLimit,
        displayKey: function (obj) {
          return $('<span>').html(obj.name).text();
        },
        templates: {
          header: '<strong class="d-block h6 text-uppercase">Faculty by Department:</strong>'
        }
      }
    ).on('typeahead:selected', (event, obj) => {
      const objType = 'taxonomy' in obj ? obj.taxonomy : 'faculty';
      if (objType in FACULTY_SEARCH_SETTINGS) {
        return FACULTY_SEARCH_SETTINGS[objType].selectedAction(event, obj);
      }
      return false;
    });
  });

}(jQuery));
