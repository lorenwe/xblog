@extends('admin.layouts.app')
@section('title', 'Edit '.$category->name)
@section('content')
    <div class="row justify-content-start">
        <div class="col-md-6">
            <form action="{{ route('category.update',$category->id) }}"
                  method="post">
                <div class="form-group">
                    <label for="name" class="control-label">分类名称</label>
                    <input id="name" type="text"
                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                           value="{{ $category->name }}"
                           autofocus>

                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="description" class="control-label">分类描述</label>
                    <textarea id="description" class="autosize-target form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{ $category->description }}</textarea>
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="cover_img" class="control-label">分类图片</label>
                    <input id="cover_img" type="text"
                           class="form-control{{ $errors->has('cover_img') ? ' is-invalid' : '' }}" name="cover_img"
                           value="{{ $category->cover_img }}">

                    @if ($errors->has('cover_img'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('cover_img') }}</strong>
                        </div>
                    @endif
                </div>
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="put">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        修改
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection