<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="/public/css/paymentInvoice.css">
    <link rel="stylesheet" href="/public/js/lib/pdf.css">
    <script src="/public/js/paymentInvoice.js" defer></script>
    <title>お支払い | QUANTO</title>
</head>

<body class="body">
    <div class="alert alert-danger" id="error-alert" style="display: none;">
        @if (session('error'))
            <p>{{ session('error') }}</p>
        @endif
    </div>
    
    <div class="body-inner">
        <div class="card mb-5 card-wrapper">
            <div class="card-header text-center position-relative" style="background:#DAE3F3;border-top-left-radius:13px;border-top-right-radius:13px;">
                <h4>ご請求情報</h4>
            </div>
            <embed class="pdffile" src="/public/js/lib/web/viewer.html?file={{$invoice->pdf_file_url}}">
        </div>

        <form action="{{ url()->current() }}" method="POST">
            @csrf
            
            <input type="text" name="id" value="{{ $invoice->id }}" hidden>
            
            <div class="card mb-5 card-wrapper">
                <div class="card-header text-center position-relative" style="background:#DAE3F3;border-top-left-radius:13px;border-top-right-radius:13px;">
                    <h4>お支払い情報</h4>
                </div>
                <div class="card-body p-5">
                    <div class="form-group row py-2">
                        <label for="card_name" class="label">カード名義</label>
                        <div class="input">
                            <input type="card_name" class="form-control" id="card_name" name="card_name" placeholder="" required>
                        </div>
                    </div>

                    <div class="form-group row py-2" id="card-number-wrapper">
                        <label for="card_number" class="label">カード番号</label>
                        <div class="input">
                            <div class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row py-2" id="card-expiration-wrapper">
                        <label for="expiration" class="label">有効期限</label>
                        <div class="input">
                            <div class="form-control">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row py-2" id="card-security-code-wrapper">
                        <label for="security_code" class="label">セキュリティコード</label>
                        <div class="input">
                            <div class="form-control">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-5 card-wrapper">
                <div class="card-header text-center position-relative" style="background:#DAE3F3;border-top-left-radius:13px;border-top-right-radius:13px;">
                    <h4>発送先情報</h4>
                </div>
                <div class="card-body p-5">
                    <div class="form-group row py-2">
                        <label for="email" class="label">メールアドレス</label>
                        <div class="input">
                            <input type="email" class="form-control" id="email" name="email" placeholder="test@mail.com" required>
                        </div>
                    </div>

                    <div class="form-group row py-2">
                        <label for="name" class="label">お名前</label>
                        <div class="input">
                            <input type="text" class="form-control" name="name" id="name" placeholder="山田 太郎" required>
                        </div>
                    </div>

                    <div class="form-group row py-2 mb-5">
                        <label for="kana" class="label">フリガナ</label>
                        <div class="input">
                            <input type="text" class="form-control" name="kana" id="kana" placeholder="ヤマダタロウ" required>
                        </div>
                    </div>

                    <div id="billingDetails">
                        <div class="form-group row py-2">
                            <label for="postcode" class="label">郵便番号</label>
                            <div class="input d-flex">
                                <input type="text" class="form-control d-inline me-2" style="width:55px; margin-top:2px" pattern="[0-9]{3,3}" maxlength="3" name="postcodeFirst" id="postcodeFirst" placeholder="111" value="{{old('postcodeFirst')}}" required>
                                <input type="text" class="form-control d-inline me-3" style="width:65px; margin-top:2px" pattern="[0-9]{4,4}" maxlength="4" name="postcodeLast" id="postcodeLast" placeholder="1111" value="{{old('postcodeLast')}}" required>
                            </div>
                        </div>

                        <div class="form-group row py-2">
                            <label for="address" class="label">住所</label>
                            <div class="input">
                                <input type="text" class="form-control" name="address" id="address" placeholder="都道府県 市区町村" value="{{old('address')}}" required>
                            </div>
                        </div>
                        <div class="form-group row py-2" style="grid-template-columns: 1fr 1fr;">
                            <label for="address2" class="label"></label>
                            <div class="input">
                                <input type="text" class="form-control" name="address2" id="address2" placeholder="番地・部屋番号など" value="{{old('address2')}}" required>
                            </div>
                        </div>
                        <div class="form-group row py-2" style="grid-template-columns: 1fr 1fr;">
                            <label for="address3" class="label"></label>
                            <div class="input">
                                <input type="text" class="form-control" name="address3" id="address3" placeholder="建物名・マンション名（任意）" value="{{old('address3')}}">
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <label for="cell" class="label">電話番号</label>
                            <div class="input">
                                <input type="text" class="form-control" id="cell" name="phone" placeholder="03-1234-5678" value="{{old('phone')}}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="pay" type="submit">お支払い ({{ $invoice->total_price }} 円)</button>
        </form>
    </div>
</body>
</html>