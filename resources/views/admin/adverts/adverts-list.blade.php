@extends('layouts.admin-layout')

@section('title', 'Home')

@section('content')



<div class="d-flex align-items-center mb-5">
    <h1>Список рекламный кампаний</h1>
    <a href="{{ route('admin.adverts.add') }}" class="btn btn-primary ms-2">Добавить</a>
</div>

<div class="table-responsive">
  <table class="table table-striped table-hover">
      <thead class="table-dark">
          <tr>
              <th>ID</th>
              <th>Название места</th>
              <th>Тип рекламы</th>
              <th>Дата начала камнании</th>
              <th>Дата конца кампании</th>
              <th>Действия</th>
          </tr>
      </thead>
      <tbody>

        @foreach($adverts as $elem)
          <tr>
            <td>{{ $elem->id }}</td>
            <td>{{ $elem->place->name }}</td>
            <td>{{ $elem->type->name }}</td>
            <td>{{ $elem->starts_at }}</td>
            <td>{{ $elem->ends_at }}</td>
            <td>
                <a href="{{route('admin.adverts.update', $elem->id )}}" class="btn btn-sm btn-warning me-2">Редактировать</a>
                <form class="d-inline-block" method="post" action="{{route('admin.adverts.delete', ['advertisingCampaign' => $elem])}}">
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
