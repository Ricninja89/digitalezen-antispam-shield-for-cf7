# Comportamento atteso in produzione

Il plugin **DigitaleZen AntiSpam Shield for CF7** protegge i moduli di Contact Form 7 su siti reali applicando le seguenti misure:

- **Token invisibile** – ogni form include un token temporaneo; l'invio viene bloccato se il token non corrisponde a quello atteso per l'ora corrente.
- **Campo honeypot** – il campo nascosto `spamcheck` deve restare vuoto, in caso contrario l'invio è rifiutato.
- **Blacklist personalizzabile** – gli indirizzi IP, le email, i domini, gli username e le parole chiave elencati nel file `cf7-blacklist.json` causano il blocco del messaggio.
- **Protezione flood** – più di tre invii dallo stesso IP o email in 15 minuti vengono considerati spam e attivano anche un blocco temporaneo dell'IP.
- **Tempo minimo di compilazione** – se il campo `timestamp` indica che il form è stato inviato in meno di quattro secondi, viene segnalato come sospetto.
- **Logging e report** – ogni tentativo bloccato è registrato in `cf7-spam-log.csv` e può essere inviato via email settimanalmente.

Queste regole garantiscono che solo gli invii genuini raggiungano il proprietario del sito mentre i bot vengono intercettati e isolati.
