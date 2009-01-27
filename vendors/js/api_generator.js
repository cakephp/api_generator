/**
 * Api Generator JS
 *
 */
//Add some features to Element
Element.implement({
	//is an element visible
	isVisible : function () {
		return (this.getStyle('display') == 'none') ? false : true;
	},
	//toggle show/hide
	toggle: function() {
		return this[this.isVisible() ? 'hide' : 'show']();
	},
	//hide
	hide : function() {
		var original = this.getStyle('display');
		this.store('toggle:originalDisplay', original);
		this.setStyle('display', 'none');
		return this;
	},
	//show an element
	show : function() {
		var restore = this.retrieve('toggle:originalDisplay', 'block');
		this.setStyle('display', restore);
		return this;
	}
});

/**
 * Simple FileExplorer.
 *
 */
var FileExplorer = new Class({
	Implements : [Options, Events],
	options : {
		folderSelector : 'li.folder',
	},
	elements : {},

	initialize : function (container, options) {
		this.container = $(container);
		if (!this.container) {
			return;
		}
		this.setOptions(options);
		var attachEvent = this.attachEvents.bind(this);
		this.container.set('load', {method : 'get', onComplete: attachEvent });
		this.attachEvents();
	},
	// attach events to all the elements.
	attachEvents : function() {
		var elements = this.container.getElements(this.options.folderSelector + ' a');
		var container = this.container;
		for (var i = 0; i < elements.length; i++) {
			elements[i].addEvent('click', function (event) {
				event.stop();
				container.load(this.get('href'));
			});
		}
	}
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
		var converter = new Showdown.converter(window.basePath);
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
		var FileTree = new FileExplorer('file-browser');
	},

	attachVisibilityControls : function(collection) {
		for (button in collection) {
			$(button).addEvent('click', function(e) {
				e.stop();
				var targets = $$(collection[this.get('id')]);
				var showing = this.retrieve('showing', true);
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
};

window.addEvent('domready', function() {
	ApiGenerator.init();
});