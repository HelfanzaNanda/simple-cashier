<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body{
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color:#333;
            text-align:left;
            font-size:18px;
            margin:0;
        }
        .container{
            margin:0 auto;
            margin-top:35px;
            padding:40px;
            width:750px;
            height:auto;
            background-color:#fff;
        }
        caption{
            font-size:28px;
            margin-bottom:15px;
        }
        table{
            border:1px solid #333;
            border-collapse:collapse;
            margin:0 auto;
            width:740px;
        }
        td, tr, th{
            padding:12px;
            border:1px solid #333;
            width:185px;
        }
        th{
            background-color: #fff;
        }
        h4, p{
            margin:0px;
        }
    </style>
</head>
<body>
    <div class="">
        <table>
            <thead>
                <tr>
                    <th colspan="3">Invoice <strong>{{ $id }}</strong></th>
                    <th colspan="3">
                        <strong>Tanggal : {{ date('d-m-Y', strtotime($now)) }}</strong><br>
                        <strong>Waktu : {{ date('H:i', strtotime($now)) }}</strong>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
                @php($total = 0)
                @foreach ($transactions as $transaction)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <th>{{ $transaction['name'] }}</th>
                    <th>{{ $transaction['qty'] }}x</th>
                    <th>Rp. {{ number_format($transaction['price'], 0,',','.') }}</th>
                    <th>Rp. {{ number_format($transaction['price'] * $transaction['qty'], 0,',','.') }}</th>
                </tr>
                @php($total += $transaction['price'] * $transaction['qty'])
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" rowspan="3"></th>
                    <th>Total Bayar</th>
                    <td>Rp. {{ number_format($total, 0,',','.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>