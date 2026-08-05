<style>
    @media screen and (min-width: 768px ){
        .hide-button{
            display: none;
        }
    }
</style>
<nav class="navbar sticky-top navbar-expand-md navbar-primary bg-light shadow-sm">
    <div class="container-fluid">
        @auth
        <div class="col-sm-1 hide-button">
            <button type="button" onclick="toggleSidebar()" class="btn btn-outline-secondary">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
        @endauth
        <div class="col-sm" style="display: contents;width: 100%">
            <div class="text-start">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-unicamp.png') }}" alt="" width="50" height="50">
                </a>
            </div>
            <div class="text-center">
                <h5 class="pt-2" href="{{ url('/') }}">
                    <div style="text-align:center;line-height:0.8">
                        <strong class="text-secondary">{{ config('app.name', 'Laravel') }}</strong><br>
                    </div>
                </h5>
            </div>
            <div class="text-end">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-hemocentro.png') }}" alt="" width="50" height="50">
                </a>
            </div>
        </div>
    </div>
</nav>  