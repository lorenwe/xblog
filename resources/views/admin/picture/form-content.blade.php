
<div class="row">
    <div class="col-8">
        <div class="form-group">
            <label for="title" class="form-control-label">文章标题*</label>
            <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                   value="{{ isset($picture) ? $picture->title : old('title') }}"
                   autofocus>
            @if ($errors->has('title'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('title') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="description" class="form-control-label">文章描述</label>

            <textarea id="post-description-textarea" style="resize: vertical;" rows="3" spellcheck="false"
                      id="description" class="form-control autosize-target{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="支持 Markdown 格式"
                      name="description">{{ isset($picture) ? $picture->description : old('description') }}</textarea>

            @if ($errors->has('description'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('description') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="col-4">
        <label for="title" class="form-control-label">封面图片*</label>
        <div class="slim"
             data-service="{{ route('picture.thumbnail', ['_token' => csrf_token(), 'picture_id' => $picture->id]) }}"
             data-will-remove="imageWillBeRemoved"
             {{--data-instant-edit="true"
             data-push="true"--}}
             data-ratio="3:2"
             data-label="点击选择图片"
             data-size="360,240"
             data-max-file-size="2"
             data-button-confirm-label="确定"
             data-button-confirm-title="确定"
             data-button-cancel-label="取消"
             data-button-cancel-title="取消"
             data-button-edit-title="编辑"
             data-button-remove-title="清除"
             data-button-download-title="下载"
             data-button-rotate-title="旋转"
             data-button-upload-title="上传"
             data-status-image-too-small="这张照片太小了,最小的大小是360*240像素"
             style="width: 360px;height: 240px;margin: auto;">
             @if ($picture->thumbnail)
                <img src="{{ $picture->thumbnail }}" alt=""/>
             @endif
             <input type="file" name="slim[]" />
        </div>
    </div>
</div>


<div class="form-group">
    <label for="post-content-textarea" class="form-control-label">文章内容*</label>
    <textarea data-save-id="{{ isset($picture)?'post.edit.'.$picture->id.'.by@' . request()->ip():'picture.save' }}" id="simplemde-textarea"
              class="form-control{{ $errors->has('content') ? ' is-invalid ' : ' ' }}"
              name="content"
              spellcheck="false"
              rows="36"
              placeholder="请使用 Markdown 格式书写"
              style="resize: vertical">{{ isset($picture) ? $picture->content : old('content') }}</textarea>
    @if($errors->has('content'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('content') }}</strong>
        </div>
    @endif
</div>

<div class="form-group">
    <div class="radio radio-inline">
        <label>
            <input type="radio"
                   {{ (isset($picture)) && $picture->status == 1 ? ' checked ':'' }}
                   name="status"
                   value="1">发布
        </label>
    </div>
    <div class="radio radio-inline">
        <label>
            <input type="radio"
                   {{ (!isset($picture)) || $picture->status == 0 ? ' checked ':'' }}
                   name="status"
                   value="0">草稿
        </label>
    </div>
</div>
{{ csrf_field() }}