<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        #items {
            border-collapse: collapse;
            width: 100%;
        }

        #items td {
            border-top: 5px solid black;
            border-right: 5px solid black;
            border-bottom: 10px solid black;
            border-left: 5px solid black;
            padding: 8px;
            text-align: center;
        }

        #items p {
            font-weight: bold;
            letter-spacing: 2px;
        }
    </style>
</head>

<body>
    <table id="items">
        @foreach ($items as $item)
            <tr>
                <td><img src="{{ asset('img/bengkulu-logo.png') }}" style="width: 110px" alt=""></td>
                <td>
                    <p>{{ $item->kode }}</p>
                    <p></br>{{ $item->nama }}</p>
                </td>
                <td style="padding-left: 20px; padding-right: 20px;">
                    <img src="data:image/png;base64, {!! $qrcodes[$loop->index] !!}">
                </td>
            </tr>
        @endforeach
    </table>

</body>

</html>
