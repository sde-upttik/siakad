//[Horizontal Menu Javascript]

//Project:	Maximum Admin - Responsive Admin Template
//Version:	1.1.0
//Last change:	11/09/2017
//Primary use:   Maximum Admin - Responsive Admin Template

//should be included in all pages. It controls some layout


+function ($) {
  'use strict'

	jQuery(document).on('click', '.mega-dropdown', function (e) {
	e.stopPropagation();
	});
  
 
	var $window = $(window),
		$html = $('html');

	$window.resize(function resize() {
		if ($window.width() < 990) {
			return $html.removeClass('horizontal-menu');
		}

		$html.addClass('horizontal-menu');
	}).trigger('resize');			
	
}(jQuery)


