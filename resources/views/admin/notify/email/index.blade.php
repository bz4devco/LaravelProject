@extends('admin.layouts.master')

@section('haed-tag')
<!-- status switch on list -->
<link rel="stylesheet" href="{{ asset('admin-assets/css/component-custom-switch.css') }}">

<title>اطلاعیه ایمیلی | پنل مدیریت</title>
@endsection

@section('content')
<!-- email page Breadcrumb area -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb m-0 font-size-12">
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.home') }}">خانه</a></li>
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="#">اطلاع رسانی</a></li>
        <li class="breadcrumb-item active" aria-current="page">اطلاعیه ایمیلی</li>
    </ol>
</nav>
<!-- email page Breadcrumb area -->

<!--email page emails notify list area -->
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    اطلاعیه ایمیلی
                </h5>
            </section>
            @include('admin.alerts.alert-section.success')
            @include('admin.alerts.alert-section.error')
            <section class="d-flex justify-content-between align-items-center mt-4 pb-3 mb-3 border-bottom">
                <section>
                    @can('create-notify-email')
                    <a href="{{ route('admin.notify.email.create') }}" class="btn btn-sm btn-info text-white">ایجاد اطلاعیه ایمیلی</a>
                    @endcan
                </section>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                </div>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="border-bottom border-dark table-col-count">
                        <th>#</th>
                        <th>عنون اطلاعیه</th>
                        <th>تاریخ ارسال</th>
                        @can('edit-notify-email')
                        <th>وضعیت</th>
                        @endcan
                        <th class=" text-center"><i class="fa fa-cogs ms-2"></i>تنظیمات</th>
                    </thead>
                    <tbody>
                        @forelse($emails as $email)
                        <tr class="align-middle">
                            <th>{{ iteration($loop->iteration, request()->page) }}</th>
                            <td>{{ $email->subject }}</td>
                            <td>{{ jalaliDate($email->published_at) }}</td>
                            @can('edit-notify-email')
                            <td>
                                <section>
                                    <div class="custom-switch custom-switch-label-onoff d-flex align-content-center" dir="ltr">
                                        <input data-url="{{ route('admin.notify.email.status', $email->id) }}" onchange="changeStatus(this.id)" class="custom-switch-input" id="{{ $email->id }}" name="status" type="checkbox" @checked($email->status) >
                                        <label class="custom-switch-btn" for="{{ $email->id }}"></label>
                                    </div>
                                </section>
                            </td>
                            @endcan
                            <td class="text-start">
                                @can('sync-notify-email-file')
                                <a href="{{ route('admin.notify.email-file.index', $email->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-file ms-2"></i>فایل های ضمیمه شده</a>
                                @endcan
                                @can('edit-notify-email')
                                <a href="{{ route('admin.notify.email.edit', $email->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit ms-2"></i>ویرایش</a>
                                @endcan
                                @can('delete-notify-email')
                                <form class="d-inline" action="{{ route('admin.notify.email.destroy', $email->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="{{ $email->id }}" class="btn btn-danger btn-sm delete"><i class="fa fa-trash ms-2"></i>حذف</button>
                                </form>
                                @endcan
                                @can('send-notify-email')
                                <a href="{{ route('admin.notify.email.send-mail', $email->id) }}" class="btn btn-success btn-sm"><i class="fa fa-edit ms-2"></i>ارسال</a>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr class="align-middle">
                            <th colspan="" class="text-center emptyTable  py-4">جدول اطلاعیه های ایمیلی خالی می باشد</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <section class="mb-3 mt-5 d-flex justify-content-center border-0">
                    <nav>
                        {{ $emails->links('pagination::bootstrap-5') }}
                    </nav>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- email page emails notify list area -->
@endsection
@section('script')
<script src="{{ asset('admin-assets/js/plugin/ajaxs/status-ajax.js') }}"></script>

@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete','fieldTitle' => 'اطلاعیه'])


@endsection