<!DOCTYPE html>
<html>
<head>
    <title>請求書送信確認のお知らせ</title>
</head>
<body>
    <p style="font-weight: bold">{{ $senderName }}様</p>
    <p>Quantoをご利用いただき、ありがとうございます。<br>{{ $clientName }}様へ請求書情報を送信致しました。</p>

    <hr>

    <p style="font-weight: bold">{{ $clientName }}様</p>
    <p>{!! $data['body'] !!}</p>

    @isset($data['paymentLink'])
        <a href="{{ $data['paymentLink'] }}">{{ $data['paymentLink'] }}</a>
    @endisset

    <p style="font-weight: bold">{{ $senderName }}</p>
  </body>
</html>