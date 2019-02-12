update();

$(".buttonadd").click(function() {
  var x = $(this).attr("id");
  addProduct(x);
});

$(".buttonclear").click(function() {
  clear();
  update();
});
