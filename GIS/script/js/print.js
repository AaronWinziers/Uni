/*http://stackoverflow.com/questions/33732739/print-a-div-content-using-jquery*/

head = `
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../img/favicon.ico">

  	<title>Python (Teil 1) - GIS-Anwendungsentwicklung</title>
    <link href="../../css/bootstrap-custom.min.css" rel="stylesheet">
    <link href="../../css/font-awesome-4.5.0.css" rel="stylesheet">
    <link href="../../css/base.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/highlight.css">
    <link href="../../css/docstyle.css" rel="stylesheet">
    <link href="../../css/myskulpt.css" rel="stylesheet">
    <link href="../../css/admonition.css" rel="stylesheet">
    <style>
    .skulpt { display:none;}
    </style>
</head>
`;


function hideElementsByClass(win, argv) {
    console.log("start hiding");
    for (i = 0; i < argv.length; ++i) {
        hide = win.document.getElementsByClassName(argv[i]);
        console.log("hiding " + argv[i] + " " + hide.length);
        for (j=0; j<hide.length; j++) {
            hide[j].style.display = 'none';
            console.log("hiding " + hide[j]);
        }
    }
}


function printDiv(printID, hide_classes=[]) 
{
  var divToPrint=document.getElementsByClassName(printID)[0];
  var newWin=window.open('','Print-Window');
  newWin.document.open();
  newWin.document.write('<html>' + head + '<body">'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  // hideElementsByClass(newWin, hide_classes);
  // setTimeout(function(){newWin.close();},10);
}

function openIFrame(hide_classes=[]) 
{
  iframe = window.document.getElementsByTagName("IFRAME")[0];
  var newWin=window.open('','Print-Window');
  newWin.document.open();
  newWin.document.write('<html>' + head + '<body">'+iframe.contentDocument.body.innerHTML+'</body></html>');
  newWin.document.close();
}