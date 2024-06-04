<table border="1" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th style="width: 10px;">No</th>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Catatan</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($peserta as $i =>$data)
        <tr>
            <td>{{ ++$i }}</td>
            <td class="text-uppercase">{{ $data->nama_lengkap }}</td>
            <td>
                @if ($data->jenis_kelamin == 1)
                <span>Laki - Laki</span>
                @else
                <span>Perempuan</span>
                @endif
            </td>
            <td>{{ $data->kategori?->name }}</td>
            <td>{{ $data->status?->name }}</td>
            <td> {{ $data->catatan }} </td>
        </tr>
        @endforeach
    </tbody>
</table>