!function (e) {
    e.extend({
        uploadPreview: function (l) {
            var i = e.extend({
                input_field: "#addpost-image",
                preview_box: ".img-label",
                label_field: ".img-label",
                label_default: "Choose File",
                label_selected: "Change File",
                no_label: !1,
                success_callback: null
            }, l);
            return window.File && window.FileList && window.FileReader ? void (void 0 !== e(i.input_field) && null !== e(i.input_field) && e(i.input_field).change(function () {
                var l = this.files;
                if (l.length > 0) {
                    var a = l[0], o = new FileReader;
                    o.addEventListener("load", function (l) {
                        var o = l.target;
                        a.type.match("image") ? (e(i.preview_box).css("background-image", "url(" + o.result + ")"), e(i.preview_box).css("background-size", "cover"), e(i.preview_box).css("background-position", "center center")) : a.type.match("audio") ? e(i.preview_box).html("<audio controls><source src='" + o.result + "' type='" + a.type + "' />Your browser does not support the audio element.</audio>") : alert("This file type is not supported yet.")
                    }), 0 == i.no_label && e(i.label_field).html(i.label_selected), o.readAsDataURL(a), i.success_callback && i.success_callback()
                } else 0 == i.no_label && e(i.label_field).html(i.label_default), e(i.preview_box).css("background-image", "none"), e(i.preview_box + " audio").remove()
            })) : (alert("You need a browser with file reader support, to use this form properly."), !1);
            var fileField = document.getElementById('cabinet-main-img');
            fileField.remove();
            var cabinetLabel = document.getElementById('cabinet-main-img-label');
            cabinetLabel.classList.remove('exist-img');
        }
    })
}(jQuery);

$(document).ready(function() {
    $.uploadPreview({
        input_field: "#addpost-image",   // Default: .image-upload
        preview_box: "#cabinet-main-img-label",  // Default: .image-preview
        label_field: "#image-label",    // Default: .image-label
        label_default: "Загрузить основное фото",   // Default: Choose File
        label_selected: "Загрузить основное фото",  // Default: Change File
        no_label: false                 // Default: false
    });
});

$(document).ready(function() {
    $.uploadPreview({
        input_field: "#addpost-check-image",   // Default: .image-upload
        preview_box: ".check-photo-label",  // Default: .image-preview
        label_field: "#image-label",    // Default: .image-label
        label_default: "Загрузить основное фото",   // Default: Choose File
        label_selected: "Загрузить основное фото",  // Default: Change File
        no_label: false                 // Default: false
    });
});

$(document).ready(function() {
    $("#posts-phone").mask("+7(999)99-99-999");
});

var fileFieldSelphi = document.getElementById('addpost-selphi');
var previewSelphi = document.getElementById('previewselphi');

fileFieldSelphi.addEventListener('change', function(event) {
    previewSelphi.innerHTML = '';
    for(var x = 0; x < event.target.files.length; x++) {
        (function(i) {
            var reader = new FileReader();
            var img = document.createElement('img');
            reader.onload = function(event) {
                img.setAttribute('src', event.target.result);
                img.setAttribute('class', 'preview');

                previewSelphi.appendChild(img);
            }
            reader.readAsDataURL(event.target.files[x]);
        })(x);
    }
}, false);

var fileField = document.getElementById('addpost-photo');
var preview = document.getElementById('preview');

fileField.addEventListener('change', function(event) {
    preview.innerHTML = '';
    for(var x = 0; x < event.target.files.length; x++) {
        (function(i) {
            var reader = new FileReader();
            var img = document.createElement('img');
            reader.onload = function(event) {
                img.setAttribute('src', event.target.result);
                img.setAttribute('class', 'preview');

                preview.appendChild(img);
            }
            reader.readAsDataURL(event.target.files[x]);
        })(x);
    }
}, false);




$(document).ready(function() {

    $("#addpost-video").on('change', function () {

        $("#change-video-label").text('');
        $("#preview-video-label").text('Видео выбрано');

    });

});