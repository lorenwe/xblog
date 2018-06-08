@extends('admin.layouts.app')
@section('title','Posts')
@section('content')
@section('action')
    {{--<a class="btn btn-sm btn-outline-success" href="{{ route('page.create') }}">New</a>--}}

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">创建</button>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">新图包</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('picture.store') }}" class="form-horizontal" role="form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">标题:</label>
                            <input type="text" name="title" class="form-control" id="recipient-name">
                        </div>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">描述:</label>
                            <textarea class="form-control" name="description" id="message-text"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@if($pictures->isEmpty())
    <div class="center-block">No data.</div>
@else
<table class="table table-striped">
    <thead>
    <tr>
        <th>标题</th>
        <th>状态</th>
        <th>action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pictures as $picture)
        <?php
        $class = 'badge-secondary';
        $status = '未发表';
        if ($picture->trashed()) {
            $class = 'badge-danger';
            $status = '已删除';
        } else if ($picture->isPublished()) {
            $class = 'badge-success';
            $status = '已发表';
        }
        ?>
        <tr>
            <td title="{{ $picture->title }}">{{ str_limit($picture->title,64) }}</td>
            <td><span class="p-2 p badge {{ $class }}">{{ $status }}</span></td>
            <td>
                <div>
                    <a {{ $picture->trashed()?'disabled':'' }} href="{{ $picture->trashed()?'javascript:void(0)':route('picture.edit',$picture->id) }}"
                       data-toggle="tooltip" data-placement="top" title="编辑"
                       class="btn btn-info">
                        <i class="fa fa-pencil fa-fw"></i>
                    </a>
                    @if($picture->trashed())
                        <form style="display: inline" method="post" action="{{ route('picture.restore',$picture->id) }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary" data-toggle="tooltip"
                                    data-placement="top" title="恢复">
                                <i class="fa fa-repeat fa-fw"></i>
                            </button>
                        </form>

                    @elseif($picture->isPublished())
                        <a href=""
                           data-toggle="tooltip" data-placement="top" title="查看"
                           class="btn btn-success">
                            <i class="fa fa-eye fa-fw"></i>
                        </a>
                        <form style="display: inline" method="post"
                              action="">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-warning" data-toggle="tooltip"
                                    data-placement="top" title="撤销发布">
                                <i class="fa fa-undo fa-fw"></i>
                            </button>
                        </form>
                    @else
                        <a href="" data-toggle="tooltip"
                           data-placement="top" title="预览"
                           class="btn btn-success">
                            <i class="fa fa-eye fa-fw"></i>
                        </a>
                        <form style="display: inline" method="post"
                              action="">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="发布">
                                <i class="fa fa-send-o fa-fw"></i>
                            </button>
                        </form>
                    @endif
                    <button class="btn btn-danger swal-dialog-target"
                            data-toggle="tooltip"
                            data-title="{{ $picture->title }}"
                            data-dialog-msg="确定删除文章<label>{{ $picture->title }}</label>？"
                            title="删除"
                            data-dialog-enable-html="1"
                            data-url="{{ route('post.destroy',$picture->id) }}"
                            data-dialog-confirm-text="{{ $picture->trashed()?'删除(这将永久刪除)':'删除' }}">
                        <i class="fa fa-trash-o  fa-fw"></i>
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $pictures->links() }}
@endif
@endsection

