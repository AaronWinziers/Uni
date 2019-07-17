var win = null;
var elem = null;
var skulpt_page = "/skulpt/skulpt_editor.html";

function wreset() {	
	win.document.getElementById("yourcode").value = elem.innerText;
	win.document.getElementById("output").innerText = "_";
	console.log("wreset - done");
}

function wopen() {
	window.skulptCode = elem.innerText;
	win = window.open(skulpt_page, "Skulpt");
	/*//win.skulptCode = elem.innerText;
	win.onload = function (e) {
		
		wreset();
		console.log("onload now");
		win.editor.setValue(elem.innerText);
		console.log("onload event - done");
            
	} */
	
	console.log("wopen - done");
}

function run_skulpt(event) {
    elem = event.target.parentNode.previousElementSibling
	
    if (win == null || win.closed) {
        wopen();
    } else {
        win.close();
		wopen();
		// win.editor.setValue(elem.innerText);
    }
	console.log("run_skulpt - done");
}

// some more or less skulpt related functions
function savePython(event, filename) {
    elem = event.target.parentNode.previousElementSibling;
    
	// text = document.getElementById("yourcode").value;
	text = elem.innerText;
    
    dataURL = 'data:text/plain,' + encodeURIComponent(text);
	downloadDataUrlFromJavascript(filename, dataURL);
	console.log("savePython: %s - done"%filename);
}

function downloadDataUrlFromJavascript(filename, dataUrl) {

    // Construct the a element
    var link = document.createElement("a");
    link.download = filename;
    //link.target = "_blank";

    // Construct the uri
    link.href = dataUrl;
    document.body.appendChild(link);
    link.click();

    // Cleanup the DOM
    document.body.removeChild(link);
    delete link;
}