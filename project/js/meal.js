update();

function submitMenu(menuId) {
  $("#modal" + menuId).modal("toggle");
  addMenu(menuId);
}

$(".buttonclear").click(function() {
  clear();
  update();
});
