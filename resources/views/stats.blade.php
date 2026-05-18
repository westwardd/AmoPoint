<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visit Stats</title>
    <style>
        body {
            font-family: "Georgia", "Times New Roman", serif;
            background: radial-gradient(circle at top, #f6f3ea, #ebe4d6);
            color: #1f2937;
            margin: 0;
            padding: 32px;
        }
        h1 {
            margin: 0 0 8px 0;
            font-size: 28px;
        }
        .subtitle {
            color: #6b7280;
            margin-bottom: 24px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
        }
        .card {
            background: #fffaf0;
            border: 1px solid #e2d8c3;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 8px 24px rgba(55, 43, 20, 0.08);
        }
        canvas {
            width: 100% !important;
            height: 320px !important;
        }
    </style>
</head>
<body>
    <h1>Visit statistics</h1>
    <div class="subtitle">Unique visits since {{ $since->format('Y-m-d H:i') }}</div>

    <div class="grid">
        <div class="card">
            <h3>Unique visits per hour</h3>
            <canvas id="hourlyChart"></canvas>
        </div>
        <div class="card">
            <h3>Unique visits by city</h3>
            <canvas id="cityChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        const hourLabels = @json($hourLabels);
        const hourCounts = @json($hourCounts);
        const cityLabels = @json($cityLabels);
        const cityCounts = @json($cityCounts);

        new Chart(document.getElementById('hourlyChart'), {
            type: 'bar',
            data: {
                labels: hourLabels,
                datasets: [{
                    label: 'Unique visits',
                    data: hourCounts,
                    backgroundColor: '#d97706'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { title: { display: true, text: 'Hour' } },
                    y: { title: { display: true, text: 'Unique visits' }, beginAtZero: true }
                }
            }
        });

        new Chart(document.getElementById('cityChart'), {
            type: 'pie',
            data: {
                labels: cityLabels,
                datasets: [{
                    data: cityCounts,
                    backgroundColor: [
                        '#c2410c', '#ea580c', '#f59e0b', '#facc15', '#84cc16',
                        '#22c55e', '#14b8a6', '#06b6d4', '#0ea5e9', '#3b82f6'
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>
</html>
