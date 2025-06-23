document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("dz-cf7-chart");
    if (!ctx || typeof Chart === "undefined") return;

    const labels = window.dz_cf7_chart_labels || ["24h", "7 giorni", "28 giorni", "3 mesi", "1 anno"];
    const data = window.dz_cf7_chart_data || [0, 0, 0, 0, 0];

    new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: "Tentativi bloccati",
                data: data,
                backgroundColor: "#008ec2"
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
});
