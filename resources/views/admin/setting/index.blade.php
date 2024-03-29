@extends('admin.layouts.master')

@section('haed-tag')
<!-- status switch on list -->
<link rel="stylesheet" href="{{ asset('admin-assets/css/component-custom-switch.css') }}">

<title>تنظیمات | پنل مدیریت</title>
@endsection

@section('content')
<!-- category page Breadcrumb area -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb m-0 font-size-12">
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.home') }}">خانه</a></li>
        <li class="breadcrumb-item active" aria-current="page">تنظیمات</li>
    </ol>
</nav>
<!-- category page Breadcrumb area -->

<!--category page category list area -->
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    تنظیمات
                </h5>
            </section>
            @include('admin.alerts.alert-section.success')
            @include('admin.alerts.alert-section.info')
            <section class="d-flex justify-content-between align-items-center mt-4 pb-3 mb-3 border-bottom">
                <a href="#" class="btn btn-sm btn-info text-white disabled" disabled>ایجاد تنظیمات جدید</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                </div>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="border-bottom border-dark table-col-count">
                        <th>#</th>
                        <th>نام سایت</th>
                        <th>آدرس سایت</th>
                        <th>لگوی سایت</th>
                        <th>آیکون سایت</th>
                        @can('edit-setting')
                        <th>وضعیت</th>
                        @endcan
                        <th class=" text-center"><i class="fa fa-cogs ms-2"></i>تنظیمات</th>
                    </thead>
                    <tbody>
                        @forelse($settings as $setting)
                        <tr class="align-middle">
                            <th>{{ iteration($loop->iteration, request()->page) }}</th>
                            <td>{{ $setting->title }}</td>
                            <td>{{ $setting->base_url }}</td>
                            <td>
                                @isset($setting->logo)
                                <img src="{{ hasFileUpload($setting->logo ?? null) }}" width="50" height="50" alt="logo">
                                @endisset
                            </td>
                            <td>
                                @isset($setting->icon)
                                <img src="{{ hasFileUpload($setting->icon ?? null) }}" width="50" height="50" alt="icon">
                                @endisset
                            </td>
                            @can('edit-setting')
                            <td>
                                <section>
                                    <div class="custom-switch custom-switch-label-onoff d-flex align-content-center" dir="ltr">
                                        <input data-url="{{ route('admin.setting.status', $setting->id) }}" onchange="changeStatus(this.id)" class="custom-switch-input" id="{{ $setting->id }}" name="status" type="checkbox" @checked($setting->status) >
                                        <label class="custom-switch-btn" for="{{ $setting->id }}"></label>
                                    </div>
                                </section>
                            </td>
                            @endcan
                            <td class=" text-start">
                                @can('manage-index-page')
                                <a href="{{ route('admin.setting.index-page.edit', $setting->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-chart-bar ms-2"></i>مدیریت نمایش صفحه اصلی</a>
                                @endcan
                                @can('edit-setting')
                                <a href="{{ route('admin.setting.edit', $setting->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit ms-2"></i>ویرایش</a>
                                @endcan
                                @can('delete-setting')
                                <form class="d-inline" action="{{ route('admin.setting.destroy', $setting->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="{{ $setting->id }}" class="btn btn-danger btn-sm delete"><i class="fa fa-trash ms-2"></i>حذف</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr class="align-middle">
                            <th colspan="" class="text-center emptyTable  py-4">جدول تنظیمات خالی می باشد</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <section class="mb-3 mt-5 d-flex justify-content-center border-0">
                    <nav>
                        {{ $settings->links('pagination::bootstrap-5') }}
                    </nav>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- category page category list area -->
@endsection
@section('script')
<script src="{{ asset('admin-assets/js/plugin/ajaxs/status-ajax.js') }}"></script>

@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete','fieldTitle' => 'تنظیمات'])


@endsection