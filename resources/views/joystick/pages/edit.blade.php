@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <p class="text-right">
    <a href="/{{ $lang }}/admin/pages" class="btn btn-primary"><i class="material-icons md-18">arrow_back</i></a>
  </p>

  <div class="row">
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-body">
          <form action="{{ route('pages.update', [$lang, $page->id]) }}" method="post" id="postForm">
            <input type="hidden" name="_method" value="PUT">
            {!! csrf_field() !!}

            <div class="form-group">
              <label for="title">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ (old('title')) ? old('title') : $page->title }}" required>
            </div>
            <div class="form-group">
              <label for="slug">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" maxlength="80" value="{{ (old('slug')) ? old('slug') : $page->slug }}">
            </div>
            <div class="form-group">
              <label for="page_id">Категории</label>
              <select id="page_id" name="page_id" class="form-control">
                <option value="NULL"></option>
                <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $page) { ?>
                  <?php foreach ($nodes as $node) : ?>
                    <?php if ($node->id == $page->parent_id) : ?>
                      <option value="{{ $node->id }}" selected>{{ PHP_EOL.$prefix.' '.$node->title }}</option>
                    <?php else : ?>
                      <option value="{{ $node->id }}">{{ PHP_EOL.$prefix.' '.$node->title }}</option>
                    <?php endif; ?>
                    <?php $traverse($node->children, $prefix.'___'); ?>
                  <?php endforeach; ?>
                <?php }; ?>
                <?php $traverse($pages); ?>
              </select>
            </div>
            <div class="form-group">
              <label for="image">Картинка</label>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button" data-toggle="modal" data-target="#filemanager"><i class="material-icons md-18">folder</i> Выбрать</button>
                </span>
                <input type="text" class="form-control" id="image" name="image" maxlength="80" value="{{ (old('image')) ? old('image') : $page->image }}">
              </div>

              <!-- Filemanager -->
              <div class="modal fade" id="filemanager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Файловый менеджер</h4>
                    </div>
                    <div class="modal-body">
                      <iframe src="<?= url($lang.'/admin/filemanager'); ?>" frameborder="0" style="width:100%;min-height:600px"></iframe>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="sort_id">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $page->sort_id }}">
            </div>
            <div class="form-group">
              <label for="meta_title">Мета название (краткий заголовок, который отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_title" name="meta_title" maxlength="255" value="{{ (old('meta_title')) ? old('meta_title') : $page->meta_title }}">
            </div>
            <div class="form-group">
              <label for="meta_description">Мета описание (краткое описание страницы, которое отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ (old('meta_description')) ? old('meta_description') : $page->meta_description }}">
            </div>
            <div class="form-group">
              <label for="content">Контент</label>
              <textarea class="form-control" id="editor" name="content" rows="5">{{ (old('content')) ? old('content') : $page->content }}</textarea>
            </div>
            <div class="form-group">
              <label for="lang">Язык</label>
              <select id="lang" name="lang" class="form-control" required>
                <option value=""></option>
                @foreach($languages as $language)
                  @if ($page->lang == $language->slug)
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
                <input type="checkbox" id="status" name="status" @if ($page->status == 1) checked @endif> Активен
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
  <link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">
@endsection

@section('scripts')
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
        // ['imageGallery'],  // You must add the "imageGalleryUrl".
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
@endsection
