
(function(app) {
  app.sampleComponent =
	ng.core.Component({
		selector: 'title-tag',
		template: '<span>Chat Messages</span>'
	})
	.Class({
		constructor: function(){}
	});


  app.AppComponent =
    ng.core.Component({
      selector: 'chat-sub-window',
      template: '<h1><title-tag></title-tag></h1>',
      directives:[this.sampleComponent]
    })
    .Class({
      constructor: function() {}
    });
})(window.app || (window.app = {}));