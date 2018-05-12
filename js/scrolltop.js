module.exports = function ($) {
  $(window).on("scroll",() => {
      var t = $(this).scrollTop();
      t > 200 ? $(".back2top").addClass("is-active") : $(".back2top").removeClass("is-active")
  }), $(document).on("click", ".back2top", function () {
      $("html,body").animate({
          scrollTop: 0
      }, 800)
  });

  var t = $("body"),
      a = $("#cancel-comment-reply-link");
  a.text();
  $(document).on("submit", "#commentform", function (a) {
      a.preventDefault();
      var o = $(this);
      return o.hasClass("is-active") ? alert("请勿重复提交") : (o.addClass("is-active"), t.addClass("is-loadingApp"), void $.ajax({
          url: J.ajax_url,
          data: o.serialize() + "&action=ajax_comment",
          type: "POST",
          success: function (a) {
              if (500 == a.status) createButterbar(a.data.code), setTimeout(function () {
                  o.removeClass("is-active")
              }, 3e3);
              else {
                  $("textarea").each(function () {
                      this.value = ""
                  });
                  var s = addComment,
                      n = s.I("cancel-comment-reply-link"),
                      c = s.I("wp-temp-form-div"),
                      i = s.I(s.respondId),
                      l = (s.I("comment_post_ID").value, s.I("comment_parent").value);
                  "0" != l ? $("#respond").before('<ol class="children">' + a + "</ol>") : $("#respond").before('<ol class="comment-list">' + a + "</ol>"), t.removeClass("is-loadingApp"), setTimeout(function () {
                      o.removeClass("is-active")
                  }, 9e3), n.style.display = "none", n.onclick = null, s.I("comment_parent").value = "0", c && i && (c.parentNode.insertBefore(i, c), c.parentNode.removeChild(c))
              }
          }
      }))
  })
}
