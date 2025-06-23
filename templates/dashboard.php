<?php
/**
 * File Name: dashboard.php
 * Plugin Name: DigitaleZen CF7 AntiSpam Shield
 * Autore: DigitaleZen
 * Licenza: MIT
 */

// Sicurezza base
if (!current_user_can('manage_options')) return;

$log_email = get_option('dz_cf7_log_email', get_option('admin_email'));
$upload_dir = wp_upload_dir()['basedir'] . '/cf7-logs';
$upload_url = wp_upload_dir()['baseurl'] . '/cf7-logs';

$log_file = $upload_url . '/cf7-spam-log.csv';
$blacklist_file = $upload_url . '/cf7-blacklist.json';
?>

<div class="wrap" style="max-width: 800px;">
	<h1 style="margin-bottom: 0;">
	    <?php echo esc_html__('🛡️ DigitaleZen CF7 AntiSpam Shield', 'digitalezen-cf7'); ?>
	</h1>
	<p style="margin-top: 4px;">
	    <?php echo esc_html__('Protezione intelligente per Contact Form 7', 'digitalezen-cf7'); ?>
	</p>

	<hr>

	<form method="POST">
	    <?php wp_nonce_field('dz_cf7_save_settings'); ?>

	    <h2><?php esc_html_e('📬 Impostazioni email report', 'digitalezen-cf7'); ?></h2>
	    <p>
	        <?php
	        echo esc_html__(
	            'Ogni lunedì alle 2:00 verrà inviato il report dei tentativi di spam bloccati.',
	            'digitalezen-cf7'
	        );
	        ?>
	    </p>

	    <table class="form-table">
	        <tr>
	            <th scope="row">
	                <label for="dz_cf7_log_email">
	                    <?php echo esc_html__('Email di destinazione', 'digitalezen-cf7'); ?>
	                </label>
	            </th>
	            <td>
	                <input type="email" id="dz_cf7_log_email" name="dz_cf7_log_email"
	                       value="<?php echo esc_attr($log_email); ?>" class="regular-text">
	            </td>
	        </tr>
	    </table>

	    <p>
	        <input type="submit" name="dz_cf7_settings_submit" class="button button-primary"
	               value="<?php esc_attr_e('Salva impostazioni', 'digitalezen-cf7'); ?>">
	    </p>
	</form>

	<hr>

	<h2><?php esc_html_e('🔧 Shortcode da inserire nei tuoi form CF7', 'digitalezen-cf7'); ?></h2>
	<ul style="margin-left: 1em;">
	    <li><code>[honeypot spamcheck]</code></li>
	    <li><code>[hidden timestamp default:get]</code></li>
	    <li><code>[hidden form-token default:get]</code></li>
	</ul>

	<hr>

	<h2><?php esc_html_e('📁 File generati dal plugin', 'digitalezen-cf7'); ?></h2>
	<table class="widefat striped" style="margin-bottom: 2em;">
	    <thead>
	        <tr>
	            <th><?php esc_html_e('File', 'digitalezen-cf7'); ?></th>
	            <th><?php esc_html_e('Descrizione', 'digitalezen-cf7'); ?></th>
	            <th><?php esc_html_e('Azioni', 'digitalezen-cf7'); ?></th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr>
	            <td><code>cf7-spam-log.csv</code></td>
	            <td>
	                <?php
	                echo esc_html__(
	                    'Log dei tentativi bloccati (data, email, IP, motivo, trigger)',
	                    'digitalezen-cf7'
	                );
	                ?>
	            </td>
	            <td>
	                <a href="<?php echo esc_url($log_file); ?>" class="button button-secondary" download>
	                    📥 <?php esc_html_e('Download', 'digitalezen-cf7'); ?>
	                </a>
	            </td>
	        </tr>
	        <tr>
	            <td><code>cf7-blacklist.json</code></td>
	            <td>
	                <?php
	                echo esc_html__(
	                    'Blacklist aggiornata da App Script (IP, email, domini, ecc.)',
	                    'digitalezen-cf7'
	                );
	                ?>
	            </td>
	            <td>
	                <a
	                    href="<?php
	                        echo esc_url(
	                            admin_url(
	                                'admin-ajax.php?action=dz_cf7_view_json&f=cf7-blacklist.json'
	                            )
	                        );
	                    ?>"
	                    class="button button-secondary" target="_blank">
	                    👁️ <?php esc_html_e('Visualizza', 'digitalezen-cf7'); ?>
	                </a>
	                <a href="<?php echo esc_url($blacklist_file); ?>" class="button" download>
	                    📥 <?php esc_html_e('Download', 'digitalezen-cf7'); ?>
	                </a>
	            </td>
	        </tr>
	        <tr>
	            <td><code>block-ip.txt</code></td>
	            <td>
	                <?php
	                echo esc_html__(
	                    'IP bloccati temporaneamente (blocco soft, durata 10 minuti)',
	                    'digitalezen-cf7'
	                );
	                ?>
	            </td>
	            <td>
	                <a
	                    href="<?php echo esc_url(content_url('/block-ip.txt')); ?>"
	                    class="button button-secondary" target="_blank">
	                    👁️ <?php esc_html_e('Visualizza', 'digitalezen-cf7'); ?>
	                </a>
	                <a href="<?php echo esc_url(content_url('/block-ip.txt')); ?>" class="button" download>
	                    📥 <?php esc_html_e('Download', 'digitalezen-cf7'); ?>
	                </a>
	            </td>
	        </tr>
	        <tr>
	            <td><code>ip-attempts.json</code></td>
	            <td>
	                <?php echo esc_html__('Storico tentativi spam per IP', 'digitalezen-cf7'); ?>
	            </td>
	            <td>
	                <a
	                    href="<?php
	                        echo esc_url(
	                            admin_url(
	                                'admin-ajax.php?action=dz_cf7_view_json&f=ip-attempts.json'
	                            )
	                        );
	                    ?>"
	                    class="button button-secondary" target="_blank">
	                    👁️ <?php esc_html_e('Visualizza', 'digitalezen-cf7'); ?>
	                </a>
	                <a href="<?php echo esc_url(content_url('/ip-attempts.json')); ?>" class="button" download>
	                    📥 <?php esc_html_e('Download', 'digitalezen-cf7'); ?>
	                </a>
	            </td>
	        </tr>
	        <tr>
	            <td><code>email-attempts.json</code></td>
	            <td>
	                <?php echo esc_html__('Storico tentativi spam per email', 'digitalezen-cf7'); ?>
	            </td>
	            <td>
	                <a
	                    href="<?php
	                        echo esc_url(
	                            admin_url(
	                                'admin-ajax.php?action=dz_cf7_view_json&f=email-attempts.json'
	                            )
	                        );
	                    ?>"
	                    class="button button-secondary" target="_blank">
	                    👁️ <?php esc_html_e('Visualizza', 'digitalezen-cf7'); ?>
	                </a>
	                <a href="<?php echo esc_url(content_url('/email-attempts.json')); ?>" class="button" download>
	                    📥 <?php esc_html_e('Download', 'digitalezen-cf7'); ?>
	                </a>
	            </td>
	        </tr>
	    </tbody>
	</table>


	<hr>

	<h2><?php esc_html_e('📊 Report spam bloccati (dati reali)', 'digitalezen-cf7'); ?></h2>

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
	    esc_html__('24h', 'digitalezen-cf7')      => dz_cf7_count_spam_by_range(1440),
	    esc_html__('7 giorni', 'digitalezen-cf7') => dz_cf7_count_spam_by_range(10080),
	    esc_html__('28 giorni', 'digitalezen-cf7') => dz_cf7_count_spam_by_range(40320),
	    esc_html__('3 mesi', 'digitalezen-cf7')   => dz_cf7_count_spam_by_range(129600),
	    esc_html__('1 anno', 'digitalezen-cf7')   => dz_cf7_count_spam_by_range(525600),
	];

	// Passaggio dati a JS
	echo '<script>window.dz_cf7_chart_data = ' . json_encode(array_values($data_report)) . ';</script>';
	echo '<script>window.dz_cf7_chart_labels = ' . json_encode(array_keys($data_report)) . ';</script>';
	?>

	<h3><?php esc_html_e('🧾 Ultimi tentativi bloccati', 'digitalezen-cf7'); ?></h3>
	<table class="widefat striped" style="max-width: 100%; margin-top: 1em;">
	    <thead>
	        <tr>
	            <th><?php esc_html_e('Data', 'digitalezen-cf7'); ?></th>
	            <th><?php esc_html_e('Email', 'digitalezen-cf7'); ?></th>
	            <th><?php esc_html_e('IP', 'digitalezen-cf7'); ?></th>
	            <th><?php esc_html_e('Motivo', 'digitalezen-cf7'); ?></th>
	            <th><?php esc_html_e('Trigger', 'digitalezen-cf7'); ?></th>
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
	        <?php
	        echo wp_kses_post(
	            __(
	                'Powered by <a href="https://digitalezen.it" target="_blank" '
	                . 'style="text-decoration: none;">DigitaleZen.it</a> '
	                . '🚀',
	                'digitalezen-cf7'
	            )
	        );
	        ?>
	    </small>
	</p>


</div>
