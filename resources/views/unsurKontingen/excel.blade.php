<table border="1" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th style="width: 10px;">No</th>
            <th>Wilayah Cabang</th>
            <th>Wilayah Ranting</th>
            <th>Kategori</th>
            <th>Nama Lengkap</th>
            <th>Tempat, Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Ukuran Kaos</th>
            <th>No HP</th>
            <th>Agama</th>
            <th>Golongan Darah</th>
            <th>Riwayat Penyakit</th>
            <th>Foto</th>
            <th>KTA</th>
            <th>Asuransi Kesehatan</th>
            <th>Sertif SFH</th>
            <th>Status</th>
            <th>Catatan</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($peserta as $i =>$data)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $data->regency->name }}</td>
            <td>{{ $data->villages?->name ?  $data->villages?->name : $data->regency->name }}</td>
            <td>{{ $data->kategori?->name }}</td>
            <td>{{ $data->nama_lengkap }}</td>
            <td>{{ $data->tempat_lahir }}, {{ date('d-F-Y', strtotime($data->tanggal_lahir)) }}</td>
            <td>@if ($data->jenis_kelamin == 1)<span>Laki - Laki</span>@else<span>Perempuan</span>@endif</td>
            <td>{{ $data->ukuran_kaos }}</td>
            <td>{{ $data->no_hp }}</td>
            <td>{{ $data->agama }}</td>
            <td>{{ $data->golongan_darah }}</td>
            <td>{{ $data->riwayat_penyakit }}</td>
            <td>{{ $data->foto }}</td>
            <td>{{ $data->kta }}</td>
            <td>{{ $data->asuransi_kesehatan }}</td>
            <td>{{ $data->sertif_sfh }}</td>
            <td>{{ $data->status?->name }}</td>
            <td>{{ $data->catatan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>