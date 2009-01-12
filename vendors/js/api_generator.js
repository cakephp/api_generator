/**
 * Api Generator JS
 *
 */
window.addEvent('domready', function() {
	ApiGenerator.init();
});

ApiGenerator = {};

ApiGenerator.init = function() {
	for (prop in this) {
		if (this[prop].init != undefined) {
			this[prop].init();
		}
	}
}
/**
 * Enable markdown conversion for .markdown-block
 */
ApiGenerator.docBlocks = {
	init : function() {
		var converter = new Showdown.converter("<?php echo $this->base; ?>");
		$$('.markdown-block').each(function(item) {
			item.set('html', converter.makeHtml(item.get('text').trim()));
		});
	}
}


ApiGenerator.scroller = {
	init : function() {
		var mySmoothScroll = new SmoothScroll({
		    links: '.scroll-link',
		    wheelStops: false
		});
	}
}