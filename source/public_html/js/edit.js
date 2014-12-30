function reportAjax(mode, imageID) {
	$("#ajaxResponse").html("<img src=\"images/loading.gif\" alt=\"Loading...\" />");
	
	if(mode == "report") {
		$.get("report.php", {"mode": mode, "id": imageID}, function(data) {
			$("#ajaxResponse").html(data);
		});
	} else if(mode == "updaterating") {
		var sfw = $("#sfwSelect").attr("value");
		$.get("report.php", {"mode": mode, "id": imageID, "sfw": sfw}, function(data) {
			$("#ajaxResponse").html(data);
		});
	} else if(mode == "updatetags") {
		var tags = $("#tagsText").attr("value");
		$.get("report.php", {"mode": mode, "id": imageID, "tags": tags}, function(data) {
			$("#ajaxResponse").html(data);
		});
	}
	return false;
}