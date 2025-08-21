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

Protegge Contact Form 7 con honeypot, token e blacklist aggiornate: zero CAPTCHA.

== Description ==

🛡️ *DigitaleZen AntiSpam Shield for CF7* è un plugin gratuito, leggero e potente per proteggere i moduli **Contact Form 7** da spam, bot e invii sospetti.

Integra un sistema **multilivello** che include:

- Honeypot invisibile
- Token SHA256 a scadenza oraria
- Flood protection automatica
- Firewall IP temporaneo
- Blacklist aggiornata ogni 24 ore da fonti pubbliche (StopForumSpam, Spamhaus, SpamCop)
- Logging avanzato in CSV
- Dashboard con report, grafico interattivo e tabella ultimi tentativi
- Report settimanale via email configurabile

> ✅ Nessuna configurazione avanzata. Nessun CAPTCHA. Nessuna raccolta dati.  
> Funziona out-of-the-box.

== Features ==

- 🔐 Honeypot invisibile
- ⏱️ Timer minimo per invio (min. 4 secondi)
- 🔑 Token SHA256 validi 2 ore
- 🧱 Firewall IP soft (ban di 10 minuti)
- 📩 Blacklist IP, email, domini, keyword, username
- 💥 Flood protection: 3 invii = ban automatico
- 🧾 Logging dettagliato (data, IP, email, motivo, trigger)
- 📈 Grafico interattivo spam bloccati per tipo e periodo
- 📬 Report settimanale via email
- 🧘 Interfaccia minimale in stile DigitaleZen
- 🔒 Tutto visibile solo agli amministratori WordPress

== Screenshots ==

1. Dashboard del plugin
2. Impostazioni email report
3. Grafico tentativi spam bloccati per tipo
4. Log dettagliato ultimi bot intercettati
5. Visualizzazione file JSON (blacklist e tentativi)

== Installation ==

1. Carica la cartella del plugin in `/wp-content/plugins/`
2. Attiva il plugin tramite “Plugin > Installati”
3. Vai in **Impostazioni > DigitaleZen AntiSpam Shield for CF7** per visualizzare i dati e copiare gli shortcode

== Frequently Asked Questions ==

= Il plugin funziona senza reCaptcha? =
Sì. E in molti casi blocca tentativi che reCaptcha non rileva.

= La blacklist si aggiorna automaticamente? =
Sì. Ogni 24h scarica un file JSON da una URL pubblica mantenuta da DigitaleZen.

= Serve configurare qualcosa? =
No. Ma puoi personalizzare l’email per il report settimanale e attivare solo gli shortcode che desideri.

= I dati degli utenti vengono inviati a terzi? =
No. Tutti i dati (IP, email, log) restano locali. La blacklist è in sola lettura.

== Servizi esterni ==

Questo plugin scarica periodicamente una blacklist antispam aggiornata da un servizio gestito da DigitaleZen e ospitato su Google Apps Script (dominio: script.google.com).

• Scopo: ottenere un file JSON con email e domini abusivi/usa-e-getta usati dai controlli firewall del plugin.
• Quando vengono inviati dati: una volta al giorno tramite WP-Cron (e quando un amministratore avvia un aggiornamento manuale).
• Quali dati vengono inviati: non vengono inviati contenuti dei moduli né dati personali degli utenti. La richiesta è server-to-server (HTTP GET) e include solo intestazioni standard (es. User-Agent).
• Archiviazione: il JSON scaricato viene salvato localmente nel tuo sito WordPress (ad es. in wp-content/uploads, in una cartella specifica del plugin).
• Opt-out: è possibile disattivare il fetch esterno e usare i valori predefiniti interni tramite filtri/costanti del plugin.

Informative del provider (titolare del servizio): DigitaleZen — https://digitalezen.it/terms/ • https://digitalezen.it/privacy-policy/
Informative della piattaforma di hosting (infrastruttura): Google — https://policies.google.com/terms • https://policies.google.com/privacy


== Changelog ==

= 1.0.0 =
* Prima versione stabile.
* Protezione completa per Contact Form 7: token, blacklist, firewall, grafico, log e report email.

== Upgrade Notice ==

= 1.0.0 =
Versione iniziale pubblica con tutte le funzionalità base e avanzate per bloccare spam senza CAPTCHA.
