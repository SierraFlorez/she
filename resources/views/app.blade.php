<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
@include('partials.htmlheader')

<body>

    @include('partials.mainheader')
    @include('partials.sidebar')

    <section>
           
        <div class="dashboard-wrapper imgbackground"
            style="background-image: url('images/CEAIbackground1.png'); background-repeat: no-repeat; background-position: -20% 68%">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                      

                <!-- Your Page Content Here -->
                @yield('main-content')
            </div>
        </div>
        <br>
    </section>
    @include('partials.footer')
    @include('partials.scripts')
</body>

</html>