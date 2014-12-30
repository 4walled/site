var pageUrl = "http://4walled.cc/results.php?tags=&board=&width_aspect=&searchstyle=larger&sfw=0&search=search&offset=";
var imgSrc = [];
var imgLink = [];
var position = 0;
function loadImages(offset) {
	$.get(pageUrl + offset, function (data) {
		for(i = 0; i < $(data).find("img").length; i++) {
			imgSrc[imgSrc.length] = $(data).find("img")[i].src;
			imgLink[imgLink.length] = $(data).find("a")[i];
		}
	});
}

function preloadImage(imageArray) {
	$(imageArray).each(function () {
		(new Image()).src = this;
	});
}

function displayImage() {
	$('div#thumbnail').html('<a href="' + imgLink[position] + '" target="_blank"><img src="' + imgSrc[position] + '" /></a>');
	jQuery.fn.center = function () {
		this.css("position","absolute");
		this.css("top", ($(window).height() - this.height()) / 2+$(window).scrollTop() + "px");
		//this.css("top", "25px");
		this.css("left", ($(window).width() - this.width()) / 2+$(window).scrollLeft() + "px");

		return this;
	}
	jQuery.fn.resize = function () {
		this.css("width", $(window).width() - (($(window).width() / 100) * 20) + "px");
		this.css("height", $(window).height() - (($(window).height() / 100) * 20) + "px");
	}
	$('img').resize();
	$('.centerPage').center();
}

function moveLeft() {
	if(position <= 1) {
		position = 1;
	} else {
		position--;
	}
	displayImage();
}

function moveRight() {
	position++;
	if(position == (imgSrc.length - 2)) {
		loadImages(imgSrc.length);
		setTimeout(function() {
			preloadImage([imgSrc[position + 1]]);
		}, 500);
	}
	displayImage();
}

$(document).ready(function() {
	$(window).resize(function() {
		$('.centerPage').css({
			position:'absolute',
			top: ($(window).height() - $('.centerPage').outerHeight())/2,
			left: ($(window).width() - $('.centerPage').outerWidth())/2
		});
	});
	
	loadImages(0);
	setTimeout(function() {displayImage();}, 500);
});

$(document).keydown(function(e){
	if(e.keyCode == 37) { 
		moveLeft();
		return false;
	}
	if(e.keyCode == 39) { 
		moveRight();
		return false;
	}
});