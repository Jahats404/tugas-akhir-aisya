<!DOCTYPE html>
<html>
<head>
    <title>Arsip Histori Prestasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-surat h1 {
            margin: 0;
            font-size: 24px;
        }
        .kop-surat p {
            margin: 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto; /* Pusatkan tabel */
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .summary {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ public_path('landing/images/topics/aisya_new.2.3.jpg') }}" class="rounded mx-auto d-block" height="20%" width="15%" alt="Logo Organisasi">
        {{-- <img src="{{ asset('landing/images/topics/aisya_new.2.3.jpg') }}" class="rounded mx-auto d-block" height="30%" width="30%" alt=""> --}}
        <h1>Dinas Arpus</h1>
        <p>Jl. Sumbing No.4, Cilacap, Sidanegara, Kec. Cilacap Tengah, Kabupaten Cilacap, Jawa Tengah 53212</p>
        <p>Telepon: 028-252-0861 | Email: arpus@cilacap.co.id</p>
    </div>

    <h2 style="text-align: center;">Arsip Histori Prestasi</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Wilayah</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                {{-- <th>Status</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->wilayah }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    {{-- <td>{{ $item->status }}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Jumlah Masyarakat berprestasi per Kategori</h3>
        <ul>
            <li>Kategori Olahraga : {{ $olahraga }}</li>
            <li>Kategori Akademik : {{ $akademik }}</li>
            <li>Kategori Kesenian : {{ $kesenian }}</li>
            <li>Kategori Pengabdian : {{ $pengabdian }}</li>
        </ul>
    </div>
</body>
</html>