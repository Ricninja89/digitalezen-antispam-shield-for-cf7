## Registro modifiche

### Correzioni effettuate
- Aggiunto `riccardorosignoli` alla lista dei contributors nei file README.
- Documentato l'uso dello script esterno DigitaleZen Google Apps Script nella sezione "External services" del readme.
- Sostituite le inclusioni inline di JavaScript con `wp_add_inline_script` e utilizzo di `wp_json_encode` per i dati del grafico.
- Spostato il salvataggio dei file generati dal plugin nella cartella `wp_upload_dir()` con slug dedicato e aggiunte costanti `DZ_CF7_UPLOAD_DIR`/`DZ_CF7_UPLOAD_URL`.
- Rimossi i riferimenti a `WP_CONTENT_DIR` e aggiornati i percorsi dei file nelle funzioni di logging, firewall e visualizzazione.
- Sostituito lo slug admin generico con il costante `DZ_CF7_MENU_SLUG` per evitare conflitti.
- Corrette le chiamate a `json_encode` sostituendole con `wp_json_encode`.

### Correzioni mancanti / da verificare
- Rieseguire Plugin Check e WPCS per individuare eventuali altri avvisi o text-domain non uniformi.
- Valutare ulteriori controlli di sanitizzazione/escaping su tutto il codice.
