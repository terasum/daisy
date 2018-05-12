module.exports = function($){
  var comment_box  = $('.comment_container');
  console.log(comment_box);
  var reply_btn    = $('.go_reply');
  reply_btn.click(function(){
      console.log("clicked.")
      comment_box.slideToggle();
  })
};
