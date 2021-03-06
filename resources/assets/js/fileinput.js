require('../bootstrap_fileinput/js/fileinput');
require('../bootstrap_fileinput/js/locales/zh.js');

require('./codemirror-4.inline-attachment');
(function ($) {
    function initFileInput() {
        $(document).ready(function () {
            let target = $('#file-input');
            if (target.length === 0) {
                return;
            }
            target.fileinput({
                language: 'zh',
                uploadUrl: 'upload.php', // you must set a valid URL here else you will get an error
                allowedFileExtensions: ['jpg', 'png', 'gif'],
                overwriteInitial: false,
                maxFileSize: 1000,
                maxFilesNum: 10,
                //allowedFileTypes: ['image', 'video', 'flash'],
                slugCallback: function (filename) {
                    return filename.replace('(', '_').replace(']', '_');
                },
                previewZoomButtonIcons: {
                    prev: '<i class="fa fa-caret-left fa-lg"></i>',
                    next: '<i class="fa fa-caret-right fa-lg"></i>',
                    toggleheader: '<i class="fa fa-fw fa-arrows-v"></i>',
                    fullscreen: '<i class="fa fa-fw fa-arrows-alt"></i>',
                    borderless: '<i class="fa fa-fw fa-external-link"></i>',
                    close: '<i class="fa fa-fw fa-remove"></i>'
                },
                /*layoutTemplates: {
                    preview: '<div class="file-preview {class}">\n' +
                    '    {close}' +
                    '    <div class="{dropClass}">\n' +
                    '    <table class="table table-bordered table-hover"><tbody class="file-preview-thumbnails">\n' +
                    '    </tbody></table>\n' +
                    '    <div class="clearfix"></div>' +
                    '    <div class="file-preview-status text-center text-success"></div>\n' +
                    '    <div class="kv-fileinput-error"></div>\n' +
                    '    </div>\n' +
                    '</div>',
                    footer: '<td class="file-details-cell"><div class="explorer-caption" title="{caption}">{caption}</div> ' +
                    '{size}{progress}</td><td class="file-actions-cell">{indicator} {actions}</td>',
                    actions: '{drag}\n' +
                    '<div class="file-actions">\n' +
                    '    <div class="file-footer-buttons">\n' +
                    '        {upload} {download} {delete} {zoom} {other} ' +
                    '    </div>\n' +
                    '</div>',
                    zoomCache: '<tr style="display:none" class="kv-zoom-cache-theme"><td>' +
                    '<table class="kv-zoom-cache">{zoomContent}</table></td></tr>',
                    fileIcon: '<i class="fa fa-file kv-caption-icon"></i> '
                },
                previewMarkupTags: {
                    tagBefore1: teTagBef + '>' + teContent,
                    tagBefore2: teTagBef + ' title="{caption}">' + teContent,
                    tagAfter: '</td>\n{footer}</tr>\n'
                },*/
                /*previewSettings: {
                    image: {height: "60px"},
                    html: {width: "100px", height: "60px"},
                    text: {width: "100px", height: "60px"},
                    video: {width: "auto", height: "60px"},
                    audio: {width: "auto", height: "60px"},
                    flash: {width: "100%", height: "60px"},
                    object: {width: "100%", height: "60px"},
                    pdf: {width: "100px", height: "60px"},
                    other: {width: "100%", height: "60px"}
                },*/
                /*frameClass: 'explorer-frame',*/
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
        });

    }
    initFileInput();
})(jQuery);
