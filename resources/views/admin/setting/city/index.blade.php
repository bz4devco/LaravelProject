@extends('admin.layouts.master')

@section('haed-tag')
<!-- status switch on list -->
<link rel="stylesheet" href="{{ asset('admin-assets/css/component-custom-switch.css') }}">

<title> شهرستان ها | پنل مدیریت</title>
@endsection

@section('content')
<!-- category page Breadcrumb area -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb m-0 font-size-12">
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.home') }}">خانه</a></li>
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="#">تنظیمات</a></li>
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.setting.province.index') }}">استان ها</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$province->name}}</li>
        <li class="breadcrumb-item active" aria-current="page">شهرستان ها</li>
    </ol>
</nav>
<!-- category page Breadcrumb area -->

<!--category page category list area -->
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    شهرستان ها
                </h5>
            </section>
            @include('admin.alerts.alert-section.success')
            <section class="d-flex justify-content-between align-items-center mt-4 pb-3 mb-3 border-bottom">
                <section>
                    @can('create-city')
                    <a href="{{ route('admin.setting.city.create', $province->id) }}" class="btn btn-sm btn-info text-white">ایجاد شهرستان جدید</a>
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
                        <th>نام شهرستان</th>
                        <th>نام استان</th>
                        @can('edit-city')
                        <th>وضعیت</th>
                        @endcan
                        <th class="max-width-16-rem text-center"><i class="fa fa-cogs ms-2"></i>تنظیمات</th>
                    </thead>
                    <tbody>
                        @forelse($cities as $city)
                        <tr class="align-middle">
                            <th>{{ iteration($loop->iteration, request()->page) }}</th>
                            <td>{{ $city->name }}</td>
                            <td>{{ $province->name }}</td>
                            @can('edit-city')
                            <td>
                                <section>
                                    <div class="custom-switch custom-switch-label-onoff d-flex align-content-center" dir="ltr">
                                        <input data-url="{{ route('admin.setting.city.status', $city->id) }}" onchange="changeStatus(this.id)" class="custom-switch-input" id="{{ $city->id }}" name="status" type="checkbox" @checked($city->status) >
                                        <label class="custom-switch-btn" for="{{ $city->id }}"></label>
                                    </div>
                                </section>
                            </td>
                            @endcan
                            <td class="width-16-rem text-start">
                                @can('edit-city')
                                <a href="{{ route('admin.setting.city.edit', ['province' => $province->id, 'city' => $city->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit ms-2"></i>ویرایش</a>
                                @endcan
                                @can('delete-city')
                                <form class="d-inline" action="{{ route('admin.setting.city.destroy', ['province' => $province->id, 'city' => $city->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="{{ $city->id }}" class="btn btn-danger btn-sm delete"><i class="fa fa-trash ms-2"></i>حذف</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr class="align-middle">
                            <th colspan="" class="text-center emptyTable  py-4">جدول شهرستان خالی می باشد</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <section class="mb-3 mt-5 d-flex justify-content-center border-0">
                    <nav>
                        {{ $cities->links('pagination::bootstrap-5') }}
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

@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete','fieldTitle' => 'شهرستان'])


@endsection