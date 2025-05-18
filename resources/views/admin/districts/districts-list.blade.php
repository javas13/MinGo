@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')



<div class="d-flex align-items-center mb-5">
    <h1>Список районов</h1>
    <a href="{{ route('admin.districts.add') }}" class="btn btn-primary ms-2">Добавить</a>
</div>

<div class="table-responsive">
  <table class="table table-striped table-hover">
      <thead class="table-dark">
          <tr>
              <th>ID</th>
              <th>Название</th>
              <th>Город</th>
              <th>Дата добавления</th>
              <th>Дата редактирования</th>
              <th>Действия</th>
          </tr>
      </thead>
      <tbody>

        @foreach($districts as $district)
          <tr>
            <td>{{ $district->id }}</td>
            <td>{{ $district->name }}</td>
            <td>{{ $district->city->name }}</td>
            <td>{{ $district->created_at }}</td>
            <td>{{ $district->updated_at }}</td>
            <td>
                <a href="{{route('admin.districts.update', $district->id )}}" class="btn btn-sm btn-warning me-2">Редактировать</a>
                <form class="d-inline-block" method="post" action="{{route('admin.districts.delete', ['district' => $district])}}">
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
