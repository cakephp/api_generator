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

/**
 * Javascript used on Api doc Pages
 *
 */
ApiGenerator.apiPages = {
	init : function() {
		var visibilityControls = null;
		if (visibilityControls = $('api-doc-controls')) {
			var targets = {
				'hide-parent-methods' : '.parent-method',
				'hide-parent-properties' : '.parent-property'
			}
			this.attachVisibilityControls(targets);
		}
		var mySmoothScroll = new SmoothScroll({
		    links: '.scroll-link',
		    wheelStops: false
		});
	},
	attachVisibilityControls : function(collection) {
		for (button in collection) {
			$(button).addEvent('click', function(e) {
				e.stop();
				var targets = $$(collection[this.get('id')]);
				var showing = this.retrieve('showing', true)
				if (showing) {
					targets.fade('out');
					this.addClass('active');
					var setStyle = targets.setStyle;
					setStyle.delay(400, targets, ['display', 'none']);
				} else {
					targets.fade('in').setStyle('display', null);
					this.removeClass('active');
				}
				this.store('showing', !showing);
			});
		}
	}
}