<?php
/*
Plugin Name: WP Inline Google Recaptcha v3
Plugin URI: https://github.com/tnyk35/wp-inline-google-recaptcha-v3
Description: WordPress用Google reCAPTCHA v3のインライン化プラグイン
Version: 1.0
Author: Yuki Tani
Author URI: https://tnyk.jp/
License: GPL2
*/
function my_inline_grv3($atts) {
  $atts = shortcode_atts(
    array(
      'sitekey' => '',
    ),
    $atts, 'my-inline-grv3');
  $HTML = <<< EOM
<script src="https://www.google.com/recaptcha/api.js?render=explicit&onload=onRecaptchaLoadCallback"></script>
<script>
// google reCAPTCHA onload
var clientId;
function onRecaptchaLoadCallback() {
  clientId = grecaptcha.render('inline-recaptcha', {
    'sitekey': '{$atts["sitekey"]}',
    'badge': 'inline',
    'size': 'invisible'
  });

  grecaptcha.ready(function() {
    gRecaptcha();
  });
}

// google reCAPTCHA exec
function gRecaptcha() {
  grecaptcha.execute(clientId, {action: 'homepage'})
  .then(function(token) {
    // Verify the token on the server.
    var forms = document.getElementsByTagName( 'form' );

    for ( var i = 0; i < forms.length; i++ ) {
      var fields = forms[ i ].getElementsByTagName( 'input' );

      for ( var j = 0; j < fields.length; j++ ) {
        var field = fields[ j ];

        if ( 'g-recaptcha-response' === field.getAttribute( 'name' ) ) {
          field.setAttribute( 'value', token );
          break;
        }
      }
    }
  });
}
</script>
<div class="formRow">
  <div id="inline-recaptcha"></div>
  <input type="hidden" value="" name="g-recaptcha-response">
</div>
EOM;
  return $HTML;
}

add_shortcode('my-inline-grv3', 'my_inline_grv3');
?>