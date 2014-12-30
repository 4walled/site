function checkScroll(initial) {
	if(($(window).scrollTop() == $(document).height()-$(window).height() || $(window).height() >= $(document).height()) && !loading) {
		loading = true;
		$("#loading").css("display", "block")
		$.get("get.php?rez=1024x768", function(data){
			$("#imageList").append(data)
			$("#loading").css("display", "none")
			$.scrollTo("-=1");
			if(initial === true) {
				$.scrollTo(0);
			}
			loading = false;
		});
	}
}
var loading = false;
$(document).ready(function () {
	checkScroll(true)
});
$(window).scroll(function() {
	checkScroll()
});