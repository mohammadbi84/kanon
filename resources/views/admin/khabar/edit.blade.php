@extends('admin.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/quill/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/quill/katex.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/quill/editor-fa.css') }}">
@endsection
@section('content')
    <h5 class="breadcrumb-wrapper mb-4">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <a href="{{ route('admin.khabar.index') }}" class="text-muted">اخبار</a> <span class="text-muted">/</span>
        <span class="">{{ $khabar->title }}</span>
        <span class="text-muted">/ ویرایش</span>
    </h5>
    <div class="card">
        <form action="{{ route('admin.khabar.update', ['id' => $khabar->id]) }}" method="post"
            class="add-new-record row g-2 p-5" id="form-add-new-record">
            @csrf
            @method('PUT')
            <div class="col-sm-12">
                <label class="form-label" for="title">عنوان خبر</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="title" value="{{ $khabar->title }}" class="form-control dt-full-name"
                        name="title" placeholder="عنوان خبر" aria-label="John Doe" aria-describedby="title2">
                </div>
            </div>
            <div class="col-sm-12">
                <input type="hidden" name="body" id="body">
                <label class="form-label">محتوای خبر</label>
                <div id="full-editor">
                    {!! $khabar->body !!}
                </div>
            </div>
            <div class="col-sm-3">
                <label class="form-label" for="start_at">تاریخ شروع</label>
                <input type="date" id="start_at" value="{{ $khabar->start_at }}" name="start_at" class="form-control">
            </div>

            <div class="col-sm-3">
                <label class="form-label" for="end_at">تاریخ پایان</label>
                <input type="date" id="end_at" value="{{ $khabar->end_at }}" name="end_at" class="form-control">
            </div>

            {{-- وضعیت --}}
            <div class="col-sm-3">
                <label class="form-label" for="status">وضعیت</label>
                <select id="status" name="status" class="form-select">
                    <option value="1" {{ $khabar->status == 1 ? 'selected' : '' }}>فعال</option>
                    <option value="0" {{ $khabar->status == 0 ? 'selected' : '' }}>غیرفعال</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label class="form-label" for="image">عکس کاور</label>
                <div class="input-group">
                    <button class="btn btn-outline-primary" type="button" id="image" data-input="cover"
                        data-preview="imageHolder">انتخاب عکس</button>
                    <input type="text" id="cover" name="cover" class="form-control" placeholder="انتخاب عکس"
                        aria-label="انتخاب عکس">
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
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
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
        hiddenInput.value = fullEditor.root.innerHTML;

        fullEditor.on('text-change', function() {
            hiddenInput.value = fullEditor.root.innerHTML;
        });
    </script>
    <script>
        // در کد JS خود این را اضافه کنید:
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#image').filemanager('file');
        $('#start_at').flatpickr({
            enableTime: true,
            locale: 'fa',
            altInput: true,
            altFormat: 'Y/m/d - H:i',
            disableMobile: true,
        });
        $('#end_at').flatpickr({
            enableTime: true,
            locale: 'fa',
            altInput: true,
            altFormat: 'Y/m/d - H:i',
            disableMobile: true
        });
    </script>
@endsection
