=== Arigato Autoresponder and Newsletter ===
Contributors: prasunsen
Tags: autoresponder, auto responder, mailing list, newsletter, wpmu, contact form
Requires at least: 4.0
Tested up to: 5.8
Stable tag: trunk

This plugin allows scheduling of automated autoresponder messages / drip marketing messages, instant newsletters, and managing a mailing list.

== Description ==

[Arigato PRO](http://calendarscripts.info/bft-pro/ "Go Pro") | [FAQ](https://wordpress.org/plugins/bft-autoresponder/#faq)

This powerful email marketing plugin allows scheduling of automated autoresponder messages and newsletters, and managing a mailing list. Use it for all kind of drip marketing campaigns, email based courses, product or service updates, and many more.

[youtube https://www.youtube.com/watch?v=PgGGxnDAEpY]

### Features ###

* Unlimited number of subscribers
* Unlimited number of newsletters
* Unlimited number of auto-responder / drip marketing email messages
* Import and exports members from / to CSV file
* Send messages X days after user registration
* Send messages on fixed dates
* Send newsletters / news flashes
* Add attachments
* Double opt-in
* Google reCaptcha against spam
* Question based captcha
* Selected user role can manage the auto-responder
* Sends hooks for integration with other plugins
* Redirecting after registration
* Optional admin notifications on subscribe / unsubscribe
* Automatically subscribe users who register on your site / blog (optional)
* Automatically create WP user accounts for mailing list subscribers (optional)
* Optional public newsletters archive
* Detailed email log
* Compatible with all SMTP plugins: will send emails through them
* GDPR compliance features
* PHP 6, PHP 7, PHP 8 compatible
* Always updated and supported

### Integrations ###

**Built-in integration with [Contact Form 7](http://wordpress.org/plugins/contact-form-7/ "Contact Form 7")**
**Built-in integration with [Jetpack Contact Form](http://wordpress.org/plugins/jetpack/ "Jetpack")**
**Built-in integration with [Ninja Forms](https://wordpress.org/plugins/ninja-forms/ "Ninja Forms")**
**Built-in integration with [Formidable Forms](https://wordpress.org/plugins/formidable/ "Formidable Forms")**

= Community Translations =

Swedish translation available thanks to Patrik: [.po](http://calendarscripts.info/free/wordpress/broadfast-sv_SE.po ".po file") / [.mo](http://calendarscripts.info/free/wordpress/broadfast-sv_SE.mo ".mo file")
German translation available thanks to @mpek: [.po](http://calendarscripts.info/free/wordpress/broadfast-de_DE.po ".po file") / [.mo](http://calendarscripts.info/free/wordpress/broadfast-de_DE.mo ".mo file")

== Installation ==

1. Unzip the contents and upload the entire `bft-autoresponder` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the sender address and other options from the main page accessible from the newly appeared "Arigato Light" menu.
4. Manage your email messages and mailing list.
5. In order to send automated sequential emails every day your blog should be visited at least once daily. If this is not happening, please set up a cron job to visit it using the command shown in your Arigato Light Settings page.

== Changelog ==

= Changes in 2.6.8 =
1. Added admin.css and improved the design of the administration pages.
2. Added mime type validation for the import file with subscribers.
3. Added a personal data eraser for GDPR compliance.
4. Added configurable attribute "button_text" to the signup shortcode to allow using custom button text.
5. PHP 8 compatibility.
6. "Skip title row" when importing CSV.
7. Added option to automatically create a WP user account when someone subscribes to your mailing list. The user may also be automatically logged in.
8. Added a shortcode to publish the newsletters archive on the front-end.
9. Added a Formidable Forms integration.

= Changes in 2.6 =
1. Removed the old method of calling cron jobs. If you were using it, you have to switch to the new command shown in the Arigato Settings page
2. The plugin will now use wp_cron as a default method instead of the previous custom solution.
3. Fixed problems with quotes in email subjects of newsletters, email messages and double opt-in emails.
4. Added proper button classes.
5. Added option to BCC all outgoing emails to a selected email address.
6. You can now specify receiver(s) of the subscribe / unsubscribe notification messages.
7. Added stats for number of unsubscribed users (it starts counting from now on)
8. Added Google reCaptcha v2 and v3 support. You can enable it from Arigato Settings page.
9. Added option to allow passing arguments by GET to the signup form. Useful to prepopulate values from other marketing campaigns.
10. Improved emoji support in messages and newsletters.
11. Raw email log now has from-to date selector.

= Changes in 2.5 =
1. Made some security fixes and code improvements
2. Improved protection against duplicates (with lock file)
3. Added options for non-admin user roles to manage the plugin
4. Added optional artifical delay between emails. This will be useful if you get emails flagged as spam for sending too fast.
5. Improvements to the newsletters: they will now be sent by the cron job accordingly to your sending limits. 
6. Reworked the signup form and added new responsive CSS to it
7. Made the admin tables responsive to allow managing the autoresponder in small screen mobile devices
8. The new shortcode [bft-unsubscribe] lets you create a static unsubscribe confirmation page.
9. Will no longer store or show IP addresses to comply with GDPR and other data protection laws.
10. "Name" can now be set as a required field in the signup form (valid email is always required)

= Changes in 2.4 = 
1. Fixed the missing link to Ninja Forms integration
2. Added wp_nonce fields to all forms for improved security
3. Started and documented the basic developer's API
4. Added option to use simple question based captcha. Note that this will work only with the shortcode and not the raw HTML code. Once you enable the captcha, forms using the HTML code will no longer work until you switch it off!
5. You can now use the variables {{{unsubsribe-link}}} or {{{unsubscribe-url}}} to create custom "click here to unsubscribe" text
6. Added variables {{email}} and {{ip}} in the double opt-in message
7. In the Settings page you can now disable the default alerts that are shown when user subscribes and unsubscribes
8. Added filters / search form on the Subscribers page
9. Added pseudo lock tables to prevent sending duplicate emails
10. Reworked the Ninja Forms integration to work with their latest version
11. Added shortcode [bft-num-subs] to show the total number of active subscribers

= Changes in 2.3 =
1. Now keeps track of all the previous newsletters and lets you edit and re-send them
2. Added configurable field names for the Contact Form 7 Integration
3. Added option to use real cron job. This will help you to define what time of the day to send your emails by scheduling the cron job for that time.
4. Changed plugin name to Arigato
5. One more attempt to avoid the odd duplicate emails problem that some users experience
6. Added optional redirect URL after email confirmation
7. You can now limit the number of emails sent at once. Note: if you use cron job it's no longer required to run it only once per day. In fact it's recommended to run it more often, for example once per hour.
8. Reworked the UI on the Mailing list page, added number of emails sent, added field to edit the subscriber's date
9. Added integration with Ninja forms
10. Made the 'Your email address has been confirmed!' alert box optional on double opt-in emails

= Changes in 2.2 =
1. Added "Mass delete" option in the mailing list
2. The "{{name}}" mask can now be used also in the double optin email
3. Option to automatically subscribe users who register to the blog. Note that this happens when they first login to avoid bot subscriptions.
4. Built-in integration with Contact Form 7 lets you signup users when they fill your contact form
5. Added raw email log of all emails sent. This will help you know what emails have been sent on each day
6. Added option to automatically cleanup the raw email log after given number of days
7. Added built-in integration with Jetpack contact form
8. Improved the export format and made it download a file
9. Now you can select if you want to send HTML or text/plain emails
10. We have added attachments for your autoresponder emails

= Changes in 2.1 =
1. Added user's name and registration date in unsubscribe notification emails
2. Removed several deprecated usages of wpdb::escape()
3. Added basic validation for empty email on subscribe
4. Double opt-in message is now configurable
5. Created a help page (moved the manual out of the options page)
6. Added alerts when user unsubscribes or confirms their email address
7. Fixed for compatibility with WordPress 3.8
8. Added pagination on the mailing list page
9. You can now configure subscribe and unsubscribe notification messages
10. Fixed missing "unsubscribe" link in instant newsletters

= Changes in 2.0 =
1. Changed the cron job logic in attempt to avoid a multiple emails issue that some people complain about
2. Improved the cron job logic further to avoid simultaneous runnings of the same
3. When the sender's detail are left empty will use the default sender from your Wordpress Settings page
4. Many strings were missing in the .pot file, fixed this.
5. From version 2.0 you can send immediate newsletters. Do it with caution.
6. Other code fixes and code improvements

= Changes in 1.9: =

1. Shortcodes get executed in messages. Be careful with this though as CSS and Javascript effects will not always work.
2. Optional notification when new user registers (and confirms their email, if double opt-in is selected)
3. Optional notification when user unsubscribes

= Changes in version 1.8: =
1. Sortable mailing list + visual improvements
2. Localization-friendly (pot file inside)
3. Of course various bug fixes as always

= Changes in version 1.7: =

1. Using wp_mail so now you can use any of the existing SMTP plugins
2. Rich text editor available to format the messages
3. Shortcode available for the signup form
4. Code fixes and bug fixes

== Frequently Asked Questions ==

= Can I send unlimited messages? =

Yes, there is no limitation. However you'd better not set more than one email to be sent at the same number of days after user registration.

= Can I send emails through SMTP? =

Yes. Just install any of the available free SMTP plugins for WordPress. We recommend WP Mail SMTP, Postman SMTP or Easy WP SMTP. Arigato will automatically send all its emails through it.

No settings are required in Arigato for this. When your WordPress emails are sent through an SMTP plugin, Arigato emails will be sent through it as well. This is because Arigato routes its emails through the default WordPress mail() funciton. If you already use an SMTP plugin on your site, Arigato will use it automatically.

= Is there an unsubscribe link? =

Yes, an unsubscribe link is automatically added to every outgoing message.

= What to do if it doesn't send emails? = 

Please install a plugin like WP Mail SMTP or Easy WP SMTP and try to send a test email. If the test email isn't received, it means the problem is not in the autoresponder and you should talk to your hosting support.

= Are there any limits to how many emails can be sent? = 

The autoresponder itself does not impose any limits, but your hosting company probably does. If you plan to have large mailing list, you will need the pro version because it lets you fine-tune the number of emails sent to comply with your hosting company limitations.

= Is this plugin GDPR compliant? =

Arigato is just a tool and has a lot less to do with GDPR compliance than the way you use it. The plugin has always provided the necessary functions: there is unsubscribe link attached to every message so the users can delete their data. There is double opt-in feature which you can (and should) use. We have hooked a personal data eraser to the WordPress personal data eraser tool.

From then on, compliance depends on how you use the plugin:

- Be clear what the users are subscribing to and don't send them anything else.
- Use the double opt-in feature.
- Never remove the unsubscribe link.
- Never provide your mailing list to someone else.
- The above information is not a legal advice and is not meant to be a complete GDPR guide. You should do your own research and decide what you can and can not use.  

= How to change the text of the subscribe button or any other text generated by the plugin =

You can change any texts using [Loco Translate](https://wordpress.org/plugins/loco-translate/ "Loco Translate")

= How to change the design of the signup form? =

You can change the form design using CSS. If you want to do more changes, reorder the fields, etc, you can use the HTML form code and change it directly. 


== Screenshots ==

1. Main settings page. Get the signup form code, configure double opt-in, and more.
2. Manage your mailing list, add/edit/delete subscribers
3. Import and export contacts to/from CSV file
4. Create a new autoresponder message
5. Send instant newsletter to all active subscribers