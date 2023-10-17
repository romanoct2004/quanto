<!DOCTYPE html>
<html>
<head>
    <title>請求書送信のお知らせ</title>
</head>
<body>
    <p style="font-weight: bold">{{ $clientName }}様</p>
    <p>{!! $data['body'] !!}</p>

    @isset($data['paymentLink'])
        <a href="{{ $data['paymentLink'] }}">{{ $data['paymentLink'] }}</a>
    @endisset

    <p style="font-weight: bold">{{ $senderName }}</p>
</body>
</html>