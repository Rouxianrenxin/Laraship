<div id="gallery">
    @if($editable)
        {!! \Html::style('assets/corals/plugins/dropzone-4.3.0/dropzone.min.css') !!}
        {!! \Html::script('assets/corals/plugins/dropzone-4.3.0/dropzone.min.js') !!}
        <script>
            Dropzone.autoDiscover = false;
        </script>
    @endif
    <style>
        .masonry img {
            max-width: 100%;
            vertical-align: bottom;
        }

        .masonry {
            -moz-transition: all .5s ease-in-out;
            -webkit-transition: all .5s ease-in-out;
            transition: all .5s ease-in-out;
            -moz-column-gap: 15px;
            -webkit-column-gap: 15px;
            column-gap: 15px;
            -moz-column-fill: initial;
            -webkit-column-fill: initial;
            column-fill: initial;
        }

        .masonry .brick {
            margin-bottom: 15px;
            position: relative;
        }

        .masonry .brick img {
            -moz-transition: all .5s ease-in-out;
            -webkit-transition: all .5s ease-in-out;
            transition: all .5s ease-in-out;
        }

        .masonry.bordered {
            -moz-column-rule: 1px solid #eee;
            -webkit-column-rule: 1px solid #eee;
            column-rule: 1px solid #eee;
            -moz-column-gap: 50px;
            -webkit-column-gap: 50px;
            column-gap: 50px;
        }

        .masonry.bordered .brick {
            padding-bottom: 25px;
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
        }

        .masonry.gutterless {
            -moz-column-gap: 0;
            -webkit-column-gap: 0;
            column-gap: 0;
        }

        .masonry.gutterless .brick {
            margin-bottom: 0;
        }

        @media only screen and (min-width: 1024px) {
            .masonry {
                -moz-column-count: 3;
                -webkit-column-count: 3;
                column-count: 3;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 1023px) {
            .masonry {
                -moz-column-count: 2;
                -webkit-column-count: 2;
                column-count: 2;
            }
        }

        .add-photo {
            padding: 0 !important;
            opacity: 0.1;
        }

        .add-photo:hover {
            opacity: 0.2;
        }

        .dropzone .dz-message {
            margin: 3em 0;
        }

        .dz-message i {
            font-size: 8em;
            color: #000;
        }

        .dropzone {
            border: 1px solid rgba(0, 0, 0, 0.2);
        }

        .item-buttons {
            top: 2px;
            left: 2px;
            position: absolute;
            margin: 2px 2px;
        }

        .featured-item {
            position: absolute;
            top: 5px;
            left: 5px;
            color: #ffd400;
            text-shadow: #7a7a7a 0 0 2px;
        }
    </style>

    <div class="masonry">
        @foreach($galleryModel->getMedia($galleryModel->galleryMediaCollection) as $media)
            <div class="brick gallery-item">
                @if($media->getCustomProperty('featured', false))
                    <span class="featured-item"><i class="fa fa-fw fa-2x fa-star"></i></span>
                @endif
                <a href="{{ $media->getFullUrl() }}" data-lightbox="product-gallery">
                    <img src="{{ $media->getFullUrl() }}">
                </a>
                @if($editable)
                    <div class="item-buttons" style="display: none;">
                        <a href="{{ url('utilities/gallery/'.$media->id.'/delete') }}"
                           class="btn btn-sm btn-danger item-button" title="Delete Gallery Item"
                           data-action="delete" data-page_action="reloadGallery">
                            <i class="fa fa-fw fa-remove"></i>
                        </a>
                        @if(!$media->getCustomProperty('featured', false))
                            <a href="{{ url('utilities/gallery/'.$media->id.'/mark-as-featured') }}"
                               class="btn btn-sm btn-warning item-button"
                               title="Mark as Featured" data-action="post" data-page_action="reloadGallery">
                                <i class="fa fa-fw fa-star"></i>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    @if($editable)
        <div class="m-t-10">
            <form action="{{ url('utilities/gallery/'.$galleryModel->hashed_id.'/upload') }}" class="dropzone"
                  id="galleryDZ">
                {{ csrf_field() }}
                {{ Form::hidden('model_class', get_class($galleryModel)) }}
            </form>
        </div>
        <script type="text/javascript">
            var galleryDZ = new Dropzone("#galleryDZ", {
                maxFilesize: 1, // MB
                acceptedFiles: 'image/*',
                dictDefaultMessage: '<i class="fa fa-plus fa-fw fa-5x add-photo"></i>',
                queuecomplete: function () {
                    reloadGallery();
                },
                error: function (file, response) {
                    var message;
                    if ($.type(response) === "string")
                        var message = response; //dropzone sends it's own error messages in string
                    else
                        var message = response.message;
                    file.previewElement.classList.add("dz-error");
                    _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                    _results = [];
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i];
                        _results.push(node.textContent = message);
                    }
                    return _results;
                }
            });

            function reloadGallery() {
                setTimeout(function () {
                    $.ajax({
                        type: "GET",
                        url: '{{ url('utilities/gallery/'.$galleryModel->hashed_id) }}',
                        data: {
                            model_class: '{!! getObjectClassForViews($galleryModel) !!}'
                        },
                        success: function (data) {
                            $('#gallery').html(data);
                        }
                    });
                }, 500);
            }

            function initGalleryItemButtons() {
                $(document).on("mouseenter", ".gallery-item", function (e) {
                    $(this).find(".item-buttons").show();
                });

                $(document).on("mouseleave", ".gallery-item", function (e) {
                    $(this).find(".item-buttons").hide();
                });
            }

            window.onload = function () {
                initGalleryItemButtons();
            }
        </script>
    @endif
</div>
