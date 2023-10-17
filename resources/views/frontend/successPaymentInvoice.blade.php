<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>QUANTO</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial;
            font-size: 17px;
        }

        #myVideo {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
        }

        .content {
            position: fixed;
            top: 20%;
            width: 100%;
            padding: 20px;
        }

        #myBtn {
            width: 200px;
            font-size: 18px;
            padding: 10px;
            border: none;
            background: #000;
            color: #fff;
            cursor: pointer;
        }

        #myBtn:hover {
            background: #ddd;
            color: black;
        }

        .mb-1 {
            margin-bottom: 20px;
            font-weight: 600;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .btn-quanto {
            color: #ffffff;
            background: #6962ff;
            border-color: #6962ff;
            border-radius: 30px;
            padding: 5px 15px;
        }

        .btn-quanto:hover,
        .btn-quanto:focus {
            color: #ffffff;
            background: #4c46d5;
            border-color: #4c46d5;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="col-12 my-4">
            <div class="card border border-2 px-3 py-4 text-center mx-auto" style="border-radius:15px; background:#DEEBF7;max-width:500px">
                <div>
                    <div class="mx-auto mb-3" style="border-radius:50%; background:#6962FF; color:#ffffff;font-weight:600; font-size:24px; width:40px; height:40px;padding-top:4px">✔</div>
                </div>
                <h5 class="mb-1">ご注文が完了致しました。</h5>
                <h5 class="mb-1">このたびのご注文</h5>
                <h5 class="mb-1">まことにありがとうございました。</h5>
            </div>
        </div>
    </div>
</body>

</html>