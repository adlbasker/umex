@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Добавление</h2>

  @include('components.alerts')
  <p class="text-right">
    <a href="/{{ $lang }}/admin/sections" class="btn btn-primary"><i class="material-icons md-18">arrow_back</i></a>
  </p>

  <div class="row">
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-body">
          <form action="{{ route('sections.store', $lang) }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="title">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ (old('title')) ? old('title') : '' }}" required>
            </div>
            <div class="form-group">
              <label for="slug">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ (old('slug')) ? old('slug') : '' }}">
            </div>
            <div class="form-group">
              <label for="sort_id">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : NULL }}">
            </div>
            <div class="form-group">
              <label for="meta_title">Мета название (краткий заголовок, который отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_title" name="meta_title" maxlength="255" value="{{ (old('meta_title')) ? old('meta_title') : '' }}">
            </div>
            <div class="form-group">
              <label for="meta_description">Мета описание (краткое описание страницы, которое отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ (old('meta_description')) ? old('meta_description') : '' }}">
            </div>
            <div id="keyValue">
              <div class="form-group row">
                <div class="col-md-3">
                  <label for="key_1">Название</label>
                  <input type="text" class="form-control" id="key_1" name="data[key][]" maxlength="255" value="{{ (old('key_1')) ? old('key_1') : '' }}">
                </div>
                <div class="col-md-5">
                  <label for="value_1">Значение. Разделитель /</label>
                  <input type="text" class="form-control" id="value_1" name="data[value][]" maxlength="255" value="{{ (old('value_1')) ? old('value_1') : '' }}">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <label for="key_2">Название</label>
                  <input type="text" class="form-control" id="key_2" name="data[key][]" maxlength="255" value="{{ (old('key_2')) ? old('key_2') : '' }}">
                </div>
                <div class="col-md-5">
                  <label for="value_2">Значение. Разделитель /</label>
                  <input type="text" class="form-control" id="value_2" name="data[value][]" maxlength="255" value="{{ (old('value_2')) ? old('value_2') : '' }}">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <label for="key_3">Название</label>
                  <input type="text" class="form-control" id="key_3" name="data[key][]" maxlength="255" value="{{ (old('key_3')) ? old('key_3') : '' }}">
                </div>
                <div class="col-md-5">
                  <label for="value_3">Значение. Разделитель /</label>
                  <input type="text" class="form-control" id="value_3" name="data[value][]" maxlength="255" value="{{ (old('value_3')) ? old('value_3') : '' }}">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="content">Контент</label>
              <textarea class="form-control " id="content" name="content" rows="10">{{ (old('content')) ? old('content') : '' }}</textarea>
            </div>
            <div class="form-group">
              <label for="lang">Язык</label>
              <select id="lang" name="lang" class="form-control" required>
                @foreach($languages as $language)
                  @if (old('lang') == $language->slug)
                    <option value="{{ $language->slug }}" selected>{{ $language->title }}</option>
                  @else
                    <option value="{{ $language->slug }}">{{ $language->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="status">Статус:</label>
              <label>
                <input type="checkbox" id="status" name="status" checked> Активен
              </label>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success"><i class="material-icons">save</i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('head')

@endsection

@section('scripts')

@endsection