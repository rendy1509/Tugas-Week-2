<?php

function e($teks) {
    return htmlspecialchars($teks, ENT_QUOTES, 'UTF-8');
}

$nama = $email = $jk = $alamat = $telepon = "";
$errors = [];
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submitted = true;

    $nama    = trim($_POST["nama"] ?? "");
    $email   = trim($_POST["email"] ?? "");
    $jk      = $_POST["jenis_kelamin"] ?? "";
    $alamat  = trim($_POST["alamat"] ?? "");
    $telepon = trim($_POST["telepon"] ?? "");

    if ($nama === "")   $errors[] = "Nama wajib diisi.";
    if ($email === "")  $errors[] = "Email wajib diisi.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Format email tidak valid.";
    if (!in_array($jk, ["Laki-laki", "Perempuan"], true)) $errors[] = "Jenis kelamin wajib dipilih.";
    if ($alamat === "") $errors[] = "Alamat wajib diisi.";
    if ($telepon === "") $errors[] = "Nomor telepon wajib diisi.";
    elseif (!preg_match('/^[0-9+\-\s]{8,15}$/', $telepon)) $errors[] = "Nomor telepon hanya boleh angka (8-15 karakter).";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Data Pengguna</title>
  <style>
    body { font-family: "Segoe UI", Arial, sans-serif; background: #f3f6fb; margin: 0; color: #1f2937; }
    .wrap { max-width: 520px; margin: 40px auto; padding: 0 16px; }
    .card { background: #fff; border-radius: 12px; padding: 24px 28px; box-shadow: 0 2px 10px rgba(0,0,0,.08); margin-bottom: 20px; }
    h1 { margin-top: 0; color: #1e3a8a; font-size: 1.5rem; }
    label { display: block; font-weight: 600; margin: 14px 0 4px; }
    input[type=text], input[type=email], input[type=tel], textarea {
      width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font: inherit;
    }
    .radio label { display: inline; font-weight: 400; margin-right: 16px; }
    button { margin-top: 20px; background: #1e3a8a; color: #fff; border: 0; padding: 11px 24px; border-radius: 8px; font: inherit; cursor: pointer; }
    button:hover { background: #172b69; }
    .error { background: #fee2e2; color: #991b1b; border-radius: 8px; padding: 10px 16px; }
    .error ul { margin: 0; padding-left: 18px; }
    table { width: 100%; border-collapse: collapse; }
    td { padding: 8px 6px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
    td:first-child { width: 38%; font-weight: 600; color: #475569; }
  </style>
</head>
<body>
<div class="wrap">

  <?php if ($submitted && empty($errors)): ?>
    <div class="card">
      <h1>Data yang Anda Kirim</h1>
      <table>
        <tr><td>Nama</td><td><?= e($nama) ?></td></tr>
        <tr><td>Email</td><td><?= e($email) ?></td></tr>
        <tr><td>Jenis Kelamin</td><td><?= e($jk) ?></td></tr>
        <tr><td>Alamat</td><td><?= nl2br(e($alamat)) ?></td></tr>
        <tr><td>Nomor Telepon</td><td><?= e($telepon) ?></td></tr>
      </table>
      <p><a href="index.php">&laquo; Isi form lagi</a></p>
    </div>
  <?php else: ?>
    <div class="card">
      <h1>Form Data Pengguna</h1>

      <?php if (!empty($errors)): ?>
        <div class="error">
          <ul><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul>
        </div>
      <?php endif; ?>

      <form action="index.php" method="POST">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?= e($nama) ?>" placeholder="Nama lengkap">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" placeholder="nama@email.com">

        <label>Jenis Kelamin</label>
        <div class="radio">
          <input type="radio" id="lk" name="jenis_kelamin" value="Laki-laki" <?= $jk === "Laki-laki" ? "checked" : "" ?>>
          <label for="lk">Laki-laki</label>
          <input type="radio" id="pr" name="jenis_kelamin" value="Perempuan" <?= $jk === "Perempuan" ? "checked" : "" ?>>
          <label for="pr">Perempuan</label>
        </div>

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" rows="3" placeholder="Alamat lengkap"><?= e($alamat) ?></textarea>

        <label for="telepon">Nomor Telepon</label>
        <input type="tel" id="telepon" name="telepon" value="<?= e($telepon) ?>" placeholder="08xxxxxxxxxx">

        <button type="submit">Submit</button>
      </form>
    </div>
  <?php endif; ?>

</div>
</body>
</html>
