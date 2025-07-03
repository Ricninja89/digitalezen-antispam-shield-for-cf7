=== DigitaleZen CF7 AntiSpam Shield ===
Contributors: digitalezen, Riccardo Rosignoli  
Donate link: https://digitalezen.it  
Tags: contact form 7, spam, anti-spam, firewall, honeypot, blacklist, email protection, token, no captcha  
Requires at least: 5.6  
Tested up to: 6.8  
Requires PHP: 7.4  
Stable tag: 1.0.0  
License: MIT  
License URI: https://opensource.org/licenses/MIT  

The ultimate protection for Contact Form 7: block spam, bots, and automated attacks using invisible honeypots, dynamic tokens, IP firewall, and real-time blacklist updates. No CAPTCHA required.

== Description ==

🛡️ *DigitaleZen CF7 AntiSpam Shield* is a lightweight yet powerful plugin that protects **Contact Form 7** forms from spam, bots, and suspicious submissions.

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
3. Go to **Settings > CF7 AntiSpam Shield** to view data and copy optional shortcodes

== Frequently Asked Questions ==

= Does it work without reCaptcha? =  
Yes. And in many cases it blocks spam that reCaptcha doesn't catch.

= Is the blacklist updated automatically? =  
Yes. Every 24h, the plugin downloads a JSON file from a public source maintained by DigitaleZen.

= Do I need to configure anything? =  
No. But you can customize the weekly report recipient and enable specific shortcodes if needed.

= Are user data sent to third parties? =  
No. All data (IP, emails, logs) remain local. The blacklist is read-only.

== Changelog ==

= 1.0.0 =  
* Initial stable release.  
* Full-featured protection for Contact Form 7: tokens, blacklist, firewall, chart, logs, and email reports.

== Upgrade Notice ==

= 1.0.0 =  
Initial public release with all basic and advanced features to stop spam without CAPTCHA.
