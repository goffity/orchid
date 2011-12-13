function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function insertOrchidLink() {
	var tagtext;
	var orchidtag = document.getElementById('orchidtag').value;
		if (orchidtag != 0 )
			tagtext = "[orchid type:" + orchidtag +  "]";
		else
			tinyMCEPopup.close();
	
	
	if(window.tinyMCE) {
		//TODO: For QTranslate we should use here 'qtrans_textarea_content' instead 'content'
		if(orchidtag=="Report"){
			//Alert("xxx");
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, "Please:Input Year:Mount behide Report<br>");
		}
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
		//Peforms a clean up of the current editor HTML. 
		//tinyMCEPopup.editor.execCommand('mceCleanup');
		//Repaints the editor. Sometimes the browser has graphic glitches. 
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}
