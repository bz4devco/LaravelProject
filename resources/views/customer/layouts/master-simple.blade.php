<!doctype html>
<html lang="fa" dir="rtl">

<head>
    @include('customer.layouts.seo')
    @include('customer.layouts.head-tag')
    @yield('haed-tag')
</head>

<body>
    <!-- start main one col -->
    <main id="main-body-one-col" class="main-body">
        @yield('content')
    </main>
    <!-- end main one col -->
    
    @include('customer.layouts.script')
    @yield('script')
    
</body>

</html>
