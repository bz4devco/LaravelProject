@extends('admin.layouts.master')

@section('haed-tag')
<!-- status switch on list -->
<link rel="stylesheet" href="{{ asset('admin-assets/css/component-custom-switch.css') }}">

<title>کالاها | پنل مدیریت</title>
@endsection

@section('content')
<!-- category page Breadcrumb area -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb m-0 font-size-12">
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.home') }}">خانه</a></li>
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="#">بخش فروش</a></li>
        <li class="breadcrumb-item active" aria-current="page">کالاها</li>
    </ol>
</nav>
<!-- category page Breadcrumb area -->

<!--category page category list area -->
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    کالاها
                </h5>
            </section>
            @include('admin.alerts.alert-section.success')
            <section class="d-flex justify-content-between align-items-center mt-4 pb-3 mb-3 border-bottom">
                <section>
                    @can('create-product')
                    <a href="{{ route('admin.market.product.create') }}" class="btn btn-sm btn-info text-white">ایجاد کالا جدید</a>
                    @endcan
                </section>
                <form class="d-flex" action="{{ route('admin.market.product.index') }}" method="get">
                    <div class="max-width-16-rem">
                        <input type="text" name="search" value="{{request()->search ?? ''}}" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                    <button class="mt-1 btn btn-primary btn-sm me-2" style="height: fit-content;">جستجو</button>
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="border-bottom border-dark table-col-count">
                        <th>#</th>
                        <th>نام کالا</th>
                        <th>تصویر کالا</th>
                        <th>قیمت</th>
                        <th>دسته</th>
                        @can('edit-product')
                        <th>وضعیت</th>
                        @endcan
                        <th>وضعیت قابل فروش</th>
                        <th class="max-width-16-rem text-center"><i class="fa fa-cogs ms-2"></i>تنظیمات</th>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr class="align-middle">
                            <th>{{ iteration($loop->iteration, request()->page) }}</th>
                            <td class="text-truncate" style="max-width: 120px;" title="{{$product->name}}">{{$product->name}}</td>
                            <td>
                                <img src="{{ hasFileUpload($product->image ? $product->image['indexArray'][$product->image['currentImage']] : null) }}" width="50" height="50" alt="{{ $product->name }}">
                            </td>
                            <td><span>{{number_format($product->price)}}<span>تومان</span></span></td>
                            <td>{{$product->category->name ?? '-'}}</td>
                            @can('edit-product')
                            <td>
                                <section>
                                    <div class="custom-switch custom-switch-label-onoff d-flex align-content-center" dir="ltr">
                                        <input data-url="{{ route('admin.market.product.status', $product->id) }}" onchange="changeStatus(this.id)" class="custom-switch-input" id="{{ $product->id }}" name="status" type="checkbox" @checked($product->status) >
                                        <label class="custom-switch-btn" for="{{ $product->id }}"></label>
                                    </div>
                                </section>
                            </td>
                            <td>
                                <section>
                                    <div class="custom-switch custom-switch-label-onoff d-flex align-content-center" dir="ltr">
                                        <input data-url="{{ route('admin.market.product.marketable', $product->id) }}" onchange="marketable(this.id)" class="custom-switch-input" id="{{ $product->id }}-marketable" name="show-in-menu" type="checkbox" @checked($product->marketable) >
                                        <label class="custom-switch-btn" for="{{ $product->id }}-marketable"></label>
                                    </div>
                                </section>
                            </td>
                            @endcan
                            <td class="width-16-rem text-start">
                                <a class="btn btn-success btn-sm btn-block dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-tools ms-1"></i>عملیات
                                </a>
                                <div class="dropdown-menu">
                                    @can('view-product-gallerys-list')
                                    <a href="{{ route('admin.market.product.gallery.index', $product->id) }}" class="dropdown-item text-end ms-2"><i class="fa fa-images ms-2"></i>گالری</a>
                                    @endcan
                                    @can('view-guarantees-list')
                                    <a href="{{ route('admin.market.product.guarantee.index', $product->id) }}" class="dropdown-item text-end ms-2"><i class="fa fa-shield-alt ms-2"></i>گارانتی</a>
                                    @endcan
                                    @can('view-product-colors-list')
                                    <a href="{{ route('admin.market.product.color.index', $product->id) }}" class="dropdown-item text-end ms-2"><i class="fa fa-list-ul ms-2"></i>رنگ کالا</a>
                                    @endcan
                                    @can('edit-product')
                                    <a href="{{ route('admin.market.product.edit', $product->id) }}" class="dropdown-item text-end ms-2"><i class="fa fa-edit ms-2"></i>ویرایش</a>
                                    @endcan
                                    @can('delete-product')
                                    <form class="d-inline" action="{{ route('admin.market.product.destroy', $product->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" id="{{ $product->id }}" class="dropdown-item text-end ms-2 delete"><i class="fa fa-trash ms-2"></i>حذف</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="align-middle">
                            <th colspan="" class="text-center emptyTable  py-4">جدول کالا ها خالی می باشد</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <section class="mb-3 mt-5 d-flex justify-content-center border-0">
                    <nav>
                        {{ $products->links('pagination::bootstrap-5') }}
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
<script src="{{ asset('admin-assets/js/plugin/ajaxs/marketable-ajax.js') }}"></script>

@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete','fieldTitle' => 'کالا'])


@endsection