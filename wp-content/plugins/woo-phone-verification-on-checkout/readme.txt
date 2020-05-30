=== WooCommerce Phone Verification on Checkout & SMS Order Notifications using RingCaptcha ===
Contributors: ringcaptcha
Tags: WooCommerce, 2FA, phone verification, RingCaptcha, SMS order notifications, checkout
Website link: https://ringcaptcha.com/
Requires at least: 4.0
Tested up to: 5.1
Stable tag: 2.8
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Phone verification on WooCommerce checkout using RingCaptcha.

== Description ==
This plugin replaces the default phone field on your WooCommerce checkout page with RingCaptcha's phone verification widget. WooCoommerce does not have phone verification by default so people can just input random phone numbers and business owners can't verify if an order is legitimate or not.

This plugin also adds SMS order notifications to admin and customers whenever someone places an order. This is useful for notifying customers for the status of your shipping, or simply just giving thank you messages. SMS order notifications are tied to each WooCommerce order status, for example an SMS is sent to a customer when you update the order to completed.

Watch the demo [here](https://youtu.be/cVUjDMnsvcY).

= GDPR =
Need to get consent from users in order to be GDPR compliant? No problem! RingCaptcha now has a GDPR-compliant version of this widget.
You can enable the functionality from the plugin settings, under GDPR section. Please refer to the FAQs section for detailed step-by-step instructions.


 Contact the RingCaptcha team on [their site](https://ringcaptcha.com?utm_source=wordpress&utm_medium=plugin_marketplace&utm_campaign=woocommerce) to learn more.

= Why should I use this plugin? =

- I want to minimize bots / fraudulent orders.
- I want to ensure customers are legit (especially for Cash on Delivery).
- I want a legit phone number tied per order.
- I want to receive SMS notifications when someone places an order.
- I want to send SMS notifications to customers about their order.

= Functionalities: =

1. Phone verification widget on checkout page using RingCaptcha's SMS API.
2. Customizable SMS order notifications for admin and customers.
5. Send SMS from the admin page.

= Limitations: =

- Freemium plan has some limitations
  - Phone verification is limited to 500 per month
  - SMS notification is not available

- However, if you are operating an interesting business that is disruptive, we are happy do waive the freemium plan limitations for you. Just simply reach out via e-mail (accounts@ringcaptcha.com) or via Intercom on our site (https://ringcaptcha.com)

== Installation ==
1. Download and install this plugin.
2. Signup for [RingCaptcha](https://my.ringcaptcha.com/register).
3. Create a RingCaptcha app to get your App key and Secret Key. Make sure to add the domain of your site on the RingCaptcha app.
4. From your wp-admin page, click 'WooCommerce' -> 'RingCaptcha' and copy your keys.
5. That's it! You can now visit your checkout page which contains RingCaptcha's phone verification widget.

You can also watch this video [tutorial](https://youtu.be/cVUjDMnsvcY).
For detailed guide of the plugin, please refer to readme.html.

== Screenshots ==

1. RingCaptcha Phone Verification on Checkout
2. Asking for PIN
3. Phone Successfully Verified
4. Settings Page
5. Customer SMS Order Notifications
6. GDPR-compliant Phone Verification Widget
7. GDPR consent custom field attached per WooCommerce Order

== Frequently Asked Questions ==
= Where can I get 'App key' and 'Secret key'? =
Simply signup for [RingCaptcha](https://my.ringcaptcha.com/register) to and create an app to get your keys.
For a step-by-step video, please refer [here](https://youtu.be/cVUjDMnsvcY).

= SMS notification is not working. Why? =
Since the plugin's SMS notification uses RingCaptcha's Direct SMS feature, this feature is turned off by default on RingCaptcha's side to avoid spam and abuse. Also, sending Direct SMS is a premium feature of RingCaptcha but we're willing to unlock this for WordPress users. Just simply reach out via e-mail (accounts@ringcaptcha.com) or via Intercom on our site (https://ringcaptcha.com) and we'll do it for you.

= Can I remove the RingCaptcha logo? =
Sure! Just reach out via e-mail (accounts@ringcaptcha.com) or via Intercom on our site (https://ringcaptcha.com) and we'd be more than happy to do it for you.

= Can I only verify users who hasn't verified before? =
The plugin currently verifies phone number per each order regardless if the phone number has already verified before or not. This is good in a sense that each order and phone verification is unique on its own, to avoid possible fraud.

= Can I only use verify when mode of payment is CoD? =
The plugin currently verifies phone number regardless of the mode of payment. This reduces bot attacks / fraudulent orders as well.

= Checkout won't proceed even after a phone number is verified. Why? =

1. From WordPress Admin, navigate to WooCommerce > RingCaptcha.
2. Under 'Troubleshooting' section, check 'Enable Javascript Implementation'.
3. Click 'Save Changes'.

This should apply a Javascript workaround to fix the problem.

This problem occurs when your hosting provider cannot execute an HTTP request (probably disabled) to our API to confirm if the phone number has already been verified making it stuck on checkout page.

= How to enable GDPR-compliant phone verification widget? =

1. From WordPress Admin, navigate to WooCommerce > RingCaptcha.
2. Under 'GDPR' section, click 'Check if you need to get consent from users for GDPR compliance.'.
3. Click 'Save Changes'.

You can now check your checkout page with an updated GDPR-compliant phone verification widget.

= Where do GDPR consent get stored into? =

Each GDPR consent get stored into each WooCommerce order via a custom field.
You can check each GDPR consent if you navigate to WooCommerce > Orders.

== Changelog ==

= 1.0 =
* Initial creation of the plugin.

= 1.1 =
* Updated Javascript to be loaded in the footers section instead of directly on checkout page.
* Fixed CSS issue which causes verification overlap with the WooCommerce order table.

= 2.0 =
* Added new feature SMS notification for both sellers and buyers.
* Ability to send Direct SMS directly from plugin dashboard.
* Fixed some minor bugs.

= 2.1 =
* Tested up to WordPress 4.0.
* Added Translation POT files.
* Fixed phone verificaiton bug error when required fields are empty.

= 2.2 =
* Updated Ringcaptcha API to latest version.
* Fixed – Phone number not showing up in phone field.
* Improved phone verification error message now in sync with the Ringcaptcha API error.

= 2.3 =
* Changed SMS order notifications to trigger every new order instead of new payment to accommodate cash on delivery (CoD)
* Updated documentation and video tutorial.
* Minor UI changes.

= 2.4 =
* Added ‘Voice Call’ option – customers can now also request PIN with the Voice Call option.
* Fixed bypass bug on checkout where users can bypass the phone verification if they delete RingCaptcha div tag and proceed with checkout.
* Changed error message to be more descriptive and uniform with other WooCommerce error fields.

= 2.5 =
* Fix ‘stuck on checkout’ problem even after successfully verifying phone number.
* Clean code to remove WordPress warnings.
* Test up to latest version of WordPress (4.9.5) and WooCommerce (3.3.5).

= 2.6 =
* Add GDPR-compliant phone verification widget functionality.
* Test up to latest version of WordPress (4.9.6) and WooCommerce (3.4.3).

= 2.7 =
* Fix internal server error bugs.
* Add Japanese translation.

= 2.8 =
* Modify Description
* Tested up to WordPress (5.1.1) and WooCommerce (3.5.7)
