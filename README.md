# 🛡️ DigitaleZen CF7 AntiSpam Shield

Il plugin definitivo per proteggere Contact Form 7 dallo spam, senza compromessi.

Creato per difendere il tuo sito dagli attacchi automatici più aggressivi, **CF7 AntiSpam Shield** combina intelligenza dinamica, automazione e controllo totale, il tutto con un’interfaccia semplice e minimale in perfetto stile DigitaleZen.

---

## 🚀 Caratteristiche principali

### 🔒 1. Protezione avanzata Contact Form 7
Blocca spam in tempo reale grazie a una combinazione di tecniche moderne:

- **Honeypot invisibile**
- **Token di sessione a scadenza oraria**
- **Controllo velocità invio (min 4 secondi)**
- **Blacklist dinamica aggiornata ogni giorno**
- **Flood protection (3 tentativi in 15 minuti)**

---

### 🧠 2. Blacklist dinamica by DigitaleZen (via Google Apps Script)

Il plugin si collega a un **servizio pubblico ufficiale** mantenuto da [DigitaleZen.it](https://digitalezen.it), che fornisce un file JSON sempre aggiornato con dati aggregati da fonti autorevoli:

- 🧱 **StopForumSpam** (IP e email noti)
- 📬 **Spamhaus / SpamCop** (liste DNSBL)
- Altri provider in sviluppo...

👉 Il sistema si aggiorna **ogni 24 ore** in automatico.

---

### 📁 3. Logging completo dei tentativi bloccati

Tutti i tentativi di invio bloccati vengono **registrati in un file CSV** che include:

- Data e ora
- Email e IP del mittente
- Motivo del blocco (honeypot, blacklist, flood, ecc.)
- Valore scatenante (es. parola chiave, dominio...)

---

### 💥 4. Firewall "soft" temporaneo

Se un IP tenta invii sospetti, viene **bloccato per 10 minuti**.  
Il file `block-ip.txt` gestisce la lista in modo dinamico e viene ripulito automaticamente.

---

### 📊 5. Dashboard interattiva in WP Admin

- 📬 Configura l’email che riceve il report settimanale
- 🧾 Visualizza i **file log e JSON** generati dal plugin
- 📈 Analizza i tentativi bloccati con un **grafico in tempo reale**
- 🔎 Tabella degli ultimi 30 bot intercettati

Tutto visibile da un’unica pagina, accessibile solo dagli **amministratori WordPress**.

---

### 📬 6. Report settimanale automatico

Ogni lunedì alle 02:00 riceverai un'email con il file CSV dei tentativi bloccati, aggiornato e azzerato.  
Il destinatario è configurabile dalla dashboard.

---

## 🛠️ File generati dal plugin

| Nome file                | Descrizione |
|--------------------------|-------------|
| `cf7-spam-log.csv`       | Log dettagliato dei blocchi |
| `cf7-blacklist.json`     | Blacklist aggiornata da DigitaleZen |
| `block-ip.txt`           | IP temporaneamente bannati |
| `ip-attempts.json`       | Storico tentativi sospetti per IP |
| `email-attempts.json`    | Storico tentativi sospetti per email |

Tutti visualizzabili e scaricabili dal backend.

---

## 🔐 Sicurezza e Privacy

- Nessuna raccolta dati lato DigitaleZen.
- Tutti i file restano sul tuo server.
- Solo chi ha i permessi `manage_options` può accedere alla dashboard.
- Accesso ai JSON solo tramite **whitelist sicura**.

---

### 🧩 In sviluppo

- ⚠️ **Pulsante "Segnala come spam"** direttamente dalle email ricevute
- 🔌 **Modulo premium**: collegamento ad API esterne (IPQualityScore, SpamAssassin, CleanTalk…)
- 💬 **Notifiche istantanee** (email, Telegram) per invii sospetti
- 🔁 **Pulizia automatica** dei file IP/JSON temporanei scaduti
- ⚙️ **Gestione completa da dashboard**:
  - Personalizza ogni parametro: email di notifica, timeout IP, limiti tentativi, durata flood protection, parole chiave vietate, domini sospetti, e altro...
  - Nessun bisogno di modificare codice o accedere via FTP

---

### 🧠 Perché è importante?

L’obiettivo è offrire **il massimo controllo direttamente dalla UI**, così l'utente può adattare il plugin alle specifiche esigenze del proprio sito, **senza mai toccare il codice**.


---

## ❤️ Perché funziona?

Questo plugin **non si limita a un captcha**.  
Lavora su **più livelli contemporaneamente**: prevenzione, controllo, blacklist intelligente e blocco attivo.

Confrontato con soluzioni standard, **DigitaleZen CF7 AntiSpam Shield**:

- Blocca spam che passa anche con reCaptcha attivo
- Intercetta attacchi distribuiti, bruteforce, form-bots evoluti
- Registra tutto con trasparenza

> Proteggi i tuoi moduli. Mantieni pulito il tuo sito. E fai respirare il tuo server.

---

## 🧘 Powered by [DigitaleZen.it](https://digitalezen.it)

Creato con consapevolezza, leggerezza e un pizzico di furia antispam.  
Per contatti, moduli avanzati o supporto: [digitalezen.it](https://digitalezen.it)

