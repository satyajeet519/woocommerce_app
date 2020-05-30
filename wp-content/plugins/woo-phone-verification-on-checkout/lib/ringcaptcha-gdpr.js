document.addEventListener("DOMContentLoaded", function(event){
  // Appends widget div
  var widgetDOM = document.getElementById('widget-point');
  widgetDOM.innerHTML = '<div id="xyz" data-widget data-locale="en" data-type="dual" data-mode="signup"></div>';

  var $ = jQuery.noConflict();
  $('#xyz').each(function() {
    var app_key =  rc_options.app_key;
    var settings = $(this).data();
    settings.app = app_key;
    settings.events = {
      ready: function(event, formValues) {
        console.log("ready: event:", event);
        $('.btn.btn-submit.btn-block.btn-verify.register').html("Request PIN");
        $('h3').text("");
      },

      signup: function(event, formValues) {
        console.log("Phone Verified!");
        $('h3').text("");
        $("div.signup-status").text("Thanks! Your phone has been verified!");

        if (rc_options.js_implementation == true) {
          // This should be done automatically from KA's code
          $('input[name=ringcaptcha_phone_number]').val(formValues.phone);
          document.getElementById("ringcaptcha_verified").value = "true";
        }

        // On succesful phone verification, get GDPR consent value to include on checkout POST data
        // We tie each gdpr_consent per order.
        document.getElementById("gdpr_consent").value = formValues.gdpr;
      }
    };

    settings.form = [
      {
        id: 'phone',
        type: 'phone',
        placeholder: 'Phone',
        validations: {
          length: { min: 5, max: 15, message: 'Doesn\'t look like a valid phone number' }
        }
      },
      {
        id: 'gdpr',
        type: 'checkbox',
        checked: true,
        label: rc_options.gdpr_consent_message,
      }
    ];
    new RingCaptcha.Widget(this, settings.app, settings);
  });
});