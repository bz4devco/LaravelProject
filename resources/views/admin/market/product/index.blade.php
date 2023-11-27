@extends('admin.layouts.master')

@section('haed-tag')
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
            <section class="d-flex justify-content-between align-items-center mt-4 pb-3 mb-3 border-bottom">
                <a href="{{ route('admin.market.product.create') }}" class="btn btn-sm btn-info text-white">ایجاد کالا جدید</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                </div>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="border-bottom border-dark">
                        <th>#</th>
                        <th>نام کالا</th>
                        <th>تصویر کالا</th>
                        <th>فیمت</th>
                        <th>وزن</th>
                        <th>دسته</th>
                        <th>فرم</th>
                        <th>وضعیت</th>
                        <th><i class="fa fa-cogs ms-2"></i>تنظیمات</th>
                    </thead>
                    <tbody>
                        <tr class="align-middle">
                            <th>1</th>
                            <td>سامسونگ LED</td>
                            <td><img src="{{ asset('admin-assets/images/avatar-2.jpg') }}" class="max-height-2rem" alt="برند"></td>
                            <td><span>12,000,000<span>تومان</span></span></td>
                            <td>13 کیلئ گرم</td>
                            <td>کالای الکترونیکی</td>
                            <td>نمایشگر</td>
                            <td class="row m-0 align-items-center">
                                <div class="col-md-8 px-1">
                                    <select class="form-select form-select-sm form-select" style="min-width:3rem" name="status" id="status">
                                        <option value="1">فعال</option>
                                        <option value="0">غیر فعال</option>
                                    </select>
                                </div>
                                <div class="col-md-4 px-1">
                                    <button type="submit" class="btn btn-success btn-sm w-100">ثبت</button>
                                </div>
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm btn-block dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-tools ms-1"></i>عملیات
                                </a>
                                <div class="dropdown-menu">
                                    <a href="" class="dropdown-item text-end ms-2"><i class="fa fa-images ms-2"></i>گالری</a>
                                    <a href="" class="dropdown-item text-end ms-2"><i class="fa fa-list-ul ms-2"></i>فرم کالا</a>
                                    <a href="" class="dropdown-item text-end ms-2"><i class="fa fa-edit ms-2"></i>ویرایش</a>
                                    <form action="" method="post">
                                        <button type="submit" class="dropdown-item text-end ms-2"><i class="fa fa-trash ms-2"></i>حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr class="align-middle">
                            <th>2</th>
                            <td>لپ تاپ سامسونگ</td>
                            <td><img src="{{ asset('admin-assets/images/avatar-2.jpg') }}" class="max-height-2rem" alt="برند"></td>
                            <td><span>18,500,000<span>تومان</span></span></td>
                            <td>1.6 کیلئ گرم</td>
                            <td>کالای الکترونیکی</td>
                            <td>لپتاپ</td>
                            <td class="row m-0 align-items-center">
                                <div class="col-md-8 px-1">
                                    <select class="form-select form-select-sm form-select" style="min-width:3rem" name="status" id="status">
                                        <option value="1">فعال</option>
                                        <option value="0">غیر فعال</option>
                                    </select>
                                </div>
                                <div class="col-md-4 px-1">
                                    <button type="submit" class="btn btn-success btn-sm w-100">ثبت</button>
                                </div>
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm btn-block dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-tools ms-1"></i>عملیات
                                </a>
                                <div class="dropdown-menu">
                                    <a href="" class="dropdown-item text-end ms-2"><i class="fa fa-images ms-2"></i>گالری</a>
                                    <a href="" class="dropdown-item text-end ms-2"><i class="fa fa-list-ul ms-2"></i>فرم کالا</a>
                                    <a href="" class="dropdown-item text-end ms-2"><i class="fa fa-edit ms-2"></i>ویرایش</a>
                                    <form action="" method="post">
                                        <button type="submit" class="dropdown-item text-end ms-2"><i class="fa fa-trash ms-2"></i>حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr class="align-middle">
                            <th>3</th>
                            <td>موبایل سامسونگ</td>
                            <td><img src="{{ asset('admin-assets/images/avatar-2.jpg') }}" class="max-height-2rem" alt="برند"></td>
                            <td><span>5,600,000<span>تومان</span></span></td>
                            <td>240 گرم</td>
                            <td>کالای الکترونیکی</td>
                            <td>موبایل</td>
                            <td class="row m-0 align-items-center">
                                <div class="col-md-8 px-1">
                                    <select class="form-select form-select-sm form-select" style="min-width:3rem" name="status" id="status">
                                        <option value="1">فعال</option>
                                        <option value="0">غیر فعال</option>
                                    </select>
                                </div>
                                <div class="col-md-4 px-1">
                                    <button type="submit" class="btn btn-success btn-sm w-100">ثبت</button>
                                </div>
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm btn-block dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-tools ms-1"></i>عملیات
                                </a>
                                <div class="dropdown-menu">
                                    <a href="" class="dropdown-item text-end ms-2"><i class="fa fa-images ms-2"></i>گالری</a>
                                    <a href="" class="dropdown-item text-end ms-2"><i class="fa fa-list-ul ms-2"></i>فرم کالا</a>
                                    <a href="" class="dropdown-item text-end ms-2"><i class="fa fa-edit ms-2"></i>ویرایش</a>
                                    <form action="" method="post">
                                        <button type="submit" class="dropdown-item text-end ms-2"><i class="fa fa-trash ms-2"></i>حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </section>
    </section>
</section>
<!-- category page category list area -->
@endsection