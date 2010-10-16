function automation() {
  window.opener.location.href = window.opener.location.href;
  //window.open('write_update.php','update','width=1,height=1,toolbar=no,location=no')
  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
  window.close();
}

function hideshow(which){
if (!document.getElementById)
return
if (which.style.display=="block")
which.style.display="none"
else
which.style.display="block"
}


/*
function Maximize()
{
window.innerWidth = (screen.width - 8); // - 20
window.innerHeight = (screen.height - 90);  //- 210 this makes up for a double toolbar
window.screenX = 0;
window.screenY = 0;
//alwaysLowered = false;
}
*/
function Maximize()
{
//window.outerWidth = 1275; // - 20
//window.outerHeight = 980;  //- 210 this makes up for a double toolbar
//window.screenX = 0;
//window.screenY = 0;
//alwaysLowered = false;
//alert(screen.width+'x'+screen.height);
}
function setSize(width,height) {
	if (window.outerWidth) {
		window.outerWidth = width;
		window.outerHeight = height;
	}
	else if (window.resizeTo) {
		window.resizeTo(width,height);
	}
	else {
		alert("Not supported.");
	}
}



