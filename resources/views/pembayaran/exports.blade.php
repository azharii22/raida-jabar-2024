<table>
    <thead>
        <tr>
            <th style="width: 10px;">No</th>
            <th style="width: 10px;">Nama</th>
            <th style="width: 10px;">Jumlah Terdaftar</th>
            <th style="width: 10px;">Nominal</th>
            <th style="width: 10px;">Status</th>
            <th style="width: 10px;" class="text-center">Bukti Pembayaran</th>
            <th style="width: 10px;">Tanggal Upload</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($pembayaran as $i =>$data)
        <tr>
            <td style="width: 10px;">{{ ++$i }}</td>
            <td style="width: 10px;">{{ $data->user?->nama }}</td>
            <td style="width: 10px;">{{ $data->jumlah_terdaftar }}</td>
            <td style="width: 10px;">@currency($data->nominal)</td>
            <td style="width: 10px;">{{ $data->status }}</td>
            <td style="width: 10px;" class="text-center"><img src="{{ Storage::url('public/img/pembayaran/').$data->file_bukti_bayar }}" /></td>
            <td style="width: 10px;">{{ date('d-M-Y',strtotime($data->tanggal_upload)) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>