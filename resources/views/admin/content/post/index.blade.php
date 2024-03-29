@extends('admin.layouts.master')

@section('haed-tag')
<!-- status switch on list -->
<link rel="stylesheet" href="{{ asset('admin-assets/css/component-custom-switch.css') }}">

<title>پست ها | پنل مدیریت</title>
@endsection

@section('content')
<!-- post page Breadcrumb area -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb m-0 font-size-12">
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.home') }}">خانه</a></li>
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="#">بخش محتوی</a></li>
        <li class="breadcrumb-item active" aria-current="page">پست ها</li>
    </ol>
</nav>
<!-- post page Breadcrumb area -->

<!--post page post list area -->
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    پست ها
                </h5>
            </section>
            @include('admin.alerts.alert-section.success')
            <section class="d-flex justify-content-between align-items-center mt-4 pb-3 mb-3 border-bottom">
                <section>
                    @can('create-post')
                    <a href="{{ route('admin.content.post.create') }}" class="btn btn-sm btn-info text-white">ایجاد پست جدید</a>
                    @endcan
                </section>
                <form class="d-flex" action="{{ route('admin.content.post.index') }}" method="get">
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
                        <th>عنوان پست</th>
                        <th>دسته</th>
                        <th>تصویر</th>
                        @can('edit-post')
                        <th>وضعیت</th>
                        @endcan
                        <th>امکان درج نظرات</th>
                        <th class="max-width-16-rem text-center"><i class="fa fa-cogs ms-2"></i>تنظیمات</th>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr class="align-middle">
                            <th>{{ iteration($loop->iteration, request()->page) }}</th>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->postCategory->name }}</td>
                            <td>
                                <img src="{{ hasFileUpload($post->image['indexArray'][$post->image['currentImage']]) }}" width="50" height="50" alt="{{ $post->name }}">
                            </td>
                            @can('edit-post')
                            <td>
                                <section>
                                    <div class="custom-switch custom-switch-label-onoff d-flex align-content-center" dir="ltr">
                                        <input data-url="{{ route('admin.content.post.status', $post->id) }}" onchange="changeStatus(this.id)" class="custom-switch-input" id="{{ $post->id . '-status' }}" name="status" type="checkbox" @checked($post->status) >
                                        <label class="custom-switch-btn" for="{{ $post->id . '-status' }}"></label>
                                    </div>
                                </section>
                            </td>
                            <td>
                                <section>
                                    <div class="custom-switch custom-switch-label-onoff d-flex align-content-center" dir="ltr">
                                        <input data-url="{{ route('admin.content.post.commentable', $post->id) }}" onchange="changeCommentable(this.id)" class="custom-switch-input" id="{{ $post->id . '-commentable' }}" name="commentable" type="checkbox" @checked($post->commentable) >
                                        <label class="custom-switch-btn" for="{{ $post->id . '-commentable' }}"></label>
                                    </div>
                                </section>
                            </td>
                            @endcan
                            <td class="width-16-rem text-start">
                                @can('edit-post')
                                <a href="{{ route('admin.content.post.edit', $post->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit ms-2"></i>ویرایش</a>
                                @endcan
                                @can('delete-post')
                                <form class="d-inline" action="{{ route('admin.content.post.destroy', $post->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="{{ $post->id }}" class="btn btn-danger btn-sm delete"><i class="fa fa-trash ms-2"></i>حذف</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr class="align-middle">
                            <th colspan="" class="text-center emptyTable  py-4">جدول پست ها خالی می باشد</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <section class="mb-3 mt-5 d-flex justify-content-center border-0">
                    <nav>
                        {{ $posts->links('pagination::bootstrap-5') }}
                    </nav>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- post page post list area -->
@endsection
@section('script')
<script src="{{ asset('admin-assets/js/plugin/ajaxs/commentable-ajax.js') }}"></script>
<script src="{{ asset('admin-assets/js/plugin/ajaxs/status-ajax.js') }}"></script>

@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete','fieldTitle' => 'پست'])


@endsection