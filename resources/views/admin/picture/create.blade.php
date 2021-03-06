@extends('admin.layouts.app')
@section('title', 'Create picture')
@section('css')
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/fileinput/css/fileinput.min.css"/>
@endsection
@section('content')
    <div class="container kv-main">
        <form enctype="multipart/form-data">
            <div class="form-group">
                <div class="file-loading">
                    <input id="file-input" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2">
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="/fileinput/js/fileinput.js"></script>
    <script type="text/javascript" src="/fileinput/js/locales/zh.js"></script>
    <script>
        $("#file-input").fileinput({
                    uploadUrl: 'upload.php', // you must set a valid URL here else you will get an error
                    allowedFileExtensions: ['jpg', 'png', 'gif'],
                    overwriteInitial: false,
                    maxFileSize: 1000,
                    maxFilesNum: 10,
                    /*slugCallback: function (filename) {
                        //选择文件后调用
                        //console.log(filename);
                        //return filename.replace('(', '_').replace(']', '_');
                    },*/
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