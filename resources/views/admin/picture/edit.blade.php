@extends('admin.layouts.app')
@section('title', 'Create picture')
@section('css')
    <link rel="stylesheet" type="text/css" href="/fileinput/css/fileinput.min.css"/>
    <link rel="stylesheet" type="text/css" href="/slim/slim.min.css">
@endsection
@section('content')
    <div class="edit-form">
        <form class="form-horizontal" action="{{ route('picture.update',$picture->id) }}" method="post">
            @include('admin.picture.form-content')
            <input type="hidden" name="_method" value="put">
            <button type="submit" class="btn btn-primary btn-block">
                更新
            </button>
        </form>
        <div class="kv-main" style="margin-top: 20px; margin-bottom: 20px;">
            <form enctype="multipart/form-data">
                <div class="form-group">
                    <div class="file-loading">
                        <input id="file-input" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="/slim/slim.kickstart.min.js"></script>
    <script type="text/javascript" src="/fileinput/js/fileinput.min.js"></script>
    <script type="text/javascript" src="/fileinput/js/locales/zh.js"></script>
    <script>
        $("#file-input").fileinput({
                uploadUrl: 'upload.php', // you must set a valid URL here else you will get an error
                allowedFileExtensions: ['jpg', 'png', 'gif'],
                overwriteInitial: false,
                maxFileSize: 1000,
                maxFilesNum: 10,
                slugCallback: function (filename) {
                    //选择文件后调用
                    //console.log(filename);
                    //return filename.replace('(', '_').replace(']', '_');
                },
                previewZoomButtonIcons: {
                    prev: '<i class="fa fa-caret-left fa-lg"></i>',
                    next: '<i class="fa fa-caret-right fa-lg"></i>',
                    toggleheader: '<i class="fa fa-fw fa-arrows-v"></i>',
                    fullscreen: '<i class="fa fa-fw fa-arrows-alt"></i>',
                    borderless: '<i class="fa fa-fw fa-external-link"></i>',
                    close: '<i class="fa fa-fw fa-remove"></i>'
                },
                fileActionSettings: {
                    removeIcon: '<i class="fa fa-trash"></i>',
                    uploadIcon: '<i class="fa fa-upload"></i>',
                    uploadRetryIcon: '<i class="fa fa-repeat"></i>',
                    downloadIcon: '<i class="fa fa-download"></i>',
                    zoomIcon: '<i class="fa fa-search-plus"></i>',
                    dragIcon: '<i class="fa fa-arrows"></i>',
                    indicatorNew: '<i class="fa fa-plus-circle text-warning"></i>',
                    indicatorSuccess: '<i class="fa fa-check-circle text-success"></i>',
                    indicatorError: '<i class="fa fa-exclamation-circle text-danger"></i>',
                    indicatorLoading: '<i class="fa fa-hourglass text-muted"></i>'
                },
                previewFileIcon: '<i class="fa fa-file"></i>',
                browseIcon: '<i class="fa fa-folder-open"></i>',
                removeIcon: '<i class="fa fa-trash"></i>',
                cancelIcon: '<i class="fa fa-ban"></i>',
                uploadIcon: '<i class="fa fa-upload"></i>',
                msgValidationErrorIcon: '<i class="fa fa-exclamation-circle"></i> '
            });
    </script>
@endsection