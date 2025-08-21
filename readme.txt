=== DigitaleZen AntiSpam Shield for CF7 ===
Contributors: digitalezen, riccardorosignoli
Donate link: https://digitalezen.it
Author: DigitaleZen
Author URI: https://digitalezen.it
Tags: contact form 7, spam, firewall, blacklist, honeypot
Requires at least: 5.6  
Tested up to: 6.8  
Requires PHP: 7.4  
Stable tag: 1.0.0  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The ultimate shield for Contact Form 7. Blocks spam with honeypots, tokens and a live blacklist—no CAPTCHA.

== Description ==

🛡️ *DigitaleZen AntiSpam Shield for CF7* is a lightweight yet powerful plugin that protects **Contact Form 7** forms from spam, bots, and suspicious submissions.

It combines a **multi-layered defense system**, including:

- Invisible honeypot field
- Hourly-expiring SHA256 token
- Automatic flood protection
- Temporary IP firewall
- Real-time blacklist updates every 24h (StopForumSpam, Spamhaus, SpamCop)
- Advanced CSV logging
- Interactive dashboard with chart and bot log
- Weekly report via email (configurable)

> ✅ No complex setup. No CAPTCHA. No data collection.  
> Works out-of-the-box.

== Features ==

- 🔐 Invisible honeypot protection  
- ⏱️ Minimum send time (4 seconds)  
- 🔑 SHA256 token valid for 2 hours  
- 🧱 Soft IP firewall (10-minute ban)  
- 📩 Dynamic blacklist: IPs, emails, domains, keywords, usernames  
- 💥 Flood protection: 3 submissions = auto ban  
- 🧾 Detailed logging (date, IP, email, reason, trigger)  
- 📈 Interactive chart of blocked spam by type and timeframe  
- 📬 Weekly email reports  
- 🧘 Clean and minimalist DigitaleZen-style UI  
- 🔒 Admin-only dashboard access

== Screenshots ==

1. Plugin dashboard  
2. Weekly report email settings  
3. Chart of blocked spam attempts  
4. Log of intercepted bots  
5. JSON viewer for blacklist and logs

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`  
2. Activate the plugin via “Plugins > Installed”  
3. Go to **Settings > DigitaleZen AntiSpam Shield for CF7** to view data and copy optional shortcodes

== Frequently Asked Questions ==

= Does it work without reCaptcha? =  
Yes. And in many cases it blocks spam that reCaptcha doesn't catch.

= Is the blacklist updated automatically? =  
Yes. Every 24h, the plugin downloads a JSON file from a public source maintained by DigitaleZen.

= Do I need to configure anything? =  
No. But you can customize the weekly report recipient and enable specific shortcodes if needed.

= Are user data sent to third parties? =  
No. All data (IP, emails, logs) remain local. The blacklist is read-only.

== External services ==

This plugin periodically downloads an updated anti-spam blacklist from a service operated by DigitaleZen and hosted on Google Apps Script (domain: script.google.com).

• Purpose: fetch a JSON list of abusive/disposable emails and domains used by the plugin’s firewall checks.
• When data is sent: once per day via WP-Cron (and when an admin triggers a manual update).
• What data is sent: no form submissions and no user personal data are sent. The request is server-to-server (HTTP GET) and only standard headers (e.g., User-Agent) are included.
• Storage: the downloaded JSON is stored locally within your WordPress site (e.g. under wp-content/uploads in a plugin-specific folder).

Provider policies (service owner): DigitaleZen — https://digitalezen.it/terms/ • https://digitalezen.it/privacy-policy/
Hosting platform policies (infrastructure): Google — https://policies.google.com/terms • https://policies.google.com/privacy


== Changelog ==

= 1.0.0 =  
* Initial stable release.  
* Full-featured protection for Contact Form 7: tokens, blacklist, firewall, chart, logs, and email reports.

== Upgrade Notice ==

= 1.0.0 =  
Initial public release with all basic and advanced features to stop spam without CAPTCHA.
