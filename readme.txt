=== DigitaleZen CF7 AntiSpam Shield ===
Contributors: digitalezen, ricninja89
Donate link: https://digitalezen.it
Tags: contact form 7, spam, anti-spam, firewall, honeypot, blacklist, email protection
Requires at least: 5.6
Tested up to: 6.5.2
Requires PHP: 7.4
Stable tag: 1.0.0
License: MIT
License URI: https://opensource.org/licenses/MIT

Blinda Contact Form 7 con una protezione anti-spam multilivello, logging avanzato, firewall IP, token dinamico, e blacklist in tempo reale aggiornata da DigitaleZen.

== Description ==

🛡️ **CF7 AntiSpam Shield** è la soluzione completa, gratuita e leggera per proteggere i tuoi moduli Contact Form 7 da spam, bot e invii malevoli.

Utilizza un sistema ibrido:

- Honeypot invisibile
- Token a scadenza oraria
- Flood protection intelligente
- Blacklist aggiornata ogni 24 ore via API DigitaleZen (StopForumSpam, Spamhaus, SpamCop)
- Blocco IP temporaneo (firewall soft)
- Logging CSV dettagliato
- Dashboard backend completa
- Report settimanale via email configurabile

**Tutto incluso. Nessuna configurazione complessa. Nessun captcha.**

== Features ==

- 🔐 Blocco honeypot invisibile
- 🔁 Verifica velocità invio (min. 4s)
- 🧠 Token orario SHA256 con validità 2 ore
- 📩 Blocco IP/email/dominio/username/keyword
- 💥 Flood control automatizzato (3 invii in 15 min → IP/email bannati)
- 🧱 Firewall IP temporaneo con blocco via `init`
- 📊 Logging CSV dei blocchi
- 📁 Visualizzazione e download file da backend
- 📬 Invio settimanale log via email (configurabile)
- 📈 Report interattivo spam bloccati (grafico + tabella)
- 🧘 UI minimale in stile DigitaleZen
- 👁️ Visualizzazione sicura JSON con sistema whitelist
- 🔒 Accesso limitato solo ad amministratori WordPress

== Screenshots ==

1. Dashboard del plugin
2. Impostazione email report
3. Report grafico spam bloccati
4. Tabella ultimi bot intercettati
5. Visualizzazione file JSON e log

== Installation ==

1. Carica la cartella del plugin in `/wp-content/plugins/`
2. Attiva il plugin tramite la sezione "Plugin" di WordPress
3. Vai in "Impostazioni > CF7 AntiSpam" per configurare

== Frequently Asked Questions ==

= Il plugin funziona senza reCaptcha? =
Sì, e intercetta spam che a volte passa anche con reCaptcha attivo.

= La blacklist viene aggiornata da sola? =
Sì, ogni 24 ore, tramite un collegamento a uno script pubblico mantenuto da DigitaleZen.

= Posso usarlo senza scrivere codice? =
Assolutamente sì. Tutto è accessibile e modificabile dalla dashboard.

= I miei dati vengono inviati a DigitaleZen? =
No. Tutti i dati restano localmente sul tuo sito. La blacklist è solo in lettura da una fonte pubblica.

== Changelog ==

= 1.0.0 =
* Prima release stabile
* Sistema completo di difesa antispam per CF7

== Upgrade Notice ==

= 1.0.0 =
Versione iniziale pubblica. Include tutte le funzionalità base e avanzate di protezione.
