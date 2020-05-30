document.addEventListener("DOMContentLoaded", function(event){
  // Appends widget div
  var widgetDOM = document.getElementById('widget-point');
  widgetDOM.innerHTML = '<div id="xyz" data-widget data-locale="en" data-mode="verification" data-type="dual"></div>';

  // This variable comes from the Wordpress Admin Settings
  var app_key = rc_options.app_key;
  var widget = new RingCaptcha.Widget('#xyz', {
    app: app_key,
    events: {
      verified: function () {
        console.log("Phone Verified!");
        document.getElementById("ringcaptcha_verified").value = "true";
      }
    }
  }).setup();
});