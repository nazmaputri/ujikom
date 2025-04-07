<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kelulusan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        body {
            margin: 0;
            padding: 10;
            font-family: 'Montserrat', sans-serif;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .certificate-container {
            position: relative;
            width: 1123px; /* Ukuran A4 Landscape */
            height: 794px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            overflow: hidden;
        }

        .certificate-content-wrapper {
            /* width: calc(100% - 160px); */
            /* margin-left: 160px; */
            text-align: center;
            padding: 40px;
            padding-left: 60px;
            position: relative; /* Pastikan wrapper teks berada di atas */
            z-index: 10; /* Teks berada di atas elemen latar belakang */
        }

        .certificate-title {
            font-size: 2rem;
            font-weight: bold;
            color: #2563eb;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 0px;
        }

        .certificate-text {
            font-size: 1rem;
            color: #4b5563;
            margin-top: 20px;
            text-align: center;
        }

        .certificate-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #374151;
            text-transform: uppercase;
            border-bottom: 2px solid #2563eb;
            display: inline-block;
            padding-bottom: 5px;
            margin-top: 10px;
            text-align: center;
        }

        .signature {
            position: absolute;
            right: 50px;
            bottom: 50px;
            text-align: center;
        }

        .signature img {
            width: 120px;
            height: auto;
        }

        .signature-line {
            border-top: 2px solid #9ca3af;
            width: 200px;
            margin: 10px auto 5px;
        }

        .signature-title {
            font-size: 1rem;
            font-weight: bold;
            color: #374151;
        }

        .logo-sertif {
            position: absolute;
            top: 100px;
            right: 0;
            z-index: 20; /* Lebih tinggi dari elemen-kanan-atas */
            padding: 20px; /* Opsional, jika ingin beri jarak dari sisi */
        }

        .logo-sertif img {
            width: 100px; /* Sesuaikan ukuran logo */
            height: auto;
        }

        /* Posisi elemen kanan atas */
        .elemen-kanan-atas {
            position: absolute;
            top: 100px;
            right: 0;
        }

        .elemen-kanan-atas img {
            width: 250px; /* Sesuaikan ukuran */
            height: auto;
            opacity: 0.6; /* Supaya lebih transparan */
        }

        .elemen-kiri-bawah {
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .elemen-kiri-bawah img {
            width: 250px; /* Sesuaikan ukuran yang diinginkan */
            height: auto; /* Menjaga aspek rasio */
        }

        /* Posisi elemen kanan bawah */
        .elemen-kanan-bawah {
            position: absolute;
            bottom: 0;
            right: 0;
            transform: translate(10px, 10px); /* Sedikit pergeseran agar pas */
        }

        .elemen-kanan-bawah img {
            width: 250px; /* Sesuaikan ukuran */
            height: auto;
        }

        /* Posisi elemen kiri atas */
        .elemen-kiri-atas {
            padding-bottom: auto;
            position: absolute;
            left: 0;
            top: 100px;
        }

        .elemen-kiri-atas img {
            top: 0;
            width: 200px; /* Sesuaikan ukuran */
            height: auto;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
            }

            .certificate-container {
                width: 1123px !important;
                height: 794px !important;
                page-break-before: avoid;
                page-break-after: avoid;
                page-break-inside: avoid;
                border: none;
                box-shadow: none;
            }

            .side-background {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-content-wrapper">
            <div class="certificate-title">SERTIFIKAT KELULUSAN</div>
            <p class="certificate-text">Diberikan kepada</p>
            <div class="certificate-name">{{ $participant_name }}</div>
            <p class="certificate-text">Atas penyelesaian kursus <strong>{{ $course_title }}</strong> dalam kategori {{ $course_category }}.</p>
        </div>

        <div class="logo-sertif">
            <img src="{{ asset('storage/logo-sertif.png') }}" alt="logo-sertif">
        </div>

        <div class="elemen-kanan-atas">
            <img src="{{ asset('storage/kanan-atas.png') }}" alt="elemen-kanan-atas">
        </div>

        <div class="elemen-kanan-bawah">
            <img src="{{ asset('storage/kanan-bawah.png') }}" alt="elemen-kanan-bawah">
        </div>

        <div class="elemen-kiri-bawah">
            <img src="{{ asset('storage/kiri-bawah.png') }}" alt="elemen-kiri-bawah">
        </div>

        <div class="elemen-kiri-atas">
            <img src="{{ asset('storage/kiri-atas.png') }}" alt="elemen-kiri-atas">
        </div>

        <div class="signature">
            <img src="{{ asset('storage/tanda-tangan.png') }}" alt="Tanda Tangan">
            <div class="signature-line"></div>
            <p class="signature-title">CEO</p>
        </div>
    </div>
</body>
</html>
