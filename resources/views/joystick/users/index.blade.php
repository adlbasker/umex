@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Пользователи</h2>

  @include('components.alerts')

  <form action="/{{ $lang }}/admin/users/search/user" method="get">
    <div class="row">
      <div class="col-md-4">
        <div class="input-group">
          <input type="search" class="form-control input-xs typeahead-goods" name="text" value="{{ $_GET['text'] ?? '' }}" placeholder="Поиск...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
          </span>
        </div>
      </div>
      <div class="col-md-6">
        <div class="btn-group" role="group" aria-label="...">
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php $roleTitle = 'Роли'; ?>
              {{  (isset($_GET['role_id'])) ? $roles->firstWhere('id', $_GET['role_id'])->description : $roleTitle }} <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-category">
              <?php foreach ($roles as $role) : ?>
                <li>
                  <a href="#">
                    <label><input type="radio" name="role_id" value="{{ $role->id }}"> {{ $role->description }}</label>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php $regionTitle = 'Регионы';  ?>
              {{  (isset($_GET['region_id'])) ? $regions->firstWhere('id', $_GET['region_id'])->title : $regionTitle }} <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-category">
              <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $lang) { ?>
                <?php foreach ($nodes as $node) : ?>
                  <li>
                    <a href="#">
                      <label><input type="radio" name="region_id" value="{{ $node->id }}"> {{ PHP_EOL.$prefix.' '.$node->title }}</label>
                    </a>
                  </li>
                  <?php $traverse($node->children, $prefix.'___'); ?>
                <?php endforeach; ?>
              <?php }; ?>
              <?php $traverse($regions->toTree()); ?>
            </ul>
          </div>
          <a href="/{{ $lang }}/admin/users" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-refresh"></span></a>
        </div> 
      </div>
    </div>
  </form><br>

  <div class="table-responsive">
    <table class="table table-striped table-condensed">
      <thead>
        <tr class="active">
          <td>№</td>
          <td>Имя</td>
          <td>Email</td>
          <td>Номер телефона</td>
          <td>Регион</td>
          <td>Роль</td>
          <td class="text-right">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach($users as $user)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $user->name.' '.$user->lastname }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->tel }}</td>
            <td>{{ $user->region->title ?? '' }}</td>
            <td>
              @foreach($user->roles as $role)
                {{ $role->name }}<br>
              @endforeach
            </td>
            <td class="text-right text-nowrap">
              <a class="btn btn-link btn-xs" href="{{ route('users.edit', [$lang, $user->id]) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
              <form method="POST" action="{{ route('users.destroy', [$lang, $user->id]) }}" accept-charset="UTF-8" class="btn-delete">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-link btn-xs" onclick="return confirm('Удалить запись?')"><i class="material-icons md-18">clear</i></button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $users->links() }}

@endsection
