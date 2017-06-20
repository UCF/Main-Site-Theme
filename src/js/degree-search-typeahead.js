const degreeSearchInit = ($) => {
  let degree;

  if ($('.degree-search-typeahead')) {
    const keywords = {
      bachelor: ['bachelor\'s', 'bachelors', 'bs', 'ba', 'major', 'majors'],
      minor: ['minor', 'minors'],
      master: ['masters', 'ms', 'ma', 'mfa'],
      doctorate: ['phd', 'md', 'dpt']
    };

    let currentQuery = [''];

    const keywordReplace = (q) => {
      for (const x in q) {
        const term = q[x].toLowerCase().replace(/\.\ \'/, '');
        for (const y in keywords) {
          if (keywords[y].indexOf(term) > -1) {
            q[x] = y;
          }
        }
      }
      return q;
    };

    const customPrepare = (query, settings) => {
      const token = Bloodhound.tokenizers.whitespace(query);
      query = keywordReplace(token).join(' ');
      settings.url = settings.url.replace(/%q/, query);
      return settings;
    };

    const customQueryTokenizer = (q) => {
      let token = Bloodhound.tokenizers.whitespace(q);
      token = keywordReplace(token);
      currentQuery = token;
      return token;
    };

    const scoreSorter = (a, b) => {
      if (a.score < b.score) {
        return 1;
      }
      if (a.score > b.score) {
        return -1;
      }
      return 0;
    };

    const addMeta = (data) => {
      const q = currentQuery.join(' ');
      const exactMatch = new RegExp(`\\b${q}\\b`, 'i');
      const partialMatch = new RegExp(q, 'i');

      data.forEach((d) => {
        let score = 0,
          matchString = '',
          titleExactMatch = exactMatch.exec(d.title.rendered) !== null,
          titlePartialMatch = partialMatch.exec(d.title.rendered) !== null;

        score += titleExactMatch ? 50 : 0;
        score += titlePartialMatch ? 10 : 0;

        d.program_types.forEach((pt) => {
          let ptWholeMatch = exactMatch.exec(pt.name) !== null,
            ptPartialMatch = partialMatch.exec(pt.name) !== null;

          score += ptWholeMatch ? 25 : 0;
          score += ptPartialMatch ? 10 : 0;

          if (ptWholeMatch || ptPartialMatch) {
            matchString = `(Program Type: ${pt.name})`;
          }
        }, this);

        d.score = score;
        d.matchString = matchString;
      });

      data.sort(scoreSorter);

      if (data.length === degree.limit) {
        data = data.slice(0, -1);
      }

      return data;
    };

    degree = new UCFDegreeSearch({
      transform: addMeta,
      queryTokenizer: customQueryTokenizer,
      prepare: customPrepare
    });
  }
};

if (typeof jQuery !== 'undefined') {
  jQuery(document).ready(($) => {
    if (UCFDegreeSearch !== 'undefined') {
      degreeSearchInit($);
    }
  });
}
