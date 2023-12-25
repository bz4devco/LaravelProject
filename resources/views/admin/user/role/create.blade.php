@extends('admin.layouts.master')

@section('haed-tag')
<title> ایجاد نقش جدید | پنل مدیریت</title>
@endsection

@section('content')
<!-- category page Breadcrumb area -->
<nav aria-label="breadcrumb">
<ol class="breadcrumb m-0 font-size-12">
    <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.home') }}">خانه</a></li>
    <li class="breadcrumb-item deco"><a class="text-decoration-none" href="#">بخش محتوی</a></li>
    <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.user.role.index') }}">نقش ها</a></li>
    <li class="breadcrumb-item active" aria-current="page">ایجاد نقش جدید</li>
</ol>
</nav>
<!-- category page Breadcrumb area -->

<!--category page category list area -->
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                ایجاد نقش جدید
                </h5>
            </section>
            <section class="d-flex justify-content-between align-items-center mt-4 pb-3 mb-3 border-bottom">
                <a href="{{ route('admin.user.role.index') }}" class="btn btn-sm btn-info text-white">بازگشت</a>
            </section>
            <section>
                <form id="form" action="{{ route('admin.user.role.store') }}" method="post">
                    @csrf
                    <section class="border-bottom mb-2 pb-3">
                        <section class="row">
                            <section class="col-12 col-md-5">
                                <div class="form-group mb-3">
                                    <label for="name">عنوان نقش</label>
                                    <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{old('name')}}">
                                    @error('name')
                                        <span class="text-danger font-size-12">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror
                                </div>
                            </section>
                            <section class="col-12 col-md-5">
                                <div class="form-group mb-3">
                                    <label for="description">توضیح نقش</label>
                                    <input type="text" class="form-control form-control-sm" name="description" id="description" value="{{old('description')}}">
                                    @error('description')
                                        <span class="text-danger font-size-12">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror
                                </div>
                            </section>
                            <section class="col-12 col-md-2 d-flex flex-column justify-content-center">
                                <div class="form-group ">  
                                    <button class="btn btn-primary btn-sm">ثبت</button>
                                </div>
                            </section>
                        </section>
                    </section>
                    <section class="row py-4">
                        @if(empty($permissions->toArray()))
                        <section>
                            <span class="text-danger d-block text-center ">هیج سطح دسترسی تعریف نشده است</span>
                        </section>
                        @else
                            @foreach($permissions as $key => $permission)
                            <section class="col-md-3 col-sm-6 col-12">
                                <div class="">
                                    <input type="checkbox" class="form-check-input" name="permissions[]" id="check{{$key + 1}}" value="{{$permission->id}}"  {{ (is_array(old('permissions')) && in_array($permission->id , old('permissions'))) ? ' checked' : '' }}>
                                    <label for="check{{$key + 1}}" class="form-check-label">{{$permission->name}}</label>
                                </div>
                                <div class="mt-2">
                                    @error('permission' . $key)
                                        <span class="text-danger font-size-12">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror
                                </div>
                            </section>
                            @endforeach
                        @endif
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>
<!-- category page category list area -->
@endsection
