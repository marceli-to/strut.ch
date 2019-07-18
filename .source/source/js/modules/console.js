var ConsoleUi = (function() {

	var config = {
		message:  "Made with ♥️ by marceli.to",
		txtColor: "#222",
		bgColor: "transparent",
	};	
	
	var _showMessage = function() {
		console.log("%c%s", "background-color: "+ config.bgColor+"; color: " + config.txtColor + "; font-size: 11px; padding: 3px 10px; width: 100%;", ""+ config.message +"");
	};

	return {
		show: _showMessage,
	};
})();

// Initialize
ConsoleUi.show();

