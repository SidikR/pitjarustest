<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pitjarus Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <?= $this->renderSection('content') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        var selectedArea = <?php echo json_encode(array_column($selectedArea, 'area')); ?>;
        var nilai_area = <?php echo json_encode(array_column($nilai_area, 'nilai')); ?>;

        while (nilai_area.length < selectedArea.length) {
            nilai_area.push(0);
        }

        var ctx = document.getElementById("barChart").getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: selectedArea,
                datasets: [{
                    label: 'Persentase',
                    data: nilai_area,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna latar belakang batang
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna garis batang
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Area'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Nilai'
                        },
                        beginAtZero: true, // Memulai sumbu y dari 0
                        suggestedMax: 100 // Maksimum sumbu y hingga 100
                    }
                },
                plugins: {
                    datalabels: {
                        color: 'rgba(75, 192, 192, 1)',
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value, context) {
                            return value + '%';
                        }
                    }
                }
            }
        });
    </script>
    <script>
        var checkboxes = document.querySelectorAll('#areaDropdown input[type="checkbox"]');

        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
        });

        var selectedAreasCookie = document.cookie.split('; ').find(row => row.startsWith('selectedAreas='));
        if (selectedAreasCookie) {
            var selectedAreasValues = selectedAreasCookie.split('=')[1].split(',');

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectedAreasValues.includes(checkbox.value);
            });
        }
        document.cookie = 'selectedAreas=; expires=Thu, 01 Jan 1970 00:00:00 UTC';

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var selectedValues = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                document.cookie = 'selectedAreas=' + selectedValues.join(',');
            });
        });
    </script>
</body>

</html>