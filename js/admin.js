function switchNav() {
	if($('#mainmenu').is('.collapse:not(.show)')) {
    	document.getElementById('container').style.marginLeft = '260px';
	} else {
		document.getElementById('container').style.marginLeft = '10px';
	}
}

function showAdmins() {
	hideAll();
	document.getElementById('admin').style.display = 'block';
}

function showRegs() {
	hideAll();
	document.getElementById('r_reqs').style.display = 'block';
}

function showSups() {
	hideAll();
	document.getElementById('s_reqs').style.display = 'block';
}

function showInstitutions() {
	hideAll();
	document.getElementById('institution').style.display = 'block';
}

function showQuotes() {
	hideAll();
	document.getElementById('quotes').style.display = 'block';
}

function hideAll() {
	document.getElementById('admin').style.display = 'none';
	document.getElementById('r_reqs').style.display = 'none';
	document.getElementById('s_reqs').style.display = 'none';
	document.getElementById('institution').style.display = 'none';
	document.getElementById('quotes').style.display = 'none';
}