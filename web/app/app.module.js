(function(app) {
  app.AppModule =
    ng.core.NgModule({
      imports: [ ng.platformBrowser.BrowserModule, ng.http.HttpModule],
      declarations: [ app.AppComponent,app.sampleComponent ],
      bootstrap: [ app.AppComponent ]
    })
    .Class({
      constructor: function() {
      }
    });
})(window.app || (window.app = {}));