@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')



<div class="d-flex align-items-center">
    <h1 class="mb-3">Список кухонь</h1>
    <a href="{{ route('admin.kitchens.add') }}" class="btn btn-primary ms-2">Добавить</a>
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

        @foreach($data as $kitchen)
          <tr>
            <td>{{ $kitchen->id }}</td>
            <td>{{ $kitchen->name }}</td>
            <td>{{ $kitchen->created_at }}</td>
            <td>{{ $kitchen->updated_at }}</td>
            <td>
                <a href="{{route('admin.kitchens.update', $kitchen->id )}}" class="btn btn-sm btn-warning me-2">Редактировать</a>
                <form class="d-inline-block" method="post" action="{{route('admin.kitchens.delete.store', ['Kitchen' => $kitchen])}}">
                  @csrf
                  @method('delete')
                <input type="submit" value="Удалить" class="btn btn-sm btn-danger"/>
                </form>
                {{-- <a href="#" class="btn btn-sm btn-danger">Удалить</a> --}}
            </td>
        </tr>
        @endforeach
      </tbody>
  </table>
</div>







@endsection
