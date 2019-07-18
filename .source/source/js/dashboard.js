var Post = (function() {
	
	var selectors = {
		body: 'body',
	};
 
	var _initialize = function() {
		_bind();

		tinymce.init({
			selector: 'textarea',
			height: 200,
			menubar: false,
			plugins: [
			  'autolink lists link',
			  'searchreplace visualblocks code fullscreen',
			  'paste code'
			],
			toolbar: 'undo redo | bold italic | link | removeformat',
			theme: 'silver'
		});
	};

    var _bind = function() {
    };

    return {
        init:  _initialize,
	};
	
})();


// Initialize
$(function() {
	Post.init();
});
