@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')



<div class="d-flex align-items-center mb-5">
    <h1>Список городов</h1>
    <a href="{{ route('admin.cities.add') }}" class="btn btn-primary ms-2">Добавить</a>
</div>

<div class="table-responsive">
  <table class="table table-striped table-hover">
      <thead class="table-dark">
          <tr>
              <th>ID</th>
              <th>Название</th>
              <th>Дата добавления</th>
              <th>Дата редактирования</th>
              <th>Действия</th>
          </tr>
      </thead>
      <tbody>

        @foreach($cities as $city)
          <tr>
            <td>{{ $city->id }}</td>
            <td>{{ $city->name }}</td>
            <td>{{ $city->created_at }}</td>
            <td>{{ $city->updated_at }}</td>
            <td>
                <a href="{{route('admin.cities.update', $city->id )}}" class="btn btn-sm btn-warning me-2">Редактировать</a>
                <form class="d-inline-block" method="post" action="{{route('admin.cities.delete', ['city' => $city])}}">
                  @csrf
                  @method('delete')
                <input type="submit" value="Удалить" class="btn btn-sm btn-danger"/>
                </form>
            </td>
        </tr>
        @endforeach
      </tbody>
  </table>
</div>




@endsection
