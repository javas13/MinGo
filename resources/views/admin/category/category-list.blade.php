@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')



<div class="d-flex align-items-center">
    <h1 class="mb-3">Список категорий</h1>
    <a href="{{ route('admin.category.add') }}" class="btn btn-primary ms-2">Добавить</a>
</div>

<div class="table-responsive">
  <table class="table table-striped table-hover">
      <thead class="table-dark">
          <tr>
              <th>ID</th>
              <th>Название</th>
              <th>Порядок сортировки</th>
              <th>Дата добавления</th>
              <th>Дата редактирования</th>
              <th>Действия</th>
          </tr>
      </thead>
      <tbody>

        @foreach($data as $category)
          <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->sort_order }}</td>
            <td>{{ $category->created_at }}</td>
            <td>{{ $category->updated_at }}</td>
            <td>
                <a href="{{route('admin.category.update', $category->id )}}" class="btn btn-sm btn-warning me-2">Редактировать</a>
                <form class="d-inline-block" method="post" action="{{route('admin.category.delete.store', ['Category' => $category])}}">
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
