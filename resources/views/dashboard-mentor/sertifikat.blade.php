<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Kelulusan</title>
    <!-- Import font dari Google Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
        }

        .container {
            width: 1123px;
            height: 794px;
            position: relative;
            background-color: #fff;
        }

        .top-image {
            position: absolute;
            top: 0;
        }

        .left-top {
            left: 0;
        }

        .right-top {
            right: 0;
        }

        .bottom-image {
            position: absolute;
            bottom: 0;
        }

        .left-bottom {
            left: 0;
        }

        .right-bottom {
            right: 0;
        }

        .signature {
            position: absolute;
            bottom: 50px;
            left: 50px;
            right: 50px;
            width: calc(100% - 100px);
        }

        h1 {
            color: #2563eb;
            font-size: 32px;
            margin: 0;
        }

        .subtitle {
            color: #2563eb;
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0;
        }

        .recipient {
            font-size: 24px;
            color: #374151;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #2563eb;
            display: inline-block;
            padding-bottom: 5px;
            margin: 10px 0;
        }

    </style>
</head>
<body>
    <div class="container">

        {{-- Background kiri atas --}}
        <div class="top-image left-top">
            <img src="{{ isset($is_pdf) && $is_pdf ? public_path('storage/kiri-atas.png') : asset('storage/kiri-atas.png') }}"
                 style="width: 200px;" alt="kiri-atas">
        </div>

        {{-- Background kanan atas --}}
        <div class="top-image right-top">
            <img src="{{ isset($is_pdf) && $is_pdf ? public_path('storage/kanan-atas.png') : asset('storage/kanan-atas.png') }}"
                 style="width: 250px;" alt="kanan-atas">
        </div>

        {{-- Konten Utama --}}
        <div class="content" style="text-align: center; padding-top: {{ isset($is_pdf) && $is_pdf ? '100px' : '200px' }};">
            <h1 style="color: #2563eb; font-size: {{ isset($is_pdf) && $is_pdf ? '50px' : '32px' }}; margin: 0;">SERTIFIKAT</h1>
            <p style="color: #2563eb; font-size: {{ isset($is_pdf) && $is_pdf ? '36px' : '20px' }}; font-weight: bold; margin: 10px 0;">KELULUSAN</p>
            <p style="font-size: {{ isset($is_pdf) && $is_pdf ? '24px' : '16px' }}; margin: 10px 0;">Diberikan kepada :</p>
            <p style="font-size: {{ isset($is_pdf) && $is_pdf ? '34px' : '24px' }}; color: #374151; font-weight: bold; text-transform: uppercase; border-bottom: 3px solid #2563eb; display: inline-block; padding-bottom: 8px; margin: 20px 0;">
                {{ $participant_name }}
            </p>
            <p style="font-size: {{ isset($is_pdf) && $is_pdf ? '22px' : '16px' }};">Atas penyelesaian kursus <strong>{{ $course_title }}</strong> dalam kategori {{ $course_category }}.</p>
        </div>

        {{-- Background kiri bawah --}}
        <div class="bottom-image left-bottom">
            <img src="{{ isset($is_pdf) && $is_pdf ? public_path('storage/kiri-bawah.png') : asset('storage/kiri-bawah.png') }}"
                 style="width: 250px;" alt="kiri-bawah">
        </div>

        {{-- Background kanan bawah --}}
        <div class="bottom-image right-bottom">
            <img src="{{ isset($is_pdf) && $is_pdf ? public_path('storage/kanan-bawah.png') : asset('storage/kanan-bawah.png') }}"
                 style="width: 250px;" alt="kanan-bawah">
        </div>

        {{-- Tanda Tangan --}}
        <div class="signature">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: center;">
                        <img src="{{ isset($is_pdf) && $is_pdf ? public_path('storage/tanda-tangan.png') : asset('storage/tanda-tangan.png') }}"
                             style="width: 120px;" alt="tanda-tangan">
                        <div style="border-top: 2px solid #9ca3af; width: 200px; margin: 10px auto 5px;"></div>
                        <p style="font-size: 16px; font-weight: bold; color: #374151;">
                            {{ $signature_title_left ?? 'Direktur' }}
                        </p>
                    </td>
                    <td style="text-align: center;">
                        <img src="{{ isset($is_pdf) && $is_pdf ? public_path('storage/tanda-tangan.png') : asset('storage/tanda-tangan.png') }}"
                             style="width: 120px;" alt="tanda-tangan">
                        <div style="border-top: 2px solid #9ca3af; width: 200px; margin: 10px auto 5px;"></div>
                        <p style="font-size: 16px; font-weight: bold; color: #374151;">
                            {{ $signature_title_right ?? 'Mentor' }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</body>
</html>
