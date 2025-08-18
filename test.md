# Lista Test

Elenco dei controlli automatici che verificano l'efficacia del plugin:

- **Token invisibile**: le richieste con un token non valido vengono bloccate e registrate nel log.
- **Honeypot**: se il campo nascosto `spamcheck` è compilato l'invio viene impedito.
- **Blacklist**: email presenti nel file `cf7-blacklist.json` non possono inviare il modulo.
- **Rilevamento flood**: dopo tre invii nello stesso intervallo l'indirizzo IP/email viene considerato sospetto.
