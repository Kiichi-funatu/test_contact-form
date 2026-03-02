@extends('layouts.authapp')


@section('css')
<link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection

@section('header')
@if(Auth::check())
<form action="/logout" method="post">
    @csrf
    <button type="submit" class="logout">Logout</button>
</form>
@endif
@endsection

@section('content')
<h1 class="page-title">Admin</h1>
<div class="contains">
    <form action="/search" method="get">
        @csrf
        <div class="search-form">
            <div class="name-email">
                <input name="name_email_filter" type="text" class="name_email_filter" placeholder="名前やメールアドレスを入力してください">
                <input type="submit" value="🔍" class="search-button">
            </div>
            <div class="gender">
                <select name="gender_dropdown" class="gender_dropdown">
                    <option selected disabled>性別</option>
                    <option value="0">全て</option>
                    <option value="1">男性</option>
                    <option value="2">女性</option>
                    <option value="3">その他</option>
                </select>
            </div>
            <div class="category_id">
                <select name="category_dropdown" class="category_dropdown">
                    <option value="0">全て</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->content }}</option>
                    @endforeach
                </select>
            </div>
            <div class="date">
                <input type="date" name="date_calendar" class="date_calendar">
            </div>
        </div>
    </form>
    <div class="contacts-table">
        <div class="above-table">
            <form action="/export" method="get">
                @csrf
                <button type="submit" class="export">エクスポート</button>
            </form>
            <div class="pagination">
                {{$contacts->appends(request()->query())->links()}}
            </div>
        </div>
        <table class="contacts-database" cellspacing="0">
            <tr>
                <th class="column-name">お名前</th>
                <th class="column-name">性別</th>
                <th class="column-name">メールアドレス</th>
                <th class="column-name">お問い合わせの種類</th>
                <th class="column-name"></th>
                <th class="column-name"></th>
            </tr>
            @foreach($contacts as $contact)
            <tr>
                <td class="name_get{{$contact['id']}} name_get">{{$contact['last_name']}}{{$contact['first_name']}}</td>
                <td class="gender_get{{$contact['id']}} gender_get">{{$contact['gender']}}</td>
                <td class="email_get{{$contact['id']}} email_get">{{$contact['email']}}</td>
                <td class="category_get{{$contact['id']}} category_get">{{$contact->category->getCategory()}}</td>
                <td class="created_get">
                    {{ $contact['created_at']->format('Y-m-d') }}
                </td>
                <td class="detail_get">
                    <div class="detail-view" id="{{$contact['id']}}">
                        詳細
                    </div>
                </td>
                <div class="hidden-column">
                    <p class="tel_get{{$contact['id']}}">{{$contact['tel']}}</p>
                    <p class="address_get{{$contact['id']}}">{{$contact['address']}}</p>
                    <p class="building_get{{$contact['id']}}">{{$contact['building']}}</p>
                    <p class="detail_get{{$contact['id']}}">{{$contact['detail']}}</p>
                </div>
            </tr>
            @endforeach
        </table>
        <!-- 以下モーダル -->
        <div class="modal">
            <div class="close-button">
                ×
            </div>
            <table class="modal-table">
                <tr>
                    <th class="modal-title">お名前</th>
                    <td class="full-name-modal modal-cell"></td>
                </tr>
                <tr>
                    <th class="modal-title">性別</th>
                    <td class="gender-modal modal-cell"></td>
                </tr>
                <tr>
                    <th class="modal-title">メールアドレス</th>
                    <td class="email-modal modal-cell"></td>
                </tr>
                <tr>
                    <th class="modal-title">電話番号</th>
                    <td class="tel-modal modal-cell"></td>
                </tr>
                <tr>
                    <th class="modal-title">住所</th>
                    <td class="address-modal modal-cell"></td>
                </tr>
                <tr>
                    <th class="modal-title">建物名</th>
                    <td class="building-modal modal-cell"></td>
                </tr>
                <tr>
                    <th class="modal-title">お問い合わせの種類</th>
                    <td class="category-modal modal-cell"></td>
                </tr>
                <tr>
                    <th class="modal-title detail-title">お問い合わせ内容</th>
                    <td class="detail-modal modal-cell"><textarea class="detail-text-modal"></textarea></td>
                </tr>
            </table>
            <div class="delete">
                <form action="/delete" method="post">
                    @csrf
                    <input name="id" type="hidden" value="" class="delete-id">
                    <button class="delete-button" type="submit">削除</button>
                </form>
            </div>
        </div>
        <div class="reset">
            <a href="/admin" class="reset-link">リセット</a>
        </div>
    </div>
</div>
@endsection