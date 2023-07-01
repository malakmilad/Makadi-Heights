<!DOCTYPE html>
<html>

<head>
    <title>Makadi Heights</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<style>
    body {
        font-family: 'Montserrat';
        font-size: 14px;
        padding: 40px;
    }

    .center {
        display: flex;
        justify-content: center;
    }

    .center-image {
        width: 15%;
    }
</style>

<body>
    <div style="background: #21436e;padding:2rem;height:60px">
        <img src="https://makadiheights.com/logoBig.png" width="30%" alt="" srcset="" style="float: left" />
    </div>
    <h2>To Makadi Heights Admin,</h2>
    <p>A new payment has been made successfully</p>
    <p>
        <strong style="font-size: 1.5rem;font-weight:800;margin-bottom:1rem">Payment Details:</strong> <br><br>
        Payment ID: {{ $id }} <br>
        Payment Currency: {{ $payment->currency->currency }} <br>
        Transaction ID: {{ $payment->transaction_id }}
    </p>
    <p>
        <strong style="font-size: 1.5rem;font-weight:800;margin-bottom:1rem">Sales Details:</strong> <br><br>
        Username: {{ $payment->user->name }} <br>
        Email: {{ $payment->user->email }} <br>
    </p>
    <p>
        <strong style="font-size: 1.5rem;font-weight:800;margin-bottom:1rem">Customer Details:</strong><br><br>
        Name: {{ $payment->first_name . ' ' . $payment->last_name }}<br>
        Email: {{ $payment->email }} <br>
        Phone: {{ $payment->mobile }} <br>
        Address Line 1: {{ $payment->address_line_1 }} <br>
        Address Line 2: {{ $payment->address_line_2 }} <br>
        City: {{ $payment->city }} <br>
        Country: {{ $payment->country }} <br>
    </p>
    <p>
        <strong style="font-size: 1.5rem;font-weight:800;margin-bottom:1rem">Unit Details:</strong><br><br>
        Personal ID: {{ $payment->personal_id }}<br>
        Unit Unique Reference: {{ $payment->unit_unique_reference }}<br>
        {{-- Unit Name: {{ $payment->unit }}<br> --}}
        Total Unit Price : {{$payment->currency->currency}} {{ number_format($totalUnitPrice,0) }}<br>
        Amount Paid: {{$payment->currency->currency}} {{ number_format($downPayment,0) }} <br>
        Zone: {{ $zoneName }} <br>
        Building Type: {{ $payment->building_type }} <br>
        Unit Unique Reference:{{ $payment->unit_unique_reference }}
    </p>

    <br>

    <p>Thank you,</p>
    <h3>Makadi Heights Notification System</h3>
</body>

</html>
