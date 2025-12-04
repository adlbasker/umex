@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <div class="row">
    <div class="col-md-6">
      <ul class="nav nav-tabs">
        @foreach ($languages as $language)
          <li role="presentation" @if ($language->slug == $productLang->lang) class="active" @endif><a href="/{{ $language->slug }}/admin/products/{{ $product->id }}/edit">{{ $language->title }}</a></li>
        @endforeach
        <!-- <li role="presentation"><a href="/{{ $lang }}/admin/products/{{ $product->id }}/comments">Коментарии</a></li> -->
      </ul>
    </div>
    <div class="col-md-6">
      <p class="text-right">
        <a href="/{{ $lang }}/admin/products" class="btn btn-primary btn-sm">Назад</a>
      </p>
    </div>
  </div><br>

  <form action="/{{ $lang }}/admin/products/{{ $product->id }}" method="POST" id="postForm" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    {!! csrf_field() !!}
    <div class="row">
      <div class="col-md-7">
        <div class="panel panel-default">
          <div class="panel-heading">Основная информация</div>
          <div class="panel-body">
            <div class="form-group">
              <label for="title">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="255" value="{{ (old('title')) ? old('title') : $productLang->title }}" required>
            </div>
            <div class="form-group">
              <label for="slug">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="255" value="{{ (old('slug')) ? old('slug') : $productLang->slug }}">
            </div>
            <div class="form-group">
              <label for="meta_title">Мета название (краткий заголовок, который отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_title" name="meta_title" maxlength="255" value="{{ (old('meta_title')) ? old('meta_title') : $productLang->meta_title }}">
            </div>
            <div class="form-group">
              <label for="meta_description">Мета описание (краткое описание страницы, которое отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ (old('meta_description')) ? old('meta_description') : $productLang->meta_description }}">
            </div>
            <div class="form-group">
              <label for="description">Описание</label>
              <textarea class="form-control" id="editor" name="description" rows="6" maxlength="2000">{{ (old('description')) ? old('description') : $productLang->description }}</textarea>
            </div>
            <div class="form-group">
              <label for="characteristic">Адрес</label>
              <input type="text" class="form-control" id="characteristic" name="characteristic" minlength="2" maxlength="80" value="{{ (old('characteristic')) ? old('characteristic') : $productLang->characteristic }}">
            </div>
            <div class="form-group">
              <label for="sort_id">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $product->sort_id }}">
            </div>
            <div class="form-group">
              <label for="barcodes">Артикул</label>
              <input type="text" class="form-control" id="barcodes" name="barcodes" value="{{ (old('barcodes')) ? old('barcodes') : $product->barcodes }}">
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="area">Площадь (участок)</label>
                  <input type="text" class="form-control" id="area" name="area" maxlength="10" value="{{ (old('area')) ? old('area') : $product->area }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="area_total">Площадь (общая)</label>
                  <input type="text" class="form-control" id="area_total" name="area_total" maxlength="10" value="{{ (old('area_total')) ? old('area_total') : $product->capacity }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="price">Цена за кв. м.</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="price" name="price" maxlength="10" value="{{ (old('price')) ? old('price') : $productLang->price }}">
                    <div class="input-group-addon">{{ $currency->symbol }}</div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="price_total">Цена</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="price_total" name="price_total" maxlength="10" value="{{ (old('price_total')) ? old('price_total') : $productLang->price_total }}">
                    <div class="input-group-addon">{{ $currency->symbol }}</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="count">Количество</label>
              <input type="number" class="form-control" id="count" name="count" minlength="5" maxlength="80" value="{{ (old('count')) ? old('count') : $product->count }}">
            </div>
            <div class="form-group">
              <label for="condition">Условие</label><br>
              <label class="radio-inline">
                <input type="radio" name="condition" value="1" @if ($product->condition == '1') checked @endif> Продажа
              </label>
              <label class="radio-inline">
                <input type="radio" name="condition" value="2" @if ($product->condition == '2') checked @endif> Аренда
              </label>
            </div>
            <div class="form-group" id="gallery">
              <label>Галерея</label><br>
              <?php $images = ($product->images == true) ? unserialize($product->images) : []; ?>
              <?php $key_last = array_key_last($images); ?>
              @for ($i = 0; $i <= (($key_last >= 6) ? $key_last : 5); $i++)
                @if(array_key_exists($i, $images))
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width:300px;height:200px;">
                      <img src="/img/products/{{ $product->path.'/'.$images[$i]['present_image'] }}">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>
                    <div>
                      <span class="btn btn-default btn-sm btn-file">
                        <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Изменить</span>
                        <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                        <input type="file" name="images[]" accept="image/*">
                      </span>
                      <label>
                        <input type="checkbox" name="remove_images[]" value="{{ $i }}"> Удалить
                      </label>
                      <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
                    </div>
                  </div>
                @else
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>
                    <div>
                      <span class="btn btn-default btn-sm btn-file">
                        <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Выбрать</span>
                        <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                        <input type="file" name="images[]" accept="image/*">
                      </span>
                      <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
                    </div>
                  </div>
                @endif
              @endfor
            </div>
            <div>
              <button type="button" class="btn btn-success" onclick="addFileinput(this);">Добавить загрузчик</button>
            </div>
            <br>
            <div class="form-group">
              <label for="lang">Язык</label>
              <select id="lang" name="lang" class="form-control" required>
                @foreach($languages as $language)
                  @if ($language->slug == $productLang->lang)
                    <option value="{{ $language->slug }}" selected>{{ $language->title }}</option>
                  @else
                    <option value="{{ $language->slug }}">{{ $language->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="status">Статус</label>
              @foreach(trans('statuses.data') as $num => $status)
                <br>
                <label>
                  <input type="radio" id="status" name="status" value="{{ $num }}" @if ($num == $product->status) checked @endif> {{ $status['title'] }}
                </label>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">Параметры</div>
          <div class="panel-body">
            <div class="form-group">
              <label for="company_id">Компания</label>
              <select id="company_id" name="company_id" class="form-control">
                <option value=""></option>
                @foreach($companies as $company)
                  @if ($company->id == $product->company_id)
                    <option value="{{ $company->id }}" selected>{{ $company->title }}</option>
                  @else
                    <option value="{{ $company->id }}">{{ $company->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <p><b>Категории</b></p>
            <div class="panel panel-default">
              <div class="panel-body" style="max-height: 250px; overflow-y: auto;">
                <?php foreach ($categories as $category) : ?>
                  <div class="radio">
                    <label>
                      <input type="radio" name="category_id" value="{{ $category->id }}" <?php if ($productLang->category_id == $category->id) echo "checked"; ?> required> {{ $category->title }}
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <p><b>Опции</b></p>
            <div class="panel panel-default">
              <div class="panel-body" style="max-height: 250px; overflow-y: auto;">
                <?php $grouped = $options->groupBy('data'); ?>
                @forelse ($grouped as $data => $group)
                  <?php $data = json_decode($data, true); ?>
                  <p><b>{{ $data[$lang]['data'] }}</b></p>
                  @foreach ($group as $option)
                    <?php $titles = json_decode($option->title, true); ?>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="options_id[]" value="{{ $option->id }}" @if ($product->options->contains($option->id)) checked @endif> {{ $titles[$lang]['title'] }}
                      </label>
                    </div>
                  @endforeach
                @endforeach
              </div>
            </div>
            <p><b>Режимы</b></p>
            <div class="panel panel-default">
              <div class="panel-body" style="max-height: 150px; overflow-y: auto;">
                @foreach($modes as $mode)
                  <?php $titles = unserialize($mode->title); ?>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="modes_id[]" value="{{ $mode->id }}" <?php if ($product->modes->contains($mode->id)) echo "checked"; ?>> {{ $titles[$lang]['title'] }}
                    </label>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">Обновить</button>
    </div>
  </form>
@endsection

@section('head')
  <link href="/joystick/css/jasny-bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/joystick/js/jasny-bootstrap.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/suneditor.min.js"></script>
  <script>
    // ID or DOM object
    const editor = SUNEDITOR.create((document.getElementById('editor') || 'editor'),{
      // All of the plugins are loaded in the "window.SUNEDITOR" object in dist/suneditor.min.js file
      // Insert options
      buttonList: [
        ['undo', 'redo'],
        ['font', 'fontSize', 'formatBlock'],
        ['paragraphStyle', 'blockquote'],
        ['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript'],
        ['fontColor', 'hiliteColor', 'textStyle', 'removeFormat'],
        ['outdent', 'indent'],
        ['align', 'horizontalRule', 'list', 'lineHeight'],
        ['table', 'link', 'image', 'video', 'audio' /** ,'math' */], // You must add the 'katex' library at options to use the 'math' plugin.
        /** ['imageGallery'] */ // You must add the "imageGalleryUrl".
        ['fullScreen', 'showBlocks', 'codeView'],
        ['preview', 'print'],
        ['save', 'template'],
        /** ['dir', 'dir_ltr', 'dir_rtl'] */ // "dir": Toggle text direction, "dir_ltr": Right to Left, "dir_rtl": Left to Right
      ]
    });
    editor.setOptions({
      minHeight: '300px'
    });
    editor.setDefaultStyle('font-family: Arial; font-size: 15px;');

    const form = document.getElementById('postForm');

    form.addEventListener('submit', function() {
        editor.save();
    });
  </script>
  <script>
    function addFileinput(i) {
      var fileinput = 
        '<div class="fileinput fileinput-new" data-provides="fileinput">' +
            '<div class="fileinput-preview thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>' +
            '<div>' +
              '<span class="btn btn-default btn-sm btn-file">' +
                '<span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Выбрать</span>' +
                '<span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>' +
                '<input type="file" name="images[]" accept="image/*">' +
              '</span>' +
              '<a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>' +
            '</div>' +
          '</div>';

      $('#gallery').append(fileinput);
    }
  </script>
@endsection
