<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <style>
        /* Style untuk seluruh tabel */
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }
        
        /* Style untuk header */
        thead tr {
            background-color: #4b5563;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
        }
        
        /* Style untuk sel header */
        th {
            padding: 12px;
            border: 1px solid #dddddd;
            text-align: center;
            vertical-align: middle;
        }
        
        /* Style untuk sel data */
        td {
            padding: 8px;
            border: 1px solid #dddddd;
            vertical-align: middle;
        }
        
        /* Style untuk baris ganjil */
        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        
        /* Style untuk nomor HP */
        .phone {
            mso-number-format: "\@";
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>NAMA LENGKAP</th>
                <th>ALAMAT EMAIL</th>
                <th>NOMOR HP (WA)</th>
                <th>STATUS</th>
                <th>TGL DAFTAR</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $mahasiswa)
            <tr>
                <td>{{ $mahasiswa->name }}</td>
                <td>{{ $mahasiswa->email }}</td>
                <td class="phone">{{ $mahasiswa->phone ? preg_replace('/^0/', '62', $mahasiswa->phone) : '-' }}</td>
                <td>{{ $mahasiswa->status ? 'AKTIF' : 'NON-AKTIF' }}</td>
                <td>{{ $mahasiswa->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>