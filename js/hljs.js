const hljs = require('highlight.js');

module.exports = function ($) {
  $(document).ready(function () {
    $('pre code').each(function (i, block) {
      hljs.highlightBlock(block);
    });
  });
};