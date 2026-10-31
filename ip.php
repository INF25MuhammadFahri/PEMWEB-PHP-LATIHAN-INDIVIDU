<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kalkulator IPS</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; color: #222; }
        table { border-collapse: collapse; width: 100%; max-width: 800px; }
        th, td { border: 1px solid #999; padding: 8px 12px; text-align: center; }
        th { background: #2c3e50; color: #fff; }
        td.kiri { text-align: left; }
        tr.mengulang { background: #f8d7da; color: #c0392b; font-weight: bold; }
        .ringkasan { margin-top: 20px; max-width: 800px; padding: 15px; border: 1px solid #999; background: #f4f6f8; }
        .ringkasan p { margin: 6px 0; }
    </style>
</head>
<body>
    <h2>Daftar Nilai Matkul</h2>

    <?php
    // 1. Buat array multidimensi $matkul berisi minimal 5 mata kuliah dengan key: nama, sks, dan nilai (skala 0-100)
    $matkul = [
        ["nama" => "Pemrograman Web",   "sks" => 3, "nilai" => 88],
        ["nama" => "Sistem Basis Data",        "sks" => 3, "nilai" => 76],
        ["nama" => "Sistem Operasi",    "sks" => 4, "nilai" => 64],
        ["nama" => "Jaringan Komputer", "sks" => 3, "nilai" => 99],
        ["nama" => "Internet of Things",        "sks" => 2, "nilai" => 45],
    ];

    // 2. Buat fungsi helper hitungBobot($nilai) yang mengembalikan array berisi huruf (A, B, C, D, E) dan bobot (4.0, 3.0, 2.0, 1.0, 0.0)
    function hitungBobot($nilai)
    {
        if ($nilai >= 80) {
            return ["huruf" => "A", "bobot" => 4.0];
        } elseif ($nilai >= 70) {
            return ["huruf" => "B", "bobot" => 3.0];
        } elseif ($nilai >= 60) {
            return ["huruf" => "C", "bobot" => 2.0];
        } elseif ($nilai >= 50) {
            return ["huruf" => "D", "bobot" => 1.0];
        }
        return ["huruf" => "E", "bobot" => 0.0];
    }

    // 3. Tampilkan nama matkul, SKS, nilai angka, nilai huruf, dan status (LULUS jika bobot >= 2.0, atau MENGULANG jika di bawahnya)
    $totalSks  = 0;
    $totalMutu = 0;

    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>No</th>";
    echo "<th>Mata Kuliah</th>";
    echo "<th>SKS</th>";
    echo "<th>Nilai Angka</th>";
    echo "<th>Nilai Huruf</th>";
    echo "<th>Status</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($matkul as $i => $mk) {
        $hasil  = hitungBobot($mk["nilai"]);
        $status = ($hasil["bobot"] >= 2.0) ? "LULUS" : "MENGULANG";

        // 4. Beri warna merah pada baris mata kuliah yang mendapat status MENGULANG
        $kelas = ($status === "MENGULANG") ? "mengulang" : "";

        // Akumulasi untuk perhitungan IPS
        $totalSks  += $mk["sks"];
        $totalMutu += $mk["sks"] * $hasil["bobot"];

        echo "<tr class='$kelas'>";
        echo "<td>" . ($i + 1) . "</td>";
        echo "<td class='kiri'>" . htmlspecialchars($mk["nama"]) . "</td>";
        echo "<td>" . $mk["sks"] . "</td>";
        echo "<td>" . $mk["nilai"] . "</td>";
        echo "<td>" . $hasil["huruf"] . "</td>";
        echo "<td>" . $status . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";

    // Hitung dan tampilkan Ringkasan IPS di bawah tabel
    $ips = ($totalSks > 0) ? $totalMutu / $totalSks : 0;

    // 5. Tampilkan batas maksimal SKS semester depan (IPS >= 3.00 boleh ambil 24 SKS, di bawah itu maksimal 20 SKS)
    $maksSks = ($ips >= 3.00) ? 24 : 20;

    echo "<div class='ringkasan'>";
    echo "<h3>Ringkasan IPS</h3>";
    echo "<p>Total SKS: <strong>" . $totalSks . "</strong></p>";
    echo "<p>Total Mutu (SKS x Bobot): <strong>" . number_format($totalMutu, 2) . "</strong></p>";
    echo "<p>IPS: <strong>" . number_format($ips, 2) . "</strong></p>";
    echo "<p>Batas maksimal SKS semester depan: <strong>" . $maksSks . " SKS</strong></p>";
    echo "</div>";
    ?>
</body>
</html>