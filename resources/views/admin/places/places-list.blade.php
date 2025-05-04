@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')



<div class="d-flex align-items-center mb-2">
    <h1>Список заведений</h1>
</div>
<a class="btn mb-3 btn-primary" href="{{ route('admin.places.add') }}">Добавить</a>

<div class="table-responsive">
  <table class="table table-hover align-middle table-striped">
      <thead class="table-dark">
          <tr>
              <th scope="col">ID</th>
              <th class="image-cell" scope="col">Изображение</th>
              <th scope="col">Название</th>
              <th scope="col">Дата создания</th>
              <th scope="col">Дата редактирования</th>
              <th scope="col">Действия</th>
          </tr>
      </thead>
      <tbody>
        @foreach($places as $place)
        <tr>
          <th scope="row">{{ $place->id }}</th>
          <td>
              @if($place->thumb_image_src	== null)
              <img class="img-thumbnail-list" src="/img/admin/no-image.png" alt="Изображение" class="img-thumbnail img-thumbnail-list">
              @else
              <img class="img-thumbnail-list" src="/{{ $place->thumb_image_src }}" alt="Изображение" class="img-thumbnail img-thumbnail-list">
              @endif
          </td>
          <td>{{ $place->name }}</td>
          <td>{{ $place->created_at }}</td>
          <td>{{ $place->updated_at }}</td>
          <td>
              <div class="d-flex gap-2 align-items-center w-100 justify-content-center">
                <a href="{{route('admin.places.update', $place->id )}}" class="btn btn-sm btn-primary me-2">Редактировать</a>
                <form class="d-inline-block" method="post" action="{{route('admin.places.replicate.store', ['place' => $place])}}">
                  @csrf
                  @method('post')
                <input type="submit" value="Копировать" class="btn btn-sm btn-dark"/>
                </form>
                <form class="d-inline-block" method="post" action="{{route('admin.places.delete', ['place' => $place])}}">
                  @csrf
                  @method('delete')
                <input type="submit" value="Удалить" class="btn btn-sm btn-danger"/>
                </form>
              </div>
          </td>
      </tr>
        @endforeach
      </tbody>
  </table>
</div>

<style>
  .img-thumbnail-list {
            max-width: 110px;
            height: auto;
            object-fit: cover;
        }
        
        /* Фиксируем ширину колонки с изображением */
        .image-cell {
            width: 120px; /* Немного больше, чем изображение, для отступов */
        }
        
        /* Центрируем все ячейки таблицы */
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
        
        /* Центрируем кнопки действий */
        .actions-cell {
            display: flex;
            justify-content: center;
        }
</style>


@endsection
