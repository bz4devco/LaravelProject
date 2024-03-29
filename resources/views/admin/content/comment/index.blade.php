@extends('admin.layouts.master')

@section('haed-tag')
<!-- status switch on list -->
<link rel="stylesheet" href="{{ asset('admin-assets/css/component-custom-switch.css') }}">

<title>نظرات | پنل مدیریت</title>
@endsection

@section('content')
<!-- category page Breadcrumb area -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb m-0 font-size-12">
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.home') }}">خانه</a></li>
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="#">بخش محتوی</a></li>
        <li class="breadcrumb-item active" aria-current="page">نظرات</li>
    </ol>
</nav>
<!-- category page Breadcrumb area -->

<!--category page category list area -->
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    نظرات
                </h5>
            </section>
            @include('admin.alerts.alert-section.success')
            <section class="d-flex justify-content-between align-items-center mt-4 pb-3 mb-3 border-bottom">
                <a href="#" class="btn btn-sm btn-info text-white disabled">ایجاد نظر جدید</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                </div>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="border-bottom border-dark table-col-count">
                        <th></th>
                        <th>#</th>
                        <th>شناسه نظر</th>
                        <th>نویسنده نظر</th>
                        <th>کد کاربر</th>
                        <th>عنوان خبر</th>
                        <th>شناسه خبر</th>
                        <th>تاریخ درج نظر</th>
                        @can('approved-content-comment')
                        <th>وضعیت نظر</th>
                        @endcan
                        <th>وضعیت پاسخ</th>
                        <th>وضعیت تایید</th>
                        <th class="text-center"><i class="fa fa-cogs ms-2"></i>تنظیمات</th>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)

                        {{-- approved button status check and show --}}
                        @php
                        $btn_style = ($comment->approved == 1) ? 'warning' : 'success';
                        $icon_style = ($comment->approved == 1) ? 'clock' : 'check';
                        $btn_text = ($comment->approved == 1) ? 'عدم تایید' : 'تایید';
                        $attr_checked = ($comment->approved == 1) ? 'checked' : '';
                        @endphp

                        {{-- notif for unseen comment --}}
                        @php
                        $bg_notif = ($comment->seen == 0) ? 'bg-new-notif' : '';
                        $icon_notif = ($comment->seen == 0) ? 'icon-before-notif' : '';

                        @endphp


                        <tr class="align-middle {{$bg_notif}}">
                            <td class="position-relative {{$icon_notif}}"></td>
                            <th>{{ iteration($loop->iteration, request()->page) }}</th>
                            <td>{{$comment->id}}</td>
                            <td>{{$comment->author->full_name}}</td>
                            <td>{{$comment->author_id}}</td>
                            <td class="text-truncate" style="max-width: 120px;" title="{{$comment->commentable->title}}">{{$comment->commentable->title}}</td>
                            <td>{{$comment->commentable->id}}</td>
                            <td>{{jalaliDate($comment->created_date)}}</td>
                            @can('approved-content-comment')
                            <td>
                                <section>
                                    <div class="custom-switch custom-switch-label-onoff d-flex align-content-center" dir="ltr">
                                        <input data-url="{{ route('admin.content.comment.status', $comment->id) }}" onchange="changeStatus(this.id)" class="custom-switch-input" id="{{ $comment->id }}" name="status" type="checkbox" @checked($comment->status) >
                                        <label class="custom-switch-btn" for="{{ $comment->id }}"></label>
                                    </div>
                                </section>
                            </td>
                            @endcan
                            <td>{{ $comment->answer == null ? 'بدون پاسخ' : 'پاسخ داده شده'}}</td>
                            <td>{{ $comment->approved == 1 ? 'تایید شده' : 'در انتظار تایید'}}</td>
                            <td class=" text-start">

                                @can('show-content-comment')
                                <a href="{{ route('admin.content.comment.show', $comment->id ) }}" class="btn btn-info btn-sm text-white"><i class="fa fa-eye ms-1 align-middle"></i>نمایش</a>
                                @endcan
                                @can('approved-content-comment')
                                <button {{$attr_checked}} type="button" data-url="{{ route('admin.content.comment.approved', $comment->id) }}" onclick="approvedstatus(this.id)" id="{{ $comment->id }}-approved" class="btn btn-{{$btn_style}} btn-sm"><i class="fa fa-{{$icon_style}} ms-1 align-middle"></i>{{$btn_text}}</button>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr class="align-middle">
                            <th colspan="" class="text-center emptyTable  py-4">جدول نظرات خالی می باشد</th>
                        </tr>
                        @endforelse
                </table>
                <section class="mb-3 mt-5 d-flex justify-content-center border-0">
                    <nav>
                        {{ $comments->links('pagination::bootstrap-5') }}
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
<script src="{{ asset('admin-assets/js/plugin/ajaxs/approved-ajax.js') }}"></script>
@endsection