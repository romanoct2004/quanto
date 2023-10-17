{{-- {{dd(json_decode($editData->content))}} --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . '管理' : '管理者' }} | {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('public/css/lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/make_form.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        .container-fluid {
            padding-left: 10rem !important;
        }
    </style>
    <style>
      #form_body {
        width: 100vw;
      }
    </style>
</head>

<body>
    <!-- Page Heading -->
    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <?php
    $edit_content = json_decode($editData->content);
    // dd($editData->content);
    // dd($edit_content);
    
    if (isset(Auth::user()->settings)) {
        $userSettings = json_decode(Auth::user()->settings);
        $invoice = isset($userSettings->invoice) ? $userSettings->invoice : '';
        $member = isset($userSettings->member) ? $userSettings->member : '';
        $purpose = isset($userSettings->purpose) ? $userSettings->purpose : '';
        $payment_method = isset($userSettings->payment_method) ? $userSettings->payment_method : '';
        $stamp_url = isset($userSettings->stamp_url) ? $userSettings->stamp_url : '';
    } else {
        $invoice = '';
        $member = '';
        $purpose = '';
        $payment_method = '';
        $stamp_url = '';
    }
    $profile_url = Auth::user()->profile_url != null ? url(Auth::user()->profile_url) : '';
    
    ?>

    <div class="form-body" id="form_body">

        <div class="print-content" id="invoice">
            <div id="page1" class="page1">
                <div class="flex-between mb1">
                    <div class="pro33"></div>
                    <div class="pro33 flex-center text-center p2 text-center t6 b8"><input id="purpose_1"
                            class="input10" value="ご請求書"></div>
                    <div class="pro33 text-right t1 b2">発行日:<input id="cDate" class="input2 w125 text-right"
                            value="{{ $edit_content->cDate ?? '' }}"> </div>
                </div>
                <div class="flex mb1">
                    <div class="pro60">
                        <div id="uNameDiv" class="t4 uline-grey pb-1"><input id="uName" class="input9 text-center"
                                value="{{ $edit_content->uName ?? '' }}">様</div>
                        <div id="uMethodDiv" class="uline-grey pb5 text-left t2 ufit"> 支払方法：<input id="uMethod"
                                class="input1 w200" value="{{ $edit_content->uMethod ?? '' }}"></div>
                    </div>
                    <div class="flex-between p2">
                        <div class="p2">
                            <img id="profile" alt="profile" src="{{ Auth::user()->profile_url }}"
                                style="border-style:solid; border-width:1px; height:50px; width:50px" />
                        </div>
                        <div class="t1-col">
                            <input id="serial" class="input2 w200" value="{{ $edit_content->serial ?? '' }}">
                            <input id="company" class="input2 w200" value="{{ $edit_content->company ?? '' }}">
                            <div id="invoice_num">{{ $invoice }}</div>
                        </div>
                    </div>
                </div>
                <div class="flex pro100">
                    <div class="flex-between pro60">
                        <div class="flex-end pb3">
                            <div class="uline-grey pb1">
                                <span class="t1">ご請求金額&nbsp;</span>
                                <input class="input4 w250" id="display_total_price" value="{{ $edit_content->total_price }}">
                                <span class="t5 b4" style="vertical-align: 3px;">円&nbsp;</span>
                                <span>(税込)</span><input type="text" class="display-reduce" value="{{ $edit_content->reduce_price }}"
                                    id="display_reduce">円
                            </div>
                        </div>

                    </div>

                    <div class="profile-block t1 pro40">
                        <div class="flex-center p2 text-center w150" style="width: 80px;">
                            <p>住所</p>
                        </div>
                        <div class="profile-sub-block flex p2">
                            <div>
                                <input id="zipCode" class="input2 w200" value="{{ $edit_content->zipCode ?? '' }}">
                                <input id="adress" class="input2 w200" value="{{ $edit_content->adress ?? '' }}">
                                <input id="phone" class="input2 w200" value="{{ $edit_content->phone ?? '' }}">
                            </div>
                        </div>
                        <div class="flex-center p3">
                            <img alt="stamp" id="stamp" src="{{ $stamp_url }}"
                                style="height:70px; width:70px" />
                        </div>
                    </div>
                </div>
                <div>
                    <div class="t1"> 有効期間 <input id="eDate" class="input2 w200"
                            value="{{ $edit_content->eDate ?? '' }}"></div>
                    <hr style="border-top:2px solid blue">
                    <p class="text-center t2">内容明細</p>
                </div>

                <div id="main_table">
                    <div class="blank_new_row">
                        <img src="{{ asset('public/img/edit_query_m.png') }}" class="blank_new_row_img"
                            alt="">
                    </div>
                    <table cellpadding="1" cellspacing="0" class="main-table">
                        <thead>
                            <tr>
                                <th class="th-ID">ID</th>
                                <th class="th1">内容</th>
                                @foreach ($productOptions as $key => $productOption)
                                    <th class="th-plus th-plus-{{ $key }}"
                                        {{ $productOption == 'カラー' || $productOption == 'サイズ' || $productOption == '素材' ? '' : 'style=display:none;' }}>
                                        {{ $productOption }}
                                    </th>
                                @endforeach
                                <th class="th2">単価</th>
                                <th class="th3">数量</th>
                                <th class="th4">金額(円)</th>
                                <th class="th5">消費税</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $currentPrice = 0;
                            $i = 0; ?>
                            <?php $totalPrice = 0;
                            $totalCount = 1; ?>
                            @for ($i = 0; $i < $edit_content->rowCount; $i++)
                                <tr>
                                    <td class="td-ID">
                                        <div class="td-a1-d1 tooltipimg">
                                            <input class="td-ID-input" id="ID_{{ $i }}"
                                                value="{{ $edit_content->{'ID_' . $i} ?? 0 }}">
                                            <input type="hidden" id="productNum_{{ $i }}"
                                                value="{{ $edit_content->{'productNum_' . $i} ?? '' }}">
                                        </div>
                                    </td>
                                    <td class="td-a1"> &nbsp;

                                        <div class="flex-center"><img alt="product" id="timg_{{ $i }}"
                                                src="{{ $edit_content->{'timg_' . $i} ?? '' }}"
                                                onerror="this.onerror=null; this.onload=null; if (!this.attributes.src.value) this.attributes.src.value='{{ asset('public/img/blank-plus.png') }}';"
                                                class="td-a1-d2-img" />
                                        </div>
                                        <div class="td-a1-input open-modal" id="title_{{ $i }}">
                                            {{ $edit_content->{'title_' . $i} ?? '' }}</div>
                                    </td>
                                    @foreach ($productOptions as $key => $productOption)
                                        <td class="td-plus td-plus-{{ $key }}"
                                            {{ $productOption == 'カラー' || $productOption == 'サイズ' || $productOption == '素材' ? '' : 'style=display:none;' }}>
                                            <div class="td-subt-input td-input-{{ $key }} open-modal"
                                                id="subt_{{ $key }}_{{ $i }}">
                                                {{ isset($edit_content->{'subt_' . $key . '_' . $i}) ? $edit_content->{'subt_' . $key . '_' . $i} : '　' }}
                                            </div>
                                        </td>
                                    @endforeach
                                    <td class="td-a2"><input class="td-a2-input" id="price_{{ $i }}"
                                            value="{{ $edit_content->{'price_' . $i} ?? 0 }}"><span>円</span></td>
                                    <td class="td-a3"><input class="td-a3-input" id="quantity_{{ $i }}"
                                            value="{{ $edit_content->{'quantity_' . $i} ?? 0 }}"></td>
                                    <td class="td-a4"> <input class="td-a4-input"
                                            id="current_price_{{ $i }}"
                                            value="{{ $edit_content->{'current_price_' . $i} ?? 0 }}">円</td>
                                    <td class="td-a5 reduce-pro-td">
                                        <select name="pets" class="reduce-pro"
                                            id="reduce_pro_{{ $i }}">
                                            <option value="10">10%</option>
                                            <option value="8">8%(軽減税率)</option>
                                            <option value="8">8%</option>
                                            <option value="0">0%</option>
                                        </select>
                                        <input class="td-a5-input" id="reduce_plus_{{ $i }}"
                                            value="{{ $edit_content->{'reduce_plus_' . $i} ?? 0 }}">円
                                    </td>
                                </tr>
                            @endfor


                            <tr>
                                <td class="td-r1" colspan="5">合計</td>
                                <td></td>
                                <td class="td-r3"><input class="td-r3-input" id="total_count"
                                        value="{{ $edit_content->total_count }}"> </td>
                                <td class="td-r4"> <input class="td-r4-input" id="total_price"
                                        value="{{ $edit_content->total_price }}">円</td>
                                <td class="td-r5"> 消費税(内税)<input class="td-r5-input" id="reduce_price"
                                        value="{{ $edit_content->reduce_price }}">円</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="other-area">
                <textarea
                    style="height: 100px; border: 1px solid grey; padding: 5px; box-sizing: border-box; margin-left: 10px; font-size: 20px;"
                    placeholder="(備考)" text="afaefafe" id="memo_text">{{ $edit_content->memo_text ?? '' }}</textarea>
                <div class="detail_price">
                    <div>
                        <p>10%対象&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                class="sinput"id="totalAmount10" value="{{ $edit_content->totalAmount10 }}">円</p>
                        <p>&nbsp;&nbsp;消費税(内税)<input class="sinput"id="totalAmount10s"
                                value="{{ $edit_content->totalAmount10s }}">円</p>
                    </div>
                    <div>
                        <p>8%(軽減税率)<input class="sinput"id="totalAmount88"
                                value="{{ $edit_content->totalAmount88 }}">円</p>
                        <p>&nbsp;&nbsp;消費税(内税)<input class="sinput"id="totalAmount88s"
                                value="{{ $edit_content->totalAmount88s }}">円</p>
                    </div>
                    <div>
                        <p>8%対象 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                class="sinput"id="totalAmount8" value="{{ $edit_content->totalAmount8 }}">円</p>
                        <p>&nbsp;&nbsp;消費税(内税)<input class="sinput" id="totalAmount8s"
                                value="{{ $edit_content->totalAmount8s }}">円</p>
                    </div>
                </div>
            </div>
            <style id="page_style">
                @page {
                    size: A4;
                    margin: 0;
                }
            </style>
        </div>

        <div id="q_modal" class="q-modal">
            <div class="img-modal" id="img_modal">
                <img class="img-close-btn" src="{{ asset('public/img/ic_modal_close.png') }}">
                <div class="img-modal-main">
                    <div class="img-modal-title">
                        <div class="img-modal-title-text">画像を選択</div>
                    </div>
                    <div class="img-modal-search-bar">
                        <input type="text" id="search_input" placeholder="Search for names..">
                        <button class="img-modal-probtn img-modal-search-btn" id="img_modal_probtn">&nbsp;</button>
                        <button class="img-modal-xybtn img-modal-search-btn" id="img_modal_xybtn">&nbsp;</button>
                        <button class="img-modal-xbtn img-modal-search-btn" id="img_modal_xbtn">&nbsp;</button>
                    </div>
                    <div class="img-view" id="img_view">
                    </div>
                    <div class="img-upload">
                        <div class="img-upload-img"><img id="img_upload_img"
                                src="{{ asset('public/img/blank.png') }}" style="height: 90px;"></div>
                        <div class="img-upload-url"> 新規追加する &nbsp;&nbsp;<input id="img_upload_url"
                                style="width:150px;" readonly value="blank.png"></div>
                        <div class="img-upload-link-btn"><img src="{{ asset('public/img/ic_check.png') }}"
                                style="height: 50px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php $i = 1; ?>
        <input type="hidden" id="hostUrl" value="{{ url('/') }}">
        <input type="hidden" id="rowCount" value="{{ $edit_content->rowCount ?? 1 }}">
        <input type="hidden" id="ic_add" src="{{ asset('public/img/ic_add.png') }}">
        <input type="hidden" id="ic_del" src="{{ asset('public/img/ic_delete.png') }}">
        <input type="hidden" id="ic_edit" src="{{ asset('public/img/edit_query.png') }}">
        <input type="hidden" id="ic_blank" src="{{ asset('public/img/blank-plus.png') }}">
        <input type="hidden" id="ic_link" src="{{ asset('public/img/ic_link.png') }}">
        <input type="hidden" id="ic_check" src="{{ asset('public/img/ic_check.png') }}">
        <input type="hidden" id="ic_newblank" src="{{ asset('public/img/blank.png') }}">


        {{-- Mail modal --}}
        <div class="modal fade show" id="mailModal" style="display: none;">
            <div class="modal-dialog">
                <div class="mail-modal-content">
                    <div class="mail-modal-header" style="border-bottom: 0; padding: 0;">
                        <div type="button" class="mail-close" style="opacity:1;">
                            <img src="{{ asset('public/img/ic_modal_close.png') }}"
                                style="position: absolute; top: -33px; right: -30px; width: 40px; height: 40px; ">
                        </div>
                        <h1 class="mail-modal-header-title">メール送信フォーム</h1>
                    </div>

                    <div class="set-div-toggle for-mail">
                        <label class="set-div-toggle-label"
                            for="is_using_credit_card_for_modal">クレジットカード<br>決済の利用</label>
                        <input {{ $editData->is_using_credit_card === 1 ? 'checked' : '' }}
                            name="is_using_credit_card_for_modal" type="checkbox" class="set-div-toggle-input"
                            id="is_using_credit_card_for_modal">
                    </div>

                    <div class="mail-first-items">
                        <form action="{{ route('paper.invoice.mail_send') }}" method="POST" id="mail_send_form">
                            @csrf
                            <input type="hidden" id="mails_text" name="mails_text" value="" required>
                            <div class="mail-first-line" id="mail_line_0">
                                <div class="mail-modal-mailIcon">
                                    <img src="{{ asset('public/img/ic_mail1.png') }}" alt="">
                                </div>
                                <div class="mail-first-content">
                                    <input type="text" class="mail-item-input" id="mail_address_0"
                                        name="mail_address_0" value="">
                                </div>
                                <div class="mail-modal-plusIcon">
                                    <img class="m-add-ic" src="{{ asset('public/img/ic_add.png') }}" alt="">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="mail-div">
                        <textarea class="mail-textarea" id="mail_textarea" name="mail_textarea">お世話になっております。&#13;&#10;添付にて、インボイスをお送りさせていただきたくよろしくお願い致します。</textarea>
                    </div>
                    <div class="modal-footer justify-content-center" style="border-top: 0; padding: 10px;">
                        <button id="first_ok" class="btn btn-primary m-auto" onclick="mail_send_one()"
                            style="background-color: rgb(143, 1, 255); font-size: 14px;border:0; height: 32px; width: 80px; border-radius: 10px; font-weight: 600; opacity:1;">送信</button>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($models as $ii => $model)
        @endforeach
        <!-- Modal -->
        <div class="modal fade" id="modalAddQuestion" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width : 1400px">
                <div class="modal-content" style="width:1400px; min-height : calc(100vh - 80px)">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">商品情報</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                            onclick="$('#modalAddQuestion').modal('toggle')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row m-0 px-2">
                            <div class="col-6 p-0 flex flex-column align-items-center">
                                <div class="img_pan_main">
                                    <div class="swiper mySwiper" id="mySwiper_main">
                                        <div class="swiper-wrapper" id="slide_img_pan_main">
                                            <div class="swiper-slide">
                                                <img src="{{ url('public/img/img_03/delete.png') }}" alt="">
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ url('public/img/img_03/delete.png') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </div>
                                <div class="img_pan">
                                    <div class="swiper mySwiper" id="mySwiper">
                                        <div class="swiper-wrapper" id="slide_img_pan">
                                            <div class="swiper-slide">
                                                <img src="{{ url('public/img/img_03/delete.png') }}" alt="">
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ url('public/img/img_03/delete.png') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </div>

                                <div class="m-4 flex justify-content-end" style="width : 400px">
                                    <a href="javascript:viewImageList()" class="font-weight-bold">もっと見る</a>
                                </div>
                            </div>
                            <div class="col-6 p-0 pr-4" id="info_pan">
                                <div class="row m-0 mt-3" id="productID">デザインTシャツブラック</div>
                                <div class="row m-0 mt-3" id="name">デザインTシャツブラック</div>
                                <div class="row m-0 mt-3" id="price">980デ</div>
                                <div class="row m-0 mt-3">
                                    <div class="col-3 p-0 flex">
                                        <div class="pr-2 change-count" onclick="changeCount(-1)">-</div>
                                        <input type="text" id="count_product" value="0">
                                        <div class="pl-2 change-count" onclick="changeCount(1)">+</div>
                                    </div>
                                    <div class="col-3 p-0">
                                        <input type="button" class="btn btn-primary" value="カートに追加">
                                    </div>
                                    <div class="col-1 p-0">
                                        <img src="{{ url('public/img/img_03/tag_off.png') }}" alt=""
                                            class="tag" id="tag_1" onclick="setSave(1)">
                                        <img src="{{ url('public/img/img_03/tag_on.png') }}" alt=""
                                            class="tag" id="tag_2" onclick="setSave(0)"
                                            style="display: none">
                                    </div>
                                </div>
                                <div class="row m-0 mt-4" id="product_detail">商品説明</div>
                                <div class="row m-0 mt-3" id="detail">デザインTシャツブラック</div>
                                <div class="row m-0 mt-3" id="product_info">商品詳細</div>
                                <div class="row m-0 mt-3 info">
                                    <div class="col-3 p-0">ブランド名</div>
                                    <div class="col-9 p-0">デザインク</div>
                                </div>
                                <div class="row m-0 mt-3 info">
                                    <div class="col-3 p-0">sku</div>
                                    <div class="col-9 p-0">123-4567</div>
                                </div>
                                <div class="mt-3" id="options">
                                    <div class="row m-0 mt-3 info">
                                        <div class="col-3 p-0">デザイ</div>
                                        <div class="col-9 p-0">デザイ-1</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalImageViewList" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document"
                style="max-width : 900px; min-width: 900px;">
                <div class="modal-content"
                    style="width:900px; min-height: 360px; background-color: #f1f2ff; border : 0; box-shadow: 5px 5px 10px grey;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">商品画像</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                            onclick="$('#modalImageViewList').modal('toggle')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="user_product_img_pan">
                            <div class="user_product_img_first" id="userProductImage_div_0">
                                <img src="" id="userProductImage_0" alt="img" onclick="viewImage(this.src);">
                            </div>
                            @for ($ii = 1; $ii < 18; $ii++)
                                @php
                                    $style = 'display:none';
                                    $src = '';
                                @endphp
                                <div id="userProductImage_div_{{ $ii }}" class="sub_image_pan"
                                    style="{{ $style }}">
                                    <img src="{{ $src }}" id="userProductImage_{{ $ii }}"
                                        alt="img" class="view_image" onclick="viewImage(this.src);">
                                </div>
                            @endfor
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="input-modal">
            <div class="modal-layout">
                <img class="input-modal-check" src="{{ asset('public/img/ic_check.png') }}" alt="">
                <img class="input-modal-close" src="{{ asset('public/img/ic_modal_close.png') }}" alt="">
                <textarea class="input-modal-content" name="" id="input_textarea" cols="30" rows="15"></textarea>
            </div>
        </div>




        <!-- Modal -->
        <div class="modal fade" id="modalImageView" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document"
                style="max-width : 640px; min-width: 640px">
                <div class="modal-content" style="width:640px;">
                    <div class="modal-body">
                        <img src="" alt="" class="img_view" id="img_view1">

                    </div>
                </div>
            </div>
        </div>
</body>
