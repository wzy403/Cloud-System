var buttonList = document.getElementsByName("rename");
for (var index = 0; index < buttonList.length; index++) {
  buttonList[index].onclick = function () {
    let tempName = prompt("enter an new name: ");
    if (tempName != null && tempName != "") {
      var info = document.getElementById(this.id).value;
      var infoList = info.split("|");
      var oldName = infoList[infoList.length - 1].replace(/&/g, "|");

      window.location.href =
        "includes/rename_files.php?send_by_js=true&id=" +
        infoList[0] +
        "&old_name=" +
        oldName +
        "&new_name=" +
        tempName;
    }
  };
}
