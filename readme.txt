=== DigitaleZen CF7 AntiSpam Shield ===
Contributors: DigitaleZen, Riccardo Rosignoli
Donate link: https://digitalezen.it
Tags: contact form 7, spam, anti-spam, firewall, honeypot, blacklist, email protection
Requires at least: 5.6
Tested up to: 6.5.2
Requires PHP: 7.4
Stable tag: 1.0.0
License: MIT
License URI: https://opensource.org/licenses/MIT

Blinda i tuoi moduli Contact Form 7 con uno scudo antispam completo: token dinamici, blacklist aggiornate, firewall IP, logging avanzato e report via email. Tutto senza CAPTCHA.

== Description ==

🛡️ **DigitaleZen CF7 AntiSpam Shield** è una protezione multilivello per i moduli Contact Form 7, capace di bloccare spam, bot e invii sospetti senza appesantire l'esperienza utente.

💡 Include:
- Honeypot invisibile
- Token orari SHA256
- Flood control intelligente (IP/email bloccati dopo 3 tentativi)
- Firewall IP temporaneo (soft ban)
- Blacklist automatica aggiornata ogni 24h da fonti pubbliche (StopForumSpam, Spamhaus, SpamCop)
- Logging CSV dettagliato dei tentativi bloccati
- Dashboard interattiva con grafici
- Report settimanale via email configurabile

> 🚫 Nessun CAPTCHA. Nessuna configurazione complicata. Funziona out-of-the-box.

== Features ==

- 🔐 Blocco invisibile tramite honeypot
- ⏳ Timer minimo di invio (4 secondi)
- 🧠 Token SHA256 validi 2 ore
- 📩 Blacklist dinamica per IP, email, domini, keyword, username
- 💥 Flood protection automatica (3 invii in 15 min = ban)
- 🧱 Soft firewall IP con ban temporanei (10 minuti)
- 📊 Logging CSV con data, email, IP, motivo e trigger
- 📈 Grafico interattivo spam bloccati (diviso per categoria e periodo)
- 🧾 Tabella ultimi tentativi intercettati
- 📁 Download diretto di log, JSON e blacklist
- 📬 Report settimanale via email (configurabile)
- 👁️ Visualizzazione sicura file JSON via AJAX
- 🔒 Tutte le funzioni visibili solo dagli amministratori
- 🎨 UI minimale e curata in stile DigitaleZen

== Screenshots ==

1. Dashboard del plugin
2. Impostazioni report email
3. Grafico spam bloccati per tipo e periodo
4. Log dettagliato dei bot intercettati
5. Visualizzazione JSON e file log

== Installation ==

1. Carica la cartella del plugin in `/wp-content/plugins/`
2. Attiva il plugin da "Plugin > Installati"
3. Vai in "Impostazioni > CF7 AntiSpam Shield" per visualizzare i dati e inserire gli shortcode

== Frequently Asked Questions ==

= Il plugin funziona anche senza reCaptcha? =
Sì, e spesso intercetta spam che passa inosservato con reCaptcha attivo.

= La blacklist si aggiorna automaticamente? =
Sì, ogni 24 ore. Viene scaricata da una fonte pubblica curata da DigitaleZen (basata su SpamCop, StopForumSpam, ecc.).

= Posso usarlo senza scrivere codice? =
Certo. Tutte le funzionalità sono pronte all'uso e accessibili dalla dashboard.

= Il plugin invia dati personali a terzi? =
No. Nessun dato viene inviato a DigitaleZen o ad altri. La blacklist viene solo scaricata (read-only) da una URL pubblica.

== Changelog ==

= 1.0.0 =
* Prima versione pubblica
* Dashboard completa, logging CSV, blacklist, grafico, report via email, firewall soft IP

== Upgrade Notice ==

= 1.0.0 =
Versione iniziale. Include tutte le funzionalità base e avanzate per proteggere CF7 senza CAPTCHA.
