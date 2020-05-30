<?php
/**
* Admin Option for plugin
*/


if ( ! defined( 'ABSPATH' ) ) exit;

function rc2c_options_page() {

	global $rc2c_options;
	global $rc2c_plugin_name;

	ob_start(); ?>

<div class="wrap">
  <h2>
    <?php _e($rc2c_plugin_name.' Options', 'rc2c_plugin'); ?>
  </h2>
  <form method="post" action="options.php">
    <?php settings_fields('rc2c_settings_group'); ?>
    <p>
      <?php _e('To get your App Key and  Secret Key Click it <a href="http://ringcaptcha.com/" target="_blank">Here</a>', 'rc2c_plugin'); ?>
    </p>
    <p>
      <input id="rc2c_settings[enable]" name="rc2c_settings[enable]" type="checkbox" value="1" <?php checked(1, $rc2c_options['enable']); ?> />
      <label class="description" for="rc2c_settings[enable]">
        <?php _e('Check to enable RingCaptcha2wooCommerce', 'rc2c_plugin'); ?>
      </label>
    </p>
    <h3>
      <?php _e('RingCaptcha Settings', 'rc2c_plugin'); ?>
    </h3>
    <table class="form-table">
      <tr valign="top">
        <th class="titledesc" scope="row"><label class="description" for="rc2c_settings[app_key]">
            <?php _e('App key', 'rc2c_plugin'); ?>
          </label></th>
        <td class="forminp"><input id="rc2c_settings[app_key]" name="rc2c_settings[app_key]" type="text" value="<?php echo $rc2c_options['app_key']; ?>"/></td>
      </tr>
      <tr valign="top">
        <th class="titledesc" scope="row"><label class="description" for="rc2c_settings[secret_key]">
            <?php _e('Secret key', 'rc2c_plugin'); ?>
          </label></th>
        <td class="forminp"><input id="rc2c_settings[secret_key]" name="rc2c_settings[secret_key]" type="text" value="<?php echo $rc2c_options['secret_key']; ?>"/></td>
      </tr>
      <tr valign="top">
        <th class="titledesc" scope="row"><label class="description" for="rc2c_settings[secret_key]">
            <?php _e('Log error', 'rc2c_plugin'); ?>
          </label></th>
        <td class="forminp"><input id="rc2c_settings[enable_error_log]" name="rc2c_settings[enable_error_log]" type="checkbox" value="1" <?php checked(1, $rc2c_options['nable_error_log']); ?> />
          <label class="description" for="rc2c_settings[enable_error_log]">
            <?php _e('Enable this if you are having issues sending SMS message', 'rc2c_plugin'); ?>
          </label></td>
      </tr>
    </table>
    <hr />
    <h3>
      <?php _e('Admin Notifications', 'rc2c_plugin'); ?>
    </h3>
    <table class="form-table">
      <tr valign="top">
        <th class="titledesc" scope="row"> </th>
        <td class="forminp"><fieldset>
            <input id="rc2c_settings[enable_admin_message]" name="rc2c_settings[enable_admin_message]" type="checkbox" value="1" <?php checked(1, $rc2c_options['enable_admin_message']); ?> />
            <label class="description" for="rc2c_settings[enable_admin_message]">
              <?php _e('Enable admin notifications', 'rc2c_plugin'); ?>
            </label>
          </fieldset></td>
      </tr>
      <tr valign="top">
        <th class="titledesc" scope="row"> <?php _e('Admin mobile number', 'rc2c_plugin'); ?>
        </th>
        <td class="forminp"><input id="rc2c_settings[admin_mobile]" name="rc2c_settings[admin_mobile]" type="text" value="<?php echo $rc2c_options['admin_mobile']; ?>"/></td>
      </tr>
      <tr valign="top">
        <th class="titledesc" scope="row"> <?php _e('Admin Message', 'rc2c_plugin'); ?>
        </th>
        <td class="forminp"><textarea style="width:40%; height: 65px;" name="rc2c_settings[admin_message]"><?php echo $rc2c_options['admin_message']; ?></textarea></td>
      </tr>
    </table>
    <hr />
    <h3>
      <?php _e('Customers Notifications Settings', 'rc2c_plugin'); ?>
    </h3>
    <table class="form-table">
      <tr valign="top">
        <th class="titledesc" scope="row"> <?php _e('Enable this statuses if you want your customers being notified', 'rc2c_plugin'); ?>
        </th>
        <td class="forminp"><fieldset>
            <input id="rc2c_settings[enable_pending]" name="rc2c_settings[enable_pending]" type="checkbox" value="1" <?php checked(1, $rc2c_options['enable_pending']); ?> />
            <label class="description" for="rc2c_settings[enable_pending]">
              <?php _e('Pending', 'rc2c_plugin'); ?>
            </label>
          </fieldset>
          <fieldset>
            <input id="rc2c_settings[enable_on_hold]" name="rc2c_settings[enable_on_hold]" type="checkbox" value="1" <?php checked(1, $rc2c_options['enable_on_hold']); ?> />
            <label class="description" for="rc2c_settings[enable_on_hold]">
              <?php _e('On-Hold', 'rc2c_plugin'); ?>
            </label>
          </fieldset>
          <fieldset>
            <input id="rc2c_settings[enable_processing]" name="rc2c_settings[enable_processing]" type="checkbox" value="1" <?php checked(1, $rc2c_options['enable_processing']); ?> />
            <label class="description" for="rc2c_settings[enable_processing]">
              <?php _e('Processing', 'rc2c_plugin'); ?>
            </label>
          </fieldset>
          <fieldset>
            <input id="rc2c_settings[enable_completed]" name="rc2c_settings[enable_completed]" type="checkbox" value="1" <?php checked(1, $rc2c_options['enable_completed']); ?> />
            <label class="description" for="rc2c_settings[enable_completed]">
              <?php _e('Completed', 'rc2c_plugin'); ?>
            </label>
          </fieldset>
          <fieldset>
            <input id="rc2c_settings[enable_cancelled]" name="rc2c_settings[enable_cancelled]" type="checkbox" value="1" <?php checked(1, $rc2c_options['enable_cancelled']); ?> />
            <label class="description" for="rc2c_settings[enable_cancelled]">
              <?php _e('Cancelled', 'rc2c_plugin'); ?>
            </label>
          </fieldset>
          <fieldset>
            <input id="rc2c_settings[enable_refunded]" name="rc2c_settings[enable_refunded]" type="checkbox" value="1" <?php checked(1, $rc2c_options['enable_refunded']); ?> />
            <label class="description" for="rc2c_settings[enable_refunded]">
              <?php _e('Refunded', 'rc2c_plugin'); ?>
            </label>
          </fieldset>
          <fieldset>
            <input id="rc2c_settings[enable_failed]" name="rc2c_settings[enable_failed]" type="checkbox" value="1" <?php checked(1, $rc2c_options['enable_failed']); ?> />
            <label class="description" for="rc2c_settings[enable_failed]">
              <?php _e('Failed', 'rc2c_plugin'); ?>
            </label>
          </fieldset></td>
      </tr>
            <tr valign="top">
        <th class="titledesc" scope="row"> <?php _e('Message Variables', 'rc2c_plugin'); ?>
        </th>
        <td class="forminp">
        <?php _e('<ul>
            <li><code>%shop_name%</code> &ndash; The name of your site</li>
            <li><code>%order_id%</code> &ndash; the order ID</li>
            <li><code>%order_amount%</code> &ndash; the total amount of the order</li>
		</ul>'); ?>
</td>
      </tr>
      <tr valign="top">
        <th class="titledesc" scope="row"> <?php _e('Default Customer SMS Notification Message', 'rc2c_plugin'); ?>
        </th>
        <td class="forminp"><textarea style="width:40%; height: 65px;" name="rc2c_settings[default_message]"><?php echo $rc2c_options['default_message']; ?></textarea></td>
      </tr>
      <tr valign="top">
        <th class="titledesc" scope="row"> <?php _e('Pending SMS Message', 'rc2c_plugin'); ?>
        </th>
        <td class="forminp"><textarea style="width:40%; height: 65px;" name="rc2c_settings[pending_message]"><?php echo $rc2c_options['pending_message']; ?></textarea></td>
      </tr>
      <tr valign="top">
        <th class="titledesc" scope="row"> <?php _e('On-Hold SMS Message', 'rc2c_plugin'); ?>
        </th>
        <td class="forminp"><textarea style="width:40%; height: 65px;" name="rc2c_settings[on_hold_message]"><?php echo $rc2c_options['on_hold_message']; ?></textarea></td>
      </tr>
      <tr valign="top">
        <th class="titledesc" scope="row"> <?php _e('Proccessng SMS Message', 'rc2c_plugin'); ?>
        </th>
        <td class="forminp"><textarea style="width:40%; height: 65px;" name="rc2c_settings[processing_message]"><?php echo $rc2c_options['processing_message']; ?></textarea></td>
      </tr>
      <tr valign="top">
        <th class="titledesc" scope="row"> <?php _e('Completed SMS Message', 'rc2c_plugin'); ?>
        </th>
        <td class="forminp"><textarea style="width:40%; height: 65px;" name="rc2c_settings[completed_message]"><?php echo $rc2c_options['completed_message']; ?></textarea></td>
      </tr>
      <tr valign="top">
        <th class="titledesc" scope="row"> <?php _e('Cancelled SMS Message', 'rc2c_plugin'); ?>
        </th>
        <td class="forminp"><textarea style="width:40%; height: 65px;" name="rc2c_settings[cancelled_message]"><?php echo $rc2c_options['cancelled_message']; ?></textarea></td>
      </tr>
      <tr valign="top">
        <th class="titledesc" scope="row"> <?php _e('Refunded SMS Message', 'rc2c_plugin'); ?>
        </th>
        <td class="forminp"><textarea style="width:40%; height: 65px;" name="rc2c_settings[refunded_message]"><?php echo $rc2c_options['refunded_message']; ?></textarea></td>
      </tr>
      <tr valign="top">
        <th class="titledesc" scope="row"> <?php _e('Failed SMS Message', 'rc2c_plugin'); ?>
        </th>
        <td class="forminp"><textarea style="width:40%; height: 65px;" name="rc2c_settings[failed_message]"><?php echo $rc2c_options['failed_message']; ?></textarea></td>
      </tr>
    </table>
    <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'rc2c_plugin'); ?>" />
    </p>
  </form>
</div>
<hr />
<h3>
  <?php _e('Sending SMS directly', 'rc2c_plugin'); ?>
</h3>
<?php
$data = array();
$data['phone'] = sanitize_text_field($_POST['mobile_test']);
$data['secret_key'] = $rc2c_options['secret_key'];
$data['message'] = esc_textarea($_POST['your_message']);

if($_POST['submitted'] == 'true') {
  include('rc2c_send_sms.php');
  $warning = __('<em style="color:#00960C;">SMS has been sent to recipient</em>', 'rc2c_plugin');
}
  ?>
<script type="text/javascript">
$(document).ready(function() {
    var text_max = 160;
    $('#charcount').html(text_max + ' characters remaining');

    jquery('#your_message').keyup(function() {
        var text_length = $('#your_message').val().length;
        var text_remaining = text_max - text_length;

        $('#charcount').html(text_remaining + ' characters remaining');
    });
});
</script>
<form name="sendsmsdirect" method="post" action="#submit">
  <table class="form-table">
    <tr valign="top">
      <th class="titledesc" scope="row"> <?php _e('Mobile Number', 'rc2c_plugin'); ?>
      </th>
      <td class="forminp">
      <?php echo $warning; ?>
      <input id="rc2c_settings[mobile_test]" name="mobile_test" type="text" required="required" value="<?php echo $rc2c_options['mobile_test']; ?>"/></td>
    </tr>
    <tr valign="top">
      <th class="titledesc" scope="row"> <?php _e('Your Message', 'rc2c_plugin'); ?>
      </th>
      <td class="forminp"><textarea style="width:40%; height: 65px;" id="your_message" required="required" maxlength="160" name="your_message"><?php echo $rc2c_options['your_message']; ?></textarea><br/>
      <div id="charcount"></div>

        </td>
    </tr>
    <tr valign="top">
      <th class="titledesc" scope="row"> </th>
      <td class="forminp"><input type="hidden" name="submitted" value="true" />
        <input type="submit" id="submit" class="button" value="<?php _e('Send', 'rc2c_plugin'); ?>" /></td>
    </tr>
  </table>
</form>
<hr />
<p><?php echo __('If you have a problem using this plugin contact me <a href="http://www.radongrafix.com/contact" target="_blank">here</a>'); ?></p>
<?php
	echo ob_get_clean();
}

function rc2c_add_options_link() {
	add_submenu_page( 'woocommerce', $rc2c_plugin_name.' Options', 'RC2wooCommerce', 'manage_options', 'rc2c-options', 'rc2c_options_page' );
}
add_action('admin_menu', 'rc2c_add_options_link');

function rc2c_register_settings() {
	// creates our settings in the options table
	register_setting('rc2c_settings_group', 'rc2c_settings');
}
add_action('admin_init', 'rc2c_register_settings');
