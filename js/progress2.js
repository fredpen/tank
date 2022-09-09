/*var duration2=3 // Specify duration of progress bar in seconds
var _progressWidth2 = 100;	// Display width of progress bar.

var _progressBar2 = "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||"
var _progressEnd2 = 5;
var _progressAt2 = 0;


// Create and display the progress dialog.
// end: The number of steps to completion
function ProgressCreate2(end2) {
	// Initialize state variables
	_progressEnd2 = end2;
	_progressAt2 = 0;

	// Move layer to center of window to show
	if (document.all) {	// Internet Explorer
		progress2.className = 'show';
		progress2.style.left = (document.body.clientWidth/2) - (progress.offsetWidth/2);
		progress2.style.top = document.body.scrollTop+(document.body.clientHeight/2) - (progress.offsetHeight/2);
	} else if (document.layers) {	// Netscape
		document.progress2.visibility = true;
		document.progress2.left = (window.innerWidth/2) - 100+"px";
		document.progress2.top = pageYOffset+(window.innerHeight/2) - 40+"px";
	} else if (document.getElementById) {	// Netscape 6+
		document.getElementById("progress2").className = 'show';
		document.getElementById("progress2").style.left = (window.innerWidth/2)- 100+"px";
		document.getElementById("progress2").style.top = pageYOffset+(window.innerHeight/2) - 40+"px";
	}

	ProgressUpdate2();	// Initialize bar
}

// Hide the progress layer
function ProgressDestroy2() {
	// Move off screen to hide
	if (document.all) {	// Internet Explorer
		progress2.className = 'hide';
	} else if (document.layers) {	// Netscape
		document.progress2.visibility = false;
	} else if (document.getElementById) {	// Netscape 6+
		document.getElementById("progress2").className = 'hide';
	}
}

// Increment the progress dialog one step
function ProgressStepIt2() {
	_progressAt2++;
	if(_progressAt2 > _progressEnd2) _progressAt2 = _progressAt2 % _progressEnd2;
	ProgressUpdate2();
}

// Update the progress dialog with the current state
function ProgressUpdate2() {
	var n2 = (_progressWidth2 / _progressEnd2) * _progressAt2;
	if (document.all) {	// Internet Explorer
		var bar2 = dialog2.bar2;
 	} else if (document.layers) {	// Netscape
		var bar2 = document.layers["progress2"].document.forms["dialog2"].bar2;
		n2 = n2 * 0.55;	// characters are larger
	} else if (document.getElementById){
                var bar2=document.getElementById("bar2")
        }
	var temp2 = _progressBar2.substring(0, n2);
	bar2.value = temp2;
}

// Demonstrate a use of the progress dialog.
function Demo2() {
	ProgressCreate2(10);
	window.setTimeout("Click2()", 100);
}

function Click2() {
	if(_progressAt2 >= _progressEnd2) {
		ProgressDestroy2();
		return;
	}
	ProgressStepIt2();
	window.setTimeout("Click2()", (duration2-1)*1000/10);
}

function CallJS2(jsStr2) { //v2.0
  return eval(jsStr2)
}



  // Create layer for progress dialog
    document.write("<span id=\"progress2\" class=\"hide\">");
	document.write("<FORM name=dialog2 id=dialog2>");
	document.write("<TABLE border=2  bgcolor=\"#FFFFCC\">");
	document.write("<TR><TD ALIGN=\"center\">");
	document.write("...Please Wait...<BR>");
	document.write("<input type=text name=\"bar2\" id=\"bar2\" size=\"" + _progressWidth2/2 + "\"");
	if(document.all||document.getElementById) 	// Microsoft, NS6
		document.write(" bar.style=\"color:navy;\">");
	else	// Netscape
		document.write(">");
	document.write("</TD></TR>");
	document.write("</TABLE>");
	document.write("</FORM>");
    document.write("</span>");
    ProgressDestroy2();	// Hides*/