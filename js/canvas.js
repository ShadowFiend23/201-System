$(document).ready(() => {
    let contentWidth;
    if ($("#leaveForm").length){
        let inner = window.innerWidth;
        if(inner <= 768){

            contentWidth = inner;

        }else{
            
            contentWidth = $("#leaveForm").innerWidth() - 48;

        }
    }else
        contentWidth = $("#signatoryForm").innerWidth() - 48;
    
   let contentHeight = $("#accordionSidebar").innerHeight() - $("#topbar").innerHeight() - 80;// window.innerHeight - 
   $("#canvasContainer").css({ "width" : contentWidth + "px", "height" : contentHeight + "px"});
   $("#parentCanvas").css("width",  contentWidth + "px");
   $("#parentCanvas").css("height",  contentHeight + "px");
   $("#canvasDiv").css("width", (contentWidth - (contentWidth * 0.2) + "px"));
   $("#canvasDiv").css("height", (contentHeight - (contentHeight * 0.2) + "px"));
   $("#buttonHolder").css("width", (contentWidth - (contentWidth * 0.2) + "px"));
    var canvasDiv = document.getElementById('canvasDiv');
    var canvas = document.createElement('canvas');
    var stroked = 0;
    canvas.setAttribute('id', 'canvas');
    canvasDiv.appendChild(canvas);
    $("#canvas").attr('height', $("#canvasDiv").outerHeight());
    $("#canvas").attr('width', $("#canvasDiv").outerWidth());
    if (typeof G_vmlCanvasManager != 'undefined') {
        canvas = G_vmlCanvasManager.initElement(canvas);
    }
    
    var blankCanvas = document.getElementById('canvas');
    context = canvas.getContext("2d");
    $('#canvas').mousedown(function(e) {
        var offset = $(this).offset()
        var mouseX = e.pageX - this.offsetLeft;
        var mouseY = e.pageY - this.offsetTop;

        paint = true;
        addClick(e.pageX - offset.left, e.pageY - offset.top);
        redraw();
    });

    $('#canvas').mousemove(function(e) {
        if (paint) {
            var offset = $(this).offset()
            //addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
            addClick(e.pageX - offset.left, e.pageY - offset.top, true);
            console.log(e.pageX, offset.left, e.pageY, offset.top);
            redraw();
            stroked++;
        }
    });

    $('#canvas').mouseup(function(e) {
        paint = false;
    });

    $('#canvas').mouseleave(function(e) {
        paint = false;
    });

    var clickX = new Array();
    var clickY = new Array();
    var clickDrag = new Array();
    var paint;

    function addClick(x, y, dragging) {
        clickX.push(x);
        clickY.push(y);
        clickDrag.push(dragging);
    }

    $("#resetSignature").click(function() {
        context.clearRect(0, 0, window.innerWidth, window.innerWidth);
        clickX = [];
        clickY = [];
        clickDrag = [];
        stroked=0;
    });

    $(document).on('click', '#saveSignature', function() {
        var mycanvas = document.getElementById('canvas');
        var img = mycanvas.toDataURL("image/png");
        if(stroked === 0){
            Swal.fire('Invalid', "Please write your signature!", 'warning');
        }else{
            anchor = $("#signaturePic");
            anchor.val(img);
            $("#canvasContainer").hide();
        }
        
    });
    $(document).on('click', '#saveSignatory', function() {
        var mycanvas = document.getElementById('canvas');
        var img = mycanvas.toDataURL("image/png");
        if(stroked === 0){
            Swal.fire('Invalid', "Please write your signature!", 'warning');
        }else{
            Swal.fire({
                title: 'Save the Signature?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Save it!'
            }).then((result) => {
                if (result.value) {
                    anchor = $("#signatoryPic");
                    anchor.val(img);
                    $("#signatoryForm").trigger("submit");
                }else{
                }
              })
            
        }
        
    });

    var drawing = false;
    var mousePos = {
        x: 0,
        y: 0
    };
    var lastPos = mousePos;

    canvas.addEventListener("touchstart", function(e) {
        mousePos = getTouchPos(canvas, e);
        var touch = e.touches[0];
        var mouseEvent = new MouseEvent("mousedown", {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }, false);


    canvas.addEventListener("touchend", function(e) {
        var mouseEvent = new MouseEvent("mouseup", {});
        canvas.dispatchEvent(mouseEvent);
    }, false);


    canvas.addEventListener("touchmove", function(e) {

        var touch = e.touches[0];
        var offset = $('#canvas').offset();
        var mouseEvent = new MouseEvent("mousemove", {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }, false);



    // Get the position of a touch relative to the canvas
    function getTouchPos(canvasDiv, touchEvent) {
        var rect = canvasDiv.getBoundingClientRect();
        return {
            x: touchEvent.touches[0].clientX - rect.left,
            y: touchEvent.touches[0].clientY - rect.top
        };
    }


    var elem = document.getElementById("canvas");

    var defaultPrevent = function(e) {
        e.preventDefault();
    }
    elem.addEventListener("touchstart", defaultPrevent);
    elem.addEventListener("touchmove", defaultPrevent);


    function redraw() {
        //
        lastPos = mousePos;
        for (var i = 0; i < clickX.length; i++) {
            context.beginPath();
            if (clickDrag[i] && i) {
                context.moveTo(clickX[i - 1], clickY[i - 1]);
            } else {
                context.moveTo(clickX[i] - 1, clickY[i]);
            }
            context.lineTo(clickX[i], clickY[i]);
            context.closePath();
            context.stroke();
        }
    }
})