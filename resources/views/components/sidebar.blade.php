<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<div class="sidebar" id="sidebar">
    <ul class="list" style="height: 100vh;">
        <li class="<?php if("Pagina Principal" == $Sidebar){echo "active";} ?>" onclick="window.open('<?= $APP_URL ?>/','_self')">
            <span class="list-title">
                <a class="no-link">
                    <i class="fa fa-home"></i>
                    <b>Pagina Principal</b>
                </a>
            </span>
        </li>

        <!-- ADICIONAR LOOP PARA SIDEBAR -->

        <li class="<?php if("Usuario" == $Sidebar){echo "active";} ?>">
            <span class="list-title">
                <i class="fa fa-user"></i>
                <b>{{ Auth::user()->nome }}</b>
                <i class="fa fa-chevron-down"></i>
            </span>
            <ul class="list inner">
                <div class="content">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    <li onclick="document.getElementById('logout-form').submit();">
                        @csrf
                        Finalizar sessão
                    </li>
                    </form>
                </div>
            </ul>
        </li>
    </ul>
</div>
<script>
function toggleSidebar(){
    $("#sidebar").toggleClass("toggle-sidebar");
}
</script>
