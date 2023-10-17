let isPaying         = false;
const stripe         = Stripe('pk_live_51LkdSrK3QFo9QamVUKgCZOzLShzkB8U0Wbm28btJM8wWxkHUhxlik3atfcfutIkGRMZA5eSwmYwjzQcwXXbYTFJ100yNXQGouV');
const stripeElements = stripe.elements();

const formElm       = document.querySelector('form');
const errorAlertElm = document.querySelector('#error-alert');

let cardNumberElm;

const emailElm         = document.querySelector('#email');
const nameElm          = document.querySelector('#name');
const kanaElm          = document.querySelector('#kana');
const zipCodeFirstElm  = document.querySelector('#postcodeFirst');
const zipCodeSecondElm = document.querySelector('#postcodeFirst');
const address1Elm      = document.querySelector('#address');
const address2Elm      = document.querySelector('#address2');
const phoneNumberElm   = document.querySelector('#cell');

const mountStripeElements = () => {
    cardNumberElm = stripeElements.create('cardNumber');
    
    cardNumberElm.mount('#card-number-wrapper > div > div');
    stripeElements.create('cardExpiry').mount('#card-expiration-wrapper > div > div');
    stripeElements.create('cardCvc').mount('#card-security-code-wrapper > div > div');
}

mountStripeElements();

formElm.addEventListener('submit', async (e) => {
    e.preventDefault();

    if (isPaying) {
        return;
    }
    isPaying = true;

    if (!validationForm()) {
        isPaying = false;
        return;
    }

    const result = await stripe.createToken(cardNumberElm);
    if (result.error) {
        isPaying = false;
        errorAlertElm.style.display = 'block';
        errorAlertElm.innerHTML = '<p>決済エラーが発生しました。<br>フォームを確認の上もう一度お試しください。</p>';
        scrollTo(0, 0);
        return;
    }

    const hiddenInputElm = document.createElement('input');
    hiddenInputElm.setAttribute('type', 'hidden');
    hiddenInputElm.setAttribute('name', 'stripeToken');
    hiddenInputElm.setAttribute('value', result.token.id);
    formElm.appendChild(hiddenInputElm);
    formElm.submit();
});

const validationForm = () => {
    errorAlertElm.innerHTML = '';

    if (!emailElm.value) {
        errorAlertElm.innerHTML += "<p>・メールアドレスは必須項目です<p>";
    }

    if (!nameElm.value) {
        errorAlertElm.innerHTML += "<p>・名前は必須項目です<p>";
    }

    if (!kanaElm.value) {
        errorAlertElm.innerHTML += "<p>・フリガナは必須項目です<p>";
    }

    if (!zipCodeFirstElm.value || !zipCodeSecondElm.value) {
        errorAlertElm.innerHTML += "<p>・郵便番号は必須項目です<p>";
    }

    if (!address1Elm.value) {
        errorAlertElm.innerHTML += "<p>・住所(都道府県 市区町村)は必須項目です<p>";
    }

    if (!address2Elm.value) {
        errorAlertElm.innerHTML += "<p>・住所(番地・部屋番号など)は必須項目です<p>";
    }

    if (!phoneNumberElm.value) {
        errorAlertElm.innerHTML += "<p>・電話番号は必須項目です<p>";
    }


    if (errorAlertElm.innerHTML !== '') {
        errorAlertElm.style.display = 'block';
        scrollTo(0, 0);
        return false;
    }

    errorAlertElm.style.display = 'none';
    return true;
}
