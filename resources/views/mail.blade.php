<div style="color:black; background-color:white;">
    {{ $name }}様
    <br>
    <br>
    この度はBOOKSTOREをご利用いただきまして誠にありがとうございます。
    <br>
    下記の内容をご確認ください。
    <br>
    <br>
    <hr>
    ご注文内容
    <hr>
    ご注文日：{{ $order_date }}
    <br>
    ご注文商品：{{ $total_quantity }}点
    <hr>
    <table>
        <tr>
            <td style="text-align: center;">商品名</td>
            <td style="text-align: right;">　　数量</td>
            <td style="text-align: right;">　　価格(税抜)</td>
            <td style="text-align: right;">　　小計(税抜)</td>
        </tr>
        <tr>
            <td>
                <hr>
            </td>
            <td>
                <hr>
            </td>
            <td>
                <hr>
            </td>
            <td>
                <hr>
            </td>
        </tr>
        @foreach( $carts as $cart)
        <tr>
            <td style="text-align: center;">
                {{ $cart->name }}
            </td>
            <td style="text-align: right;">
                {{ $cart->quantity }}
            </td>
            <td style="text-align: right;">
                {{ $cart->price }}円</td>
            <td style="text-align: right;">
                {{ $cart->price * $cart->quantity }}円
            </td>
        </tr>
        @endforeach
        <tr>
            <td>
                <hr>
            </td>
            <td>
                <hr>
            </td>
            <td>
                <hr>
            </td>
            <td>
                <hr>
            </td>
        </tr>
        <tr style="">
            <td style=""></td>
            <td style=""></td>
            <td style=" text-align: right;">　　小計(税抜)</td>
            <td style=" text-align: right;">{{ $sub_total }}円</td>
        </tr>
        <tr style="">
            <td style=""></td>
            <td style=""></td>
            <td style="text-align: right;">消費税</td>
            <td style="text-align: right;">{{ floor($sub_total * 0.1) }}円</td>
        <tr>
            <td>
                <hr>
            </td>
            <td>
                <hr>
            </td>
            <td>
                <hr>
            </td>
            <td>
                <hr>
            </td>
        </tr>
        <tr style="">
            <td style=""></td>
            <td style=""></td>
            <td style="text-align: right;">合計</td>
            <td style="text-align: right;">{{ floor($sub_total * 1.1) }}円</td>
        </tr>
    </table>
    <hr>
    <br>
    <br>
    発送手配が整い次第、別途メールにてご連絡いたします。
    <br>
    <br>
    WEB：https://bookstore2101.herokuapp.com/
</div>