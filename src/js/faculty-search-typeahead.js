(function ($) {

  $.fn.MainSiteFacultySearch = function (options) {

    const typeaheadSettings = $.extend({
      highlight: true,
      minLength: 2
    }, options);

    const facultyLimit = 5;
    const collegeLimit = 3;
    const departmentLimit = 5;


    const typeaheadFacultySource = new Bloodhound({
      datumTokenizer: function (datum) {
        return Bloodhound.tokenizers.whitespace(datum.title.rendered);
      },
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
        url: `${FACULTY_SEARCH_SETTINGS.faculty.dataEndpoint}&search=%QUERY`,
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
      remote: {
        url: `${FACULTY_SEARCH_SETTINGS.departments.dataEndpoint}&search=%QUERY`,
        wildcard: '%QUERY'
      },
      identify: function (data) {
        return `department_${data.id}`;
      }
    });


    this.typeahead(
      typeaheadSettings,
      {
        name: 'results-colleges',
        source: typeaheadCollegesSource.ttAdapter(),
        limit: collegeLimit,
        displayKey: function (obj) {
          return $('<span>').html(obj.name).text();
        },
        templates: {
          header: '<strong class="d-block font-size-sm text-default text-uppercase letter-spacing-2 px-3 px-sm-4 pt-2 mb-1">Faculty by College:</strong>'
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
          header: '<strong class="d-block font-size-sm text-default text-uppercase letter-spacing-2 px-3 px-sm-4 pt-2 mb-1">Faculty by Department:</strong>'
        }
      },
      {
        name: 'results-faculty',
        source: typeaheadFacultySource.ttAdapter(),
        limit: facultyLimit,
        displayKey: function (obj) {
          return $('<span>').html(obj.title.rendered).text();
        },
        templates: {
          suggestion: Handlebars.compile(`
            <div class="d-flex flex-row mb-0">
              <div class="media-background-container rounded-circle mr-2 suggestion-image">
                <img src="{{thumbnails.thumbnail.src}}" class="media-background object-fit-cover" style="object-position: 50% 0%;" data-object-position="50% 0%" alt="" width="{{thumbnails.thumbnail.width}}" height="{{thumbnails.thumbnail.height}}">
              </div>
              <div class="align-self-center suggestion-text">
                <span class="d-block">{{title.rendered}}</span>
                {{#if person_titles}}
                <ul class="list-inline d-block mb-0 line-height-2">
                  {{#each person_titles}}
                  <li class="list-inline-item text-default small suggestion-title">{{this}}</li>
                  {{/each}}
                </ul>
                {{/if}}
              </div>
            </div>
          `)
        }
      }
    ).on('typeahead:selected', (event, obj) => {
      const objType = 'taxonomy' in obj ? obj.taxonomy : 'faculty';
      if (objType in FACULTY_SEARCH_SETTINGS) {
        return FACULTY_SEARCH_SETTINGS[objType].selectedAction(event, obj);
      }
      return false;
    });

    return this;

  };

}(jQuery));
