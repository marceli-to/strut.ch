var functions = {};

functions.debounce = function(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this,
            args = arguments;
        var later = function() {
            timeout = null;
            if ( !immediate ) {
                func.apply(context, args);
            }
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait || 200);
        if ( callNow ) { 
            func.apply(context, args);
        }
    };
};

functions.preload = function(items) {
	for (var i = 0; i < items.length; i++) {
		$("<img />").attr("src", items[i]);
	}
};

functions.scrollTo = function(target, duration, callback) {
	var dur = duration || 0, cb = callback || function() {};
	$.scrollTo(target, {duration: dur, onAfter: function(){}});	
};

// functions.sleep = function(time) {
//     return new Promise((resolve) => setTimeout(resolve, time));
// };

functions.getRandomInt = function(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
};