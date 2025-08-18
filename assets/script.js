/**
 * Render spam chart on the dashboard.
 *
 * @package DigitalezenAntispamShield
 */

/* global Chart */

document.addEventListener(
	'DOMContentLoaded',
	function () {
		const ctx = document.getElementById( 'dz-cf7-chart' );
		if ( ! ctx || typeof Chart === 'undefined' ) {
			return;
		}

		const rawData = window.dz_cf7_chart_grouped_data || {};
		const labels  = window.dz_cf7_chart_labels || [];

		// Raccogli tutti i tipi di blocco unici.
		const blockTypes = Array.from(
			new Set(
				Object.values( rawData ).flatMap(
					function ( obj ) {
						return Object.keys( obj );
					}
				)
			)
		);

		// Colori assegnati a ciascun tipo.
		const colors = [
			'#008ec2', '#ffc107', '#dc3545', '#28a745', '#6f42c1', '#fd7e14', '#17a2b8'
		];

		const datasets = blockTypes.map(
			function ( type, index ) {
				return {
					label: type,
					data: labels.map(
						function ( label ) {
							return rawData[ label ] && rawData[ label ][ type ]
								? rawData[ label ][ type ]
								: 0;
						}
					),
				backgroundColor: colors[ index % colors.length ],
				stack: 'spam',
				};
			}
		);

		new Chart(
			ctx.getContext( '2d' ),
			{
				type: 'bar',
				data: {
					labels: labels,
					datasets: datasets,
				},
				options: {
					responsive: true,
					animation: {
						duration: 800,
						easing: 'easeOutQuart',
					},
					scales: {
						x: {
							stacked: true,
							ticks: {
								color: '#333',
								font: { size: 12, family: 'monospace' },
							},
							grid: { color: 'rgba(0,0,0,0.05)' },
						},
						y: {
							stacked: true,
							beginAtZero: true,
							ticks: {
								stepSize: 1,
								color: '#333',
								font: { size: 12, family: 'monospace' },
							},
							grid: { color: 'rgba(0,0,0,0.05)' },
						},
					},
					plugins: {
						legend: {
							position: 'bottom',
							labels: {
								color: '#444',
								font: { size: 12, family: 'monospace' },
								padding: 10,
							},
						},
						tooltip: {
							backgroundColor: '#222',
							titleColor: '#fff',
							bodyColor: '#fff',
							borderColor: '#00c2a6',
							borderWidth: 1,
						},
					},
				}
			}
		);
	}
);
