@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')

<h1>Общие настройки</h1>

<form action="">
    <table class="form-table">
        <tbody>
        @foreach($data as $option)
            <tr>
                <th scope="row"><label for="blogname">{{ $option->name }}</label></th>
                <td><input name="blogname" type="text" id="blogname" value="{{ $option->value }}" class="form-control regular-text"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <button class="btn btn-primary mt-3" type="submit">Сохранить</button>
</form>
@endsection
