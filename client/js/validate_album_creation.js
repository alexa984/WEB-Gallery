window.onload = function () {
	document.getElementById("album-creation-form").onsubmit = checkform;
}

function checkform(){
	if(document.getElementsByName('start-date')[0].value==""){
		alert('Choose start date');
		document.getElementsByName('start-date')[0].focus();
		return false;
	}
	if(document.getElementsByName('end-date')[0].value==""){
		alert('Choose start date');
		document.getElementsByName('end-date')[0].focus();
		return false;
	}
	if(document.getElementsByName('end-date')[0] < document.getElementsByName('start-date')[0].value){
    	alert('Choose valid start and end date');
    	document.getElementsByName('start-date')[0].focus();
    	document.getElementsByName('end-date')[0].focus();
    	return false;
    }
    if(document.getElementsByName('album-name')[0].value==""){
    	alert('Enter album name');
    	document.getElementsByName('album-name')[0].focus();
    	return false;
    }
}