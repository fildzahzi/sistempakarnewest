<?php
// Koneksi ke database
$servername = "localhost";
$username = "fildzahzata";
$password = "fildzaya";
$dbname = "spnaivebayes1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data varietas dan penyakit
$sql = "SELECT varietas, penyakit FROM bayes_konsultasi";
$result = $conn->query($sql);

$varietasData = [];
$penyakitData = [];

// Hitung varietas dan penyakit
while ($row = $result->fetch_assoc()) {
    $varietasData[] = $row['varietas'];
    $penyakitData[] = $row['penyakit'];
}

// Menghitung jumlah orang yang sudah konsultasi
$sql_count = "SELECT COUNT(id) as total_konsultasi FROM bayes_konsultasi";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_konsultasi = $row_count['total_konsultasi'];

// Query untuk mengambil gejala terbanyak dari tabel bayes_konsultasi_detail
$sql_gejala = "SELECT g.nama_gejala, COUNT(bkd.kode_gejala) as jumlah_gejala
               FROM bayes_konsultasi_detail bkd
               JOIN bayes_gejala g ON bkd.kode_gejala = g.kode_gejala
               GROUP BY g.nama_gejala
               ORDER BY jumlah_gejala DESC";

$result_gejala = $conn->query($sql_gejala);

$gejalaLabels = [];
$gejalaValues = [];

while ($row = $result_gejala->fetch_assoc()) {
    $gejalaLabels[] = $row['nama_gejala'];
    $gejalaValues[] = $row['jumlah_gejala'];
}

// Ambil 5 gejala terbanyak
$topGejalaCount = 5;
$gejalaLabels = array_slice($gejalaLabels, 0, $topGejalaCount);
$gejalaValues = array_slice($gejalaValues, 0, $topGejalaCount);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <style>
        .homeadmin {
            justify-content: space-between;
            align-items: center;
        }

        .kartu {
            display: flex;

        }

        .kartu .panel-index h3 {
            text-align: center;
            padding: 10px;
            margin: 0;
        }

        .kartu .panel-index h3 span {
            font-weight: bold;
        }

        .panel-index {
            background-color: var(--white-color);
            margin-left: 30px;
            margin-bottom: 30px;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1)
        }

        canvas {
            margin: 60px;
        }
    </style> -->
</head>

<body>

    <!-- About Section -->
    <div class="homeadmin">
        <div class="page">
            <h1>Selamat datang di Sistem Pakar untuk Admin</h1>
            <p>Selamat datang di Halaman Admin Sistem Pakar Diagnosa Penyakit Tanaman Tebu. Di sini, Anda dapat mengelola data penyakit, gejala, aturan Naive Bayes, dan memantau konsultasi pengguna.</p>
            <p>Sebagai admin, Anda dapat memperbarui informasi secara real-time, menyesuaikan aturan diagnostik, dan memastikan sistem berfungsi optimal untuk memberikan diagnosa yang akurat.</p>
        </div>
        <div class="kartu">
            <div class="panel-index">
                <!-- Menampilkan total jumlah konsultasi -->
                <h3>Jumlah Pengguna : <br>
                    <br>
                    <span><?php echo $total_konsultasi; ?></span>
                    <br>
                    <p> </p>
                </h3>
            </div>
            <div class="panel-index">
                <h3>Grafik Gejala Terbanyak</h3>
                <canvas id="gejalaChart" width="700" height="200"></canvas>
            </div>
        </div>

        <div class="kartu">
            <div class="panel-index">
                <h3>Grafik Jumlah Varietas</h3>
                <!-- Grafik Varietas -->
                <canvas id="varietasChart" width="400" height="200"></canvas>
            </div>

            <div class="panel-index">
                <h3>Grafik Jumlah Penyakit</h3>
                <!-- Grafik Penyakit -->
                <canvas id="penyakitChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Cek jika data ada
        console.log("Cek Data PHP ke JS");
        console.log("varietasData:", <?php echo json_encode($varietasData); ?>);
        console.log("penyakitData:", <?php echo json_encode($penyakitData); ?>);
        console.log("gejalaLabels:", <?php echo json_encode($gejalaLabels); ?>);
        console.log("gejalaValues:", <?php echo json_encode($gejalaValues); ?>);

        // Konversi data PHP ke format JSON
        var varietasData = <?php echo json_encode(array_count_values($varietasData)); ?>;
        var penyakitData = <?php echo json_encode(array_count_values($penyakitData)); ?>;
        var gejalaLabels = <?php echo json_encode($gejalaLabels); ?>;
        var gejalaValues = <?php echo json_encode($gejalaValues); ?>;

        // Ekstrak label dan data untuk grafik Varietas
        var varietasLabels = Object.keys(varietasData);
        var varietasValues = Object.values(varietasData);

        // Ekstrak label dan data untuk grafik Penyakit
        var penyakitLabels = Object.keys(penyakitData);
        var penyakitValues = Object.values(penyakitData);

        // Membuat diagram batang untuk Varietas
        var ctxVarietas = document.getElementById('varietasChart').getContext('2d');
        var varietasChart = new Chart(ctxVarietas, {
            type: 'bar', // Menggunakan diagram batang
            data: {
                labels: varietasLabels,
                datasets: [{
                    label: 'Jumlah Varietas',
                    data: varietasValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        ticks: {
                            font: {
                                size: function(context) {
                                    // Adjust the font size for the x-axis labels based on the chart width
                                    let width = context.chart.width;
                                    return width < 500 ? 8 : 10; // Smaller font size for smaller screens
                                }
                            },
                            // Rotate the labels for better readability on smaller screens
                            maxRotation: 45,
                            minRotation: 0,
                        }
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: (context) => {
                                    let width = context.chart.width;
                                    return width < 500 ? 8 : 10;
                                }
                            }
                        }
                    }
                }
            }
        });

        // Membuat diagram pie untuk Penyakit
        var ctxPenyakit = document.getElementById('penyakitChart').getContext('2d');
        var penyakitChart = new Chart(ctxPenyakit, {
            type: 'pie', // Menggunakan diagram pie
            data: {
                labels: penyakitLabels,
                datasets: [{
                    label: 'Jumlah Penyakit',
                    data: penyakitValues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: (context) => {
                                    let width = context.chart.width;
                                    return width < 500 ? 8 : 10;
                                }
                            }
                        }
                    }

                }
            }
        });

        // Membuat diagram batang horizontal untuk gejala
        var ctxGejala = document.getElementById('gejalaChart').getContext('2d');
        var gejalaChart = new Chart(ctxGejala, {
            type: 'bar',
            data: {
                labels: gejalaLabels,
                datasets: [{
                    label: 'Jumlah Gejala',
                    data: gejalaValues,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', // Membuat diagram horizontal
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        ticks: {
                            font: {
                                size: function(context) {
                                    // Menyesuaikan ukuran font pada sumbu y berdasarkan lebar chart
                                    let width = context.chart.width;
                                    return width < 500 ? 6 : 8; // Lebih kecil untuk layar kecil
                                }
                            }
                        }
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: (context) => {
                                    let width = context.chart.width;
                                    return width < 500 ? 8 : 10;
                                }
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>