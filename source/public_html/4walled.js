
function initHover() {
    $('#imageList a').live("mouseover", showHover);
    $('#hover').live("mouseout", function () {
        $(this).hide()
    });
}

function showHover(e) {
    if (e.type == 'mouseover') {
        coords = new Object();
        //$(this).clone().appendTo('#hover');
        //$('#hover img').attr("src", $(this).attr("src"));
        $('#hover a').replaceWith($(this).clone());
        $('#hover').css('display', 'block');
        $('#hover').css('position', 'absolute');
        coords.width = $(this).children("img").width() * 2
        coords.height = $(this).children("img").height() * 2
        coords.top = $(this).children("img").offset().top - coords.height/4;
        coords.left = $(this).children("img").offset().left - coords.width/4;
        if (coords.left < 0) {
            coords.left = 0;
        }
        $('#hover').css('top', coords.top);
        $('#hover').css('left', coords.left);
        $('#hover img').css('width', coords.width);
        $('#hover img').css('height', coords.height);
        //$('#hover').show();
    } else {
        //$('#hover').hide();
    }
}

function checkScroll(initial) {
    // The extra -10 is to leave a buffer for browser inaccuracies, had some issues with firefox
    // being off by 1 pixel.
    if(($(window).scrollTop() > $(document).height()-$(window).height()-15 || $(window).height() >= $(document).height()) && !loading) {
        loading = true;
        $("#loading").css("display", "block");
        qmark = false;
        params = [];
        url = window.location.protocol + "//" + window.location.host + "/images/";

        if (!(typeof offset === 'undefined')) {
            offset = parseInt(offset);
        } else {
            offset = 0;
        }        
        params.push("offset=" + (offset + checkScroll.count));
        if (typeof width === 'string' && width != "" &&
            typeof aspect === 'string' && aspect != "") {
            params.push("width_aspect=" + width + "x" + aspect);
        }
        
        if (typeof board === 'string' && board != "") { params.push("board=" + board); }
        if (typeof sfw === 'string' && sfw != "") { params.push("sfw=" + sfw); }
        if (typeof tags === 'string' && tags != "") { params.push("tags=" + tags); }
        if (typeof style === 'string' && style != "") { params.push("style=" + style); }
        if (typeof random === 'string' && random != "") { params.push("random=" + random); }
        
        if (params.length > 0) {
            url += "?" + params.join("&");            
        }
        $.get(url, function(data){
            if (!typeof console === 'undefined') {
                console.log(url);
            }
            list = jQuery.parseJSON(data);
            if (list.length > 0) {
                //list.forEach(add_image);
                for (var index in list) {
                    add_image(list[index]);
                }
                loading = false;
            } else {
                $("#imageList").append("<li>This is the end of the internet</li>");
                loading = true;
            }
            $("#loading").css("display", "none")
            checkScroll.count = checkScroll.count + 30;
        });
    }
}


function add_image(imagedata) {
    if ($('#imageList').data("images") == null) {
        $('#imageList').data("images", new Array())
        //alert($('#imageList').data("images"));
    }
    //alert("HERE");
    url = window.location.protocol + "//" + window.location.host + "/image/" + imagedata["id"]
    var img = "<li class='image'><a href='" + url + "' target='_blank'> <img alt='Missing!' ";
    img += "src='http://4walled.cc/thumb/" + imagedata["md5"].substr(0, 2) + "/" + imagedata["md5"] + ".jpg'";
    img += "title='Aspect Ratio: 1.6    Resolution: 1280x800' id='" + imagedata["id"] + "'/></a></li>";
    
    if (typeof imagedata["md5"] === "undefined") {
        $('#imageList').prepend(imagedata);
    } else {
        if ($('#imageList').data("images").length > 0) {
            found = false;
            for (var index in $('#imageList').data("images")) {
                image = $('#imageList').data("images")[index]
                if (!typeof console === 'undefined') {
                    console.log(imagedata["id"] + " " + image["id"]);
                }
                if (image["id"] == imagedata["id"]) {
                    found = true;
                    if (!typeof console === 'undefined') {
                        console.log("Image was already shown");
                    }
                }
            };
            if (found == false) {
                //console.log("Adding new image " + imagedata["id"] + " " + image["id"]);
                $('#imageList').append(img);
                $('#imageList').data("images").push(imagedata);
            }
        } else {
            $('#imageList').append(img);
            $('#imageList').data("images").push(imagedata);
        }
    }
    
}

