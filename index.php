<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Eskul Band - SMKN 1 LEMAHABANG</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .container {
            width: 100%;
            max-width: 800px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        
        header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        header h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }
        
        header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .content {
            padding: 30px;
        }
        
        .attendance-form {
            margin-bottom: 30px;
        }
        
        .form-title {
            text-align: center;
            margin-bottom: 25px;
            color: #2575fc;
            font-size: 1.8rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 14px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            border-color: #2575fc;
            outline: none;
        }
        
        .btn {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            display: block;
            width: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 15px rgba(37, 117, 252, 0.3);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 117, 252, 0.4);
        }
        
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .attendance-list {
            margin-top: 30px;
            border-top: 2px solid #eee;
            padding-top: 20px;
        }
        
        .attendance-list h3 {
            text-align: center;
            margin-bottom: 15px;
            color: #2575fc;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        table, th, td {
            border: 1px solid #ddd;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: 600;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            margin-top: 30px;
            color: white;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .container {
                border-radius: 10px;
            }
            
            header h1 {
                font-size: 1.8rem;
            }
            
            .content {
                padding: 20px;
            }
            
            table {
                font-size: 14px;
            }
            
            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Ekstrakurikuler Band</h1>
            <p>SMKN 1 LEMAHABANG - Sistem Absensi Online</p>
        </header>
        
        <div class="content">
            <div class="attendance-form">
                <h2 class="form-title">Form Absensi</h2>
                
                <?php
                // Fungsi untuk menyimpan data absensi ke file JSON
                function saveAttendance($data) {
                    $filename = 'attendance.json';
                    $attendance = [];
                    
                    // Jika file sudah ada, baca data yang sudah tersimpan
                    if (file_exists($filename)) {
                        $jsonData = file_get_contents($filename);
                        $attendance = json_decode($jsonData, true);
                    }
                    
                    // Tambahkan data baru
                    $attendance[] = $data;
                    
                    // Simpan ke file
                    file_put_contents($filename, json_encode($attendance, JSON_PRETTY_PRINT));
                }
                
                // Proses form jika disubmit
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $name = $_POST['name'] ?? '';
                    $class = $_POST['class'] ?? '';
                    $instrument = $_POST['instrument'] ?? '';
                    $date = $_POST['date'] ?? '';
                    $status = $_POST['status'] ?? '';
                    
                    // Validasi sederhana
                    if (!empty($name) && !empty($class) && !empty($instrument) && !empty($date) && !empty($status)) {
                        $attendanceData = [
                            'name' => $name,
                            'class' => $class,
                            'instrument' => $instrument,
                            'date' => $date,
                            'status' => $status,
                            'timestamp' => date('Y-m-d H:i:s')
                        ];
                        
                        saveAttendance($attendanceData);
                        echo '<div class="message success">Absensi berhasil disimpan! Terima kasih.</div>';
                    } else {
                        echo '<div class="message error">Harap isi semua field!</div>';
                    }
                }
                ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="class">Kelas</label>
                        <input type="text" id="class" name="class" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="instrument">Instrumen</label>
                        <select id="instrument" name="instrument" required>
                            <option value="">Pilih Instrumen</option>
                            <option value="Vokal">Vokal</option>
                            <option value="Gitar">Gitar</option>
                            <option value="Bass">Bass</option>
                            <option value="Drum">Drum</option>
                            <option value="Keyboard">Keyboard</option>
                            <option value="Saxophone">Saxophone</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status Kehadiran</label>
                        <select id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Submit Absensi</button>
                </form>
            </div>
            
            <div class="attendance-list">
                <h3>Daftar Absensi Terbaru</h3>
                <?php
                // Menampilkan data absensi
                if (file_exists('attendance.json')) {
                    $jsonData = file_get_contents('attendance.json');
                    $attendance = json_decode($jsonData, true);
                    
                    if (!empty($attendance)) {
                        echo '<table>';
                        echo '<tr><th>Nama</th><th>Kelas</th><th>Instrumen</th><th>Tanggal</th><th>Status</th></tr>';
                        
                        // Tampilkan 5 data terbaru
                        $recentAttendance = array_slice(array_reverse($attendance), 0, 5);
                        
                        foreach ($recentAttendance as $entry) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($entry['name']) . '</td>';
                            echo '<td>' . htmlspecialchars($entry['class']) . '</td>';
                            echo '<td>' . htmlspecialchars($entry['instrument']) . '</td>';
                            echo '<td>' . htmlspecialchars($entry['date']) . '</td>';
                            echo '<td>' . htmlspecialchars($entry['status']) . '</td>';
                            echo '</tr>';
                        }
                        
                        echo '</table>';
                    } else {
                        echo '<p class="message">Belum ada data absensi.</p>';
                    }
                } else {
                    echo '<p class="message">Belum ada data absensi.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2025 Ekstrakurikuler Band - SMKN 1 LEMAHABANG</p>
    </footer>
    
    <script>
        // Set tanggal hari ini sebagai default
        document.getElementById('date').valueAsDate = new Date();
    </script>
</body>
</html>