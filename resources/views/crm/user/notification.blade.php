@extends('layouts.crm')
@section('title', '全部通知')
@section('content')
<div class="container">
    <table class="rwd-table table table-hover">
        <thead>
            <tr class="bg-primary text-light text-center">
                <th>
                    picture
                </th>
                <th>
                    message
                </th>
                <th>
                    time
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($notifications as $n)
            <tr class="text-center">
                <td data-th="picture" class="align-middle">
                    <img src="{{ $n->data['data']['icon'] }}" alt="" class="avatar-sm">
                </td>
                <td data-th="message" class="align-middle">
                    <a href={{ $n->data['data']['link'] }}>{{ $n->data['data']['message'] }}</a>
                </td>
                <td data-th="time" class="align-middle">
                    {{ $n->created_at }}
                </td>
                @endforeach
        </tbody>
    </table>
</div>
@endsection
