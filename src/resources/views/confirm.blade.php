@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/confirm.css')}}">
@endsection

@section('content')
<h1 class="page-title">Confirm</h1>

<div class="confirm-table">
    <form action="/store" method="post">
        @csrf

        <table class="confirm-table">

            <tr class="table-line">
                <th class="column-name">お名前</th>
                <td class="table-cell">
                    <input class="read-input" type="text" value="{{ $fullName }}" readonly>
                    <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
                    <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
                </td>
            </tr>

            <tr class="table-line">
                <th class="column-name">性別</th>
                <td class="table-cell">
                    <input class="read-input" type="text" value="{{ $genderText }}" readonly>
                    <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
                </td>
            </tr>

            <tr class="table-line">
                <th class="column-name">メールアドレス</th>
                <td class="table-cell">
                    <input class="read-input" type="email" value="{{ $contact['email'] }}" readonly>
                    <input type="hidden" name="email" value="{{ $contact['email'] }}">
                </td>
            </tr>

            <tr class="table-line">
                <th class="column-name">電話番号</th>
                <td class="table-cell">
                    <input class="read-input" type="text" value="{{ $entireTel }}" readonly>
                    <input type="hidden" name="front-tel" value="{{ $contact['front-tel'] }}">
                    <input type="hidden" name="middle-tel" value="{{ $contact['middle-tel'] }}">
                    <input type="hidden" name="back-tel" value="{{ $contact['back-tel'] }}">
                </td>
            </tr>

            <tr class="table-line">
                <th class="column-name">住所</th>
                <td class="table-cell">
                    <input class="read-input" type="text" value="{{ $contact['address'] }}" readonly>
                    <input type="hidden" name="address" value="{{ $contact['address'] }}">
                </td>
            </tr>

            <tr class="table-line">
                <th class="column-name">建物名</th>
                <td class="table-cell">
                    <input class="read-input" type="text" value="{{ $contact['building'] }}" readonly>
                    <input type="hidden" name="building" value="{{ $contact['building'] }}">
                </td>
            </tr>

            <tr class="table-line">
                <th class="column-name">お問い合わせの種類</th>
                <td class="table-cell">
                    <input class="read-input" type="text" value="{{ $categoryName }}" readonly>
                    <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
                </td>
            </tr>

            <tr class="table-line">
                <th class="column-name">お問い合わせ内容</th>
                <td class="table-cell">
                    <textarea class="read-input" readonly>{{ $contact['detail'] }}</textarea>
                    <input type="hidden" name="detail" value="{{ $contact['detail'] }}">
                </td>
            </tr>

        </table>

        <div class="buttons">
            <button class="toThanks" type="submit" name="action" value="post">送信</button>
            <button class="toFix" type="submit" name="action" value="modify">修正</button>
        </div>

    </form>
</div>
@endsection