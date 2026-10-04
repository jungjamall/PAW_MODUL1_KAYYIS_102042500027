<?php
// Inisialisasi variabel error & data pendaftar
$errors = [];
$success = false;

$nama = "";
$whatsapp = "";
$email = "";
$matakuliah = "";
$motivasi = "";

// Cek apakah form telah disubmit via method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil data dari form dan lakukan sanitasi dasar
    $nama = trim($_POST['nama'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $matakuliah = trim($_POST['matakuliah'] ?? '');
    $motivasi = trim($_POST['motivasi'] ?? '');

    // 1. Validasi Input Tidak Boleh Kosong
    if (empty($nama)) {
        $errors['nama'] = "Nama lengkap wajib diisi.";
    }
    if (empty($whatsapp)) {
        $errors['whatsapp'] = "Nomor WhatsApp wajib diisi.";
    }
    if (empty($email)) {
        $errors['email'] = "Email institusi wajib diisi.";
    }
    if (empty($matakuliah)) {
        $errors['matakuliah'] = "Pilihan mata kuliah praktikum wajib dipilih.";
    }
    if (empty($motivasi)) {
        $errors['motivasi'] = "Motivasi mendaftar wajib diisi.";
    }

    // 2. Validasi Format Data (Backend Validation)
    if (empty($errors)) {
        // Validasi Nama Lengkap (Hanya huruf dan spasi)
        if (!preg_match("/^[a-zA-Z\s]+$/", $nama)) {
            $errors['nama'] = "Nama lengkap hanya boleh berisi huruf.";
        }

        // Validasi Nomor WhatsApp (Diawali '0' atau '62' dan berupa angka)
        if (!preg_match("/^(0|62)[0-9]+$/", $whatsapp)) {
            $errors['whatsapp'] = "Nomor WhatsApp harus diawali angka '0' atau '62'.";
        }

        // Validasi Email Institusi (Format Email Valid)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Format email institusi tidak valid.";
        }
    }

    // Jika tidak ada error sama sekali, pendaftaran berhasil
    if (empty($errors)) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Asisten Praktikum - EAD Lab</title>
    <!-- Tailwind CSS CDN untuk styling yang cepat dan responsif -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8 my-8">
        <!-- Header Logo & Title -->
        <div class="text-center mb-6">
            <div class="flex justify-center items-center gap-2 mb-2">
                <span class="font-bold text-indigo-600 text-xl">EAD</span>
                <span class="text-xs bg-indigo-100 text-indigo-700 font-semibold px-2 py-0.5 rounded">LAB</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Pendaftaran Asisten Praktikum</h1>
            <p class="text-xs text-gray-500 mt-1">Laboratorium Enterprise Application Development</p>
        </div>

        <?php if (!$success): ?>
            <!-- Alert Pesan Gagal Secara Umum -->
            <?php if (!empty($errors)): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded text-sm mb-6">
                    <p class="font-bold">Pendaftaran gagal!</p>
                    <p>Harap periksa data yang anda isi.</p>
                </div>
            <?php endif; ?>

            <!-- Form Pendaftaran -->
            <form action="" method="POST" class="space-y-4">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>" 
                           placeholder="Masukkan nama lengkap"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none <?= isset($errors['nama']) ? 'border-red-500' : 'border-gray-300' ?>">
                    <?php if (isset($errors['nama'])): ?>
                        <p class="text-red-500 text-xs mt-1">* <?= $errors['nama'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Nomor WhatsApp -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="whatsapp" value="<?= htmlspecialchars($whatsapp) ?>" 
                           placeholder="Contoh: 081234567890"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none <?= isset($errors['whatsapp']) ? 'border-red-500' : 'border-gray-300' ?>">
                    <?php if (isset($errors['whatsapp'])): ?>
                        <p class="text-red-500 text-xs mt-1">* <?= $errors['whatsapp'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Email Institusi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Institusi <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" 
                           placeholder="Contoh: student@telkomuniversity.ac.id"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none <?= isset($errors['email']) ? 'border-red-500' : 'border-gray-300' ?>">
                    <?php if (isset($errors['email'])): ?>
                        <p class="text-red-500 text-xs mt-1">* <?= $errors['email'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Pilihan Mata Kuliah Praktikum -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pilihan Mata Kuliah Praktikum <span class="text-red-500">*</span></label>
                    <select name="matakuliah" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none <?= isset($errors['matakuliah']) ? 'border-red-500' : 'border-gray-300' ?>">
                        <option value="">-- Pilih Mata Kuliah --</option>
                        <option value="Pengembangan Aplikasi Website" <?= $matakuliah == "Pengembangan Aplikasi Website" ? 'selected' : '' ?>>Pengembangan Aplikasi Website</option>
                        <option value="Basis Data" <?= $matakuliah == "Basis Data" ? 'selected' : '' ?>>Basis Data</option>
                        <option value="Pemrograman Berorientasi Objek" <?= $matakuliah == "Pemrograman Berorientasi Objek" ? 'selected' : '' ?>>Pemrograman Berorientasi Objek</option>
                        <option value="Jaringan Komputer" <?= $matakuliah == "Jaringan Komputer" ? 'selected' : '' ?>>Jaringan Komputer</option>
                    </select>
                    <?php if (isset($errors['matakuliah'])): ?>
                        <p class="text-red-500 text-xs mt-1">* <?= $errors['matakuliah'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Motivasi Mendaftar -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Motivasi Mendaftar <span class="text-red-500">*</span></label>
                    <textarea name="motivasi" rows="3" 
                              placeholder="Jelaskan motivasi anda..."
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none <?= isset($errors['motivasi']) ? 'border-red-500' : 'border-gray-300' ?>"><?= htmlspecialchars($motivasi) ?></textarea>
                    <?php if (isset($errors['motivasi'])): ?>
                        <p class="text-red-500 text-xs mt-1">* <?= $errors['motivasi'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Tombol Submit & Reset -->
                <div class="pt-2 space-y-2">
                    <button type="submit" 
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg transition duration-200 shadow-md">
                        Daftar Sekarang
                    </button>
                    <a href="soal.php" 
                       class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium py-2 rounded-lg border border-gray-300 transition duration-200">
                        Lihat Data Pendaftar
                    </a>
                </div>
            </form>

        <?php else: ?>
            <!-- Tampilan Kartu Registrasi ketika Sukses -->
            <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-6 mb-6">
                <div class="flex items-center justify-between border-b border-indigo-200 pb-3 mb-4">
                    <h2 class="text-lg font-bold text-indigo-900">Kartu Registrasi</h2>
                    <span class="bg-green-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full">TERDAFTAR</span>
                </div>

                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500 block text-xs">Nama Lengkap</span>
                        <span class="font-bold text-gray-800 text-base"><?= htmlspecialchars($nama) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Nomor WhatsApp</span>
                        <span class="font-medium text-gray-800"><?= htmlspecialchars($whatsapp) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Email Institusi</span>
                        <span class="font-medium text-gray-800"><?= htmlspecialchars($email) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Mata Kuliah Praktikum</span>
                        <span class="font-medium text-indigo-700 font-semibold"><?= htmlspecialchars($matakuliah) ?></span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Motivasi</span>
                        <p class="text-gray-700 italic bg-white p-3 rounded-lg border border-indigo-100 mt-1"><?= nl2br(htmlspecialchars($motivasi)) ?></p>
                    </div>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <a href="soal.php" 
               class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                Kembali ke Formulir
            </a>
        <?php endif; ?>

    </div>

</body>
</html>