@extends('admin.layouts.master')

@section('haed-tag')
<title> افزودن فایل اطلاعیه ایمیلی  | پنل مدیریت</title>
@endsection

@section('content')
<!-- category page Breadcrumb area -->
<nav aria-label="breadcrumb">
<ol class="breadcrumb m-0 font-size-12">
<li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.home') }}">خانه</a></li>
    <li class="breadcrumb-item deco"><a class="text-decoration-none" href="#">اطلاع رسانی</a></li>
    <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.notify.email.index') }}">اطلاعیه ایمیلی</a></li>
    <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.notify.email-file.index', $email->id) }}">لیست فایل های اطلاعیه ایمیلی</a></li>
    <li class="breadcrumb-item deco">افزودن فایل</li>
    <li class="breadcrumb-item active" aria-current="page">{{$email->subject}}</li>
</ol>
</nav>
<!-- category page Breadcrumb area -->

<!--category page category list area -->
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                افزودن فایل به اطلاعیه ایمیلی  ({{$email->subject}})
                </h5>
            </section>
            <section class="d-flex justify-content-between align-items-center mt-4 pb-3 mb-3 border-bottom">
                <a href="{{ route('admin.notify.email-file.index', $email->id) }}" class="btn btn-sm btn-info text-white">بازگشت</a>
            </section>
            <section class="">
                <form id="form" action="{{ route('admin.notify.email-file.store', $email->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <section class="row">
                    <section class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="file">فایل</label>
                                <input class="form-control form-select-sm" type="file" name="file" id="file">
                                @error('file')
                                    <span class="text-danger font-size-12">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="status">وضعیت</label>
                                <select class="form-select form-select-sm" name="status" id="status">
                                    <option value="0" @selected(old('status') == 0) >غیر فعال</option>
                                    <option value="1" @selected(old('status') == 1) >فعال</option>
                                </select>
                                @error('status')
                                    <span class="text-danger font-size-12">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="storage_path">مسیر ذخیره سازی</label>
                                <select class="form-select form-select-sm" name="storage_path" id="storage_path">
                                    <option value="0" @selected(old('storage_path') == 0) >مسیر عمومی</option>
                                    <option value="1" @selected(old('storage_path') == 1) >مسیر امن</option>
                                </select>
                            </div>
                        </section>
                        <section class="col-12">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>
<!-- category page category list area -->
@endsection
