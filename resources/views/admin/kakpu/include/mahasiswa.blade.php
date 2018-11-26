<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<table border="1">
    <thead>
    <tr>
        <th>No</th>
        <th>Password</th>
        <th>DPM</th>
        <th>HMJ</th>
        <th>BEM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mahasiswa as $mahasiswas)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$mahasiswas->password}}</td>
            <td>{{$mahasiswas->getDPMYangDipilih()->count()==1 ? 'ya' : ''}}</td>
            <td>{{$mahasiswas->getHMJYangDipilih()->count()==1 ? 'ya' : ''}}</td>
            <td>{{$mahasiswas->getBEMYangDipilih()->count()==1 ? 'ya' : ''}}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2">Total : </td>
        <td>{{App\Mahasiswa::whereHas('getDPMYangDipilih')->count()}}</td>
        <td>{{App\Mahasiswa::whereHas('getHMJYangDipilih')->count()}}</td>
        <td>{{App\Mahasiswa::whereHas('getBEMYangDipilih')->count()}}</td>

    </tr>
    </tbody>
</table>

</body>
</html>
