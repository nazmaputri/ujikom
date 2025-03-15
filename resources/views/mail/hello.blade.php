<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Anda Telah Aktif</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        h1 {
            color: #007bff;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .note {
            font-size: 14px;
            color: #ffffff;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat, {{ $mentorName }}!</h1>
        <p>Akun Anda telah diaktifkan oleh Admin dan kini Anda resmi menjadi mentor di <strong>EduFlix</strong>!</p>
        <p>Silakan login untuk mengakses akun Anda dan mulai membuat kursus pertama Anda.</p>
        <a href="https://nazmaputri-smkn1ciomas-kursusonline-2024.qelopak.com/login" class="btn">Login Sekarang</a>
        <br>
        <hr>
        <p><em><strong>Catatan Penting:</strong></em></p>
        <p>- Kursus yang Anda buat tidak akan dipublikasikan oleh Admin jika belum memiliki materi dan kuis.</p>
        <p>- Setiap kursus yang berhasil terjual akan dikenakan potongan royalti sebesar <strong>2%</strong>.</p>
        <hr>
        <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi tim support kami.</p>
        <p class="note">Salam, <br><strong>EduFlix Team</strong></p>
    </div>
</body>
</html>
