@extends('admin.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/quill/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/quill/katex.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/quill/editor-fa.css') }}">
@endsection
@section('content')
    <div class="card">
        <form action="{{ route('admin.articles.update', ['id' => $article->id]) }}" method="post"
            class="add-new-record row g-2 p-5" id="form-add-new-record">
            @csrf
            <div class="col-sm-12">
                <label class="form-label" for="title">عنوان صفحه</label>
                <div class="input-group input-group-merge">
                    <span id="title2" class="input-group-text"><i class="bx bx-check-square"></i></span>
                    <input type="text" id="title" value="{{$article->title}}" class="form-control dt-full-name" name="title"
                        placeholder="عنوان صفحه" aria-label="John Doe" aria-describedby="title2">
                </div>
            </div>
            <div class="col-sm-12">
                <input type="hidden" name="body" id="body">
                <label class="form-label">محتوای صفحه</label>
                <div id="full-editor">
                    {!! $article->body !!}
                </div>
            </div>
            <div class="col-sm-12 mt-3">
                <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/quill/quill.js') }}"></script>
    <script>
        const fullToolbar = [
            [{
                    font: []
                },
                {
                    size: []
                }
            ],
            ['bold', 'italic', 'underline', 'strike'],
            [{
                    color: []
                },
                {
                    background: []
                }
            ],
            [{
                    script: 'super'
                },
                {
                    script: 'sub'
                }
            ],
            [{
                    header: '1'
                },
                {
                    header: '2'
                },
                'blockquote',
                'code-block'
            ],
            [{
                    list: 'ordered'
                },
                {
                    list: 'bullet'
                },
                {
                    indent: '-1'
                },
                {
                    indent: '+1'
                }
            ],
            [{
                    direction: 'rtl'
                },
                {
                    align: []
                }
            ],
            ['link', 'image', 'video', 'formula'],
            ['clean']
        ];
        const fullEditor = new Quill('#full-editor', {
            bounds: '#full-editor',
            placeholder: 'چیزی بنویسید ...',
            modules: {
                formula: true,
                toolbar: fullToolbar
            },
            theme: 'snow'
        });
        const hiddenInput = document.querySelector('#body');

        fullEditor.on('text-change', function() {
            hiddenInput.value = fullEditor.root.innerHTML;
        });
    </script>
@endsection
