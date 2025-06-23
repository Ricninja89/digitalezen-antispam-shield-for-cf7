<?php
// Sicurezza base
if (!current_user_can('manage_options')) return;

$log_email = get_option('dz_cf7_log_email', get_option('admin_email'));
$upload_dir = wp_upload_dir()['basedir'] . '/cf7-logs';
$upload_url = wp_upload_dir()['baseurl'] . '/cf7-logs';

$log_file = $upload_url . '/cf7-spam-log.csv';
$blacklist_file = $upload_url . '/cf7-blacklist.json';
?>

<div class="wrap" style="max-width: 800px;">
    <h1 style="margin-bottom: 0;">🛡️ DigitaleZen CF7 AntiSpam Shield</h1>
    <p style="margin-top: 4px;">Protezione intelligente per Contact Form 7</p>

    <hr>

    <form method="POST">
        <?php wp_nonce_field('dz_cf7_save_settings'); ?>

        <h2>📬 Impostazioni email report</h2>
        <p>Ogni lunedì alle 2:00 verrà inviato il report dei tentativi di spam bloccati.</p>

        <table class="form-table">
            <tr>
                <th scope="row"><label for="dz_cf7_log_email">Email di destinazione</label></th>
                <td>
                    <input type="email" id="dz_cf7_log_email" name="dz_cf7_log_email" value="<?php echo esc_attr($log_email); ?>" class="regular-text">
                </td>
            </tr>
        </table>

        <p>
            <input type="submit" name="dz_cf7_settings_submit" class="button button-primary" value="Salva impostazioni">
        </p>
    </form>

    <hr>

    <h2>🔧 Shortcode da inserire nei tuoi form CF7</h2>
    <ul style="margin-left: 1em;">
        <li><code>[honeypot spamcheck]</code></li>
        <li><code>[hidden timestamp default:get]</code></li>
        <li><code>[hidden form-token default:get]</code></li>
    </ul>

    <hr>

    <h2>📁 File generati dal plugin</h2>
    <table class="widefat striped" style="margin-bottom: 2em;">
        <thead>
            <tr>
                <th>File</th>
                <th>Descrizione</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>cf7-spam-log.csv</code></td>
                <td>Log dei tentativi bloccati (data, email, IP, motivo, trigger)</td>
                <td>
                    <a href="<?php echo esc_url($log_file); ?>" class="button button-secondary" download>📥 Download</a>
                </td>
            </tr>
            <tr>
                <td><code>cf7-blacklist.json</code></td>
                <td>Blacklist aggiornata da App Script (IP, email, domini, ecc.)</td>
                <td>
                    <a href="<?php echo esc_url(admin_url('admin-ajax.php?action=dz_cf7_view_json&f=cf7-blacklist.json')); ?>"
                             class="button button-secondary" target="_blank">👁️ Visualizza</a>
                    <a href="<?php echo esc_url($blacklist_file); ?>" class="button" download>📥 Download</a>
                </td>
            </tr>
            <tr>
                <td><code>block-ip.txt</code></td>
                <td>IP bloccati temporaneamente (blocco soft, durata 10 minuti)</td>
                <td>
                    <a href="<?php echo esc_url(content_url('/block-ip.txt')); ?>" class="button button-secondary" target="_blank">👁️ Visualizza</a>
                    <a href="<?php echo esc_url(content_url('/block-ip.txt')); ?>" class="button" download>📥 Download</a>
                </td>
            </tr>
            <tr>
                <td><code>ip-attempts.json</code></td>
                <td>Storico tentativi spam per IP</td>
                <td>
                    <a href="<?php echo esc_url(admin_url('admin-ajax.php?action=dz_cf7_view_json&f=ip-attempts.json')); ?>" class="button button-secondary" target="_blank">👁️ Visualizza</a>

                    <a href="<?php echo esc_url(content_url('/ip-attempts.json')); ?>" class="button" download>📥 Download</a>
                </td>
            </tr>
            <tr>
                <td><code>email-attempts.json</code></td>
                <td>Storico tentativi spam per email</td>
                <td>
                    <a href="<?php echo esc_url(admin_url('admin-ajax.php?action=dz_cf7_view_json&f=email-attempts.json')); ?>" class="button button-secondary" target="_blank">👁️ Visualizza</a>
                    <a href="<?php echo esc_url(content_url('/email-attempts.json')); ?>" class="button" download>📥 Download</a>
                </td>
            </tr>
        </tbody>
    </table>


    <hr>

    <h2>📊 Report spam bloccati (dati reali)</h2>

    <canvas id="dz-cf7-chart" height="100" style="margin-bottom: 2em;"></canvas>

    <?php
    // Funzione per filtrare il log per fascia temporale
    function dz_cf7_count_spam_by_range($minutes) {
        $path = wp_upload_dir()['basedir'] . '/cf7-logs/cf7-spam-log.csv';
        if (!file_exists($path)) return 0;

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $count = 0;
        $now = time();

        foreach ($lines as $line) {
            $cols = str_getcsv($line);
            if (!isset($cols[0])) continue;
            $ts = strtotime($cols[0]);
            if (($now - $ts) <= ($minutes * 60)) $count++;
        }

        return $count;
    }

    // Calcolo i blocchi per ogni intervallo
    $data_report = [
        '24h' => dz_cf7_count_spam_by_range(1440),
        '7 giorni' => dz_cf7_count_spam_by_range(10080),
        '28 giorni' => dz_cf7_count_spam_by_range(40320),
        '3 mesi' => dz_cf7_count_spam_by_range(129600),
        '1 anno' => dz_cf7_count_spam_by_range(525600),
    ];

    // Passaggio dati a JS
    echo '<script>window.dz_cf7_chart_data = ' . json_encode(array_values($data_report)) . ';</script>';
    echo '<script>window.dz_cf7_chart_labels = ' . json_encode(array_keys($data_report)) . ';</script>';
    ?>

    <h3>🧾 Ultimi tentativi bloccati</h3>
    <table class="widefat striped" style="max-width: 100%; margin-top: 1em;">
        <thead>
            <tr>
                <th>Data</th>
                <th>Email</th>
                <th>IP</th>
                <th>Motivo</th>
                <th>Trigger</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $path = wp_upload_dir()['basedir'] . '/cf7-logs/cf7-spam-log.csv';
        if (file_exists($path)) {
            $lines = array_reverse(file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
            $max = 30;
            foreach (array_slice($lines, 0, $max) as $line) {
                $cols = str_getcsv($line);
                echo '<tr>';
                foreach ($cols as $col) {
                    echo '<td>' . esc_html($col) . '</td>';
                }
                echo '</tr>';
            }
        }
        ?>
        </tbody>
    </table>


    <hr>

    <p style="margin-top: 2em; text-align: center; color: #666;">
        <small>
            Powered by <a href="https://digitalezen.it" target="_blank" style="text-decoration: none;">DigitaleZen.it</a> 🚀
        </small>
    </p>


</div>
