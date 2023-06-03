<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ffffe0;
        }
    </style>
</head>
<body>
<table class="table">
    <tr class="text-center">
        <td colspan="2"><img src="{{ asset('assets/images/logo/logo2.png') }}" alt=""></td>
    </tr>
    <tr class="text-center">
        <td colspan="2">Jl. Perintis Kemerdekaan No. 29 Telp (0751) 33870 Padang</td>
    </tr>
    <tr class="text-center">
        <td colspan="2">SIAP : NO. 0017/SIAP/DPMPTSP/IV/2020</td>
    </tr>
    <tr class="text-center">
        <td colspan="2"><h4 class="mb-0">Surat Pesanan</h4></td>
    </tr>
    <tr class="text-center">
        <td colspan="2"><strong>Kepada :</strong> <?= $data->nama_perusahaan ?></td>
    </tr>
    <tr class="text-center">
        <td colspan="2"><strong>Padang Tgl :</strong> <?= date('d-m-Y', strtotime($data->tanggal_pesanan)) ?></td>
    </tr>
    <tr>
        <td><strong>No.</strong> <?= $data->id ?></td>
    </tr>
    <tr>
        <th>Banyaknya</th>
        <th>Nama Barang</th>
    </tr>
    <?php $obatData = json_decode($data->obat); ?>
    <?php foreach ($obatData as $obat) : ?>
    <tr>
        <td><?= $obat->jumlah_out ?></td>
        <td><?= $obat->nama_obat ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="2" class="text-right"><strong>Tanda Tangan Cap Pemesan</strong></td>
    </tr>
    <tr>
        <td colspan="2" class="text-right">...</td>
    </tr>
    <tr>
        <td colspan="2" class="text-right"><strong>Apoteker :</strong> Selvi Merwanta, M.Farm, Apt</td>
    </tr>
    <tr>
        <td colspan="2" class="text-right"><strong>SIPA :</strong> 19910205/SIPA_13.71/2020/2.20</td>
    </tr>
</table>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>window.print();</script>
</body>
</html>
