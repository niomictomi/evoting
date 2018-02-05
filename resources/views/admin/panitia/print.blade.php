<!DOCTYPE html>
<html>

<head>

    <style type="text/css" media="print">
        @page {
            size: auto;   /* auto is the current printer page size */
            margin: 6mm;  /* this affects the margin in the printer settings */
        }

        body {
            background-color: #FFFFFF;
            margin: 0px; /* the margin on the content before printing */
        }
    </style>
    <script>
        window.open('https://www.codexworld.com', '_blank');</script>
</head>
<body onload="window.print();window.close()">
<div>
    <div style="font-size: 20px"><strong> E-Voting Pemira!</strong></div>
    <div>Fakultas Ekonomi</div>
    <br>
    <div>Username : {{$mahasiswa->id}}</div>
    <div>Password  : <b >{{$pass}}</b></div>
    <br>
    <div>{{\Carbon\Carbon::now()}}</div>
</div>
</body>

</html>