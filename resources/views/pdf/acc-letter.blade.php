<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan ACC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 2cm;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header p {
            margin: 0;
            line-height: 1.2;
        }
        .divider {
            border-bottom: 2px solid black;
            margin: 10px 0;
        }
        .content {
            margin-top: 30px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
            padding-right: 30px;
        }
        .signature img {
            margin-top: 30px; /* Tempat untuk tanda tangan */
            height: 60px; /* Ukuran default untuk tanda tangan */
        }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%">
            <tr>
                <td style="width: 120px; text-align: center; vertical-align: middle;">
                    <img src="{{ public_path('images/unri.png') }}" alt="Logo UNRI" style="width: 100px;">
                </td>
                <td style="text-align: center;">
                    <p style="font-size: 14px"><strong>UNIVERSITAS RIAU</strong></p>
                    <p style="font-size: 14px"><strong>FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM</strong></p>
                    <p style="font-size: 12px">Kampus Bina Widya Km. 12,5 Simpang Baru Pekanbaru 28293</p>
                    <p style="font-size: 12px">Telepon (0761) 63266 Faksimile (0761) 63279 Laman : www.unri.ac.id</p>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="divider"></div>
    
    <div class="content">
        <p style="text-align: center; font-weight: bold; margin: 20px 0;">
            SURAT KETERANGAN ACC PROPOSAL SKRIPSI MAHASISWA
        </p>

        <p>
            Kami yang bertanda tangan dibawah ini, pembimbing proposal tugas akhir menerangkan bahwa mahasiswa dibawah ini:
        </p>

        <table style="margin-left: 30px; margin-top: 20px; margin-bottom: 20px;">
            <tr>
                <td style="width: 150px;">Nama</td>
                <td style="width: 20px;">:</td>
                <td>{{ $proposal->user->name }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td>{{ $proposal->nim }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Judul Proposal</td>
                <td style="vertical-align: top;">:</td>
                <td>{{ $proposal->judul }}</td>
            </tr>
        </table>

        <p style="text-align: justify;">
            Sehubungan dengan telah selesainya penulisan Proposal Skripsi ini, maka kepada mahasiswa yang namanya tercantum diatas diharapkan untuk melanjutkan tahap selanjutnya dan membuat SK Pembimbing di Gedung Jurusan Ilmu Komputer FMIPA UNRI.
        </p>

        <p style="text-align: justify;">
            Demikian surat keterangan ini dibuat dengan sebenar-benarnya. Untuk itu dapat dipergunakan sebagaimana mestinya. Atas perhatiannya kami ucapkan terima kasih.
        </p>

        <div class="signature">
            <p>Pekanbaru, {{ $tanggal }}</p>
            <p>Dosen KJFD</p>
            <div style="margin: 20px 0;">
                <img src="{{ public_path('images/ttd_kjfd.png') }}" alt="Tanda Tangan Dosen KJFD" style="height: 60px;">
            </div>
            <p>{{ $dosenKjfd->name }}</p>
        </div>
    </div>
</body>
</html>