<?php include("_head.php"); ?>
<style>
body{
    overflow: hidden;
}
</style>
@auth
    @include('components.top')   
    <div class="container-fluid" style="padding-left: 0">
        <div class="row">
            <div class="col-md-2">
                @include('components.sidebar')
            </div>
            <div class="col-md-10" style="padding-left: 1rem;overflow-y: auto;height: 90vh">
                <!-- Conteúdo da Home -->
                <p class="mt-3 h5">
                    Bem vindo(a), {{ Auth::user()->nome }}<br>
                </p>
                <hr>
                <p>
                    <span class="h6">Acesse os itens pelo menu lateral</span>
                </p>
                <p>
                    <?php
                        // Avisar da senha vencendo
                        $Busca = DB::SELECT('SELECT tab_usuario.validade_senha_usu FROM usuario.tab_usuario
                        WHERE tab_usuario.cif_usu = ?', [Auth::user()->cif_usu]);
                        $Hoje = date("Y-m-d");
                        $Dias30 = date('Y-m-d', strtotime($Hoje. ' + 30 day'));
                        $Validade = explode("-",$Busca[0]->validade_senha_usu);
                        $NovaValidade = $Validade[2]."-".$Validade[1]."-".$Validade[0];
                        
                        if($NovaValidade < $Dias30){
                            $Hoje = time(); // or your date as well
                            $Vencimento = strtotime($NovaValidade);
                            $Vence = (round(($Hoje - $Vencimento) / (60 * 60 * 24)) - 1) * -1;

                            $Validade = date_create($NovaValidade);
                            $Validade = date_format($Validade,"d/m/Y");

                            if($Vence > 0){
                                $txtvencimento = "<p class='h6 blink'>Sua senha vence em ".$Vence;
                                $txtvencimento .= $Vence > 1 ? " dias " : " dia ";
                                $txtvencimento .= "(". $Validade ."). <a href='$APP_URL/usuario/alterar'>Clique aqui</a> para alterar</p>"; 
                            } else{
                                $txtvencimento = "<p class='h6 blink'>Sua senha está vencida. <a href='$APP_URL/usuario/alterar'>Clique aqui</a> para alterar</p>";
                            }
                            echo $txtvencimento;
                        }
                    ?>
                </p>
                    @if(env("DB_NAME"))
                    <p class="text-danger fw-bold mt-2">
                        @if(env("DB_NAME") != "Produção")
                        Conectado a Base de {{ env("DB_NAME") }}
                        @endif
                    </p>
                    @endif
                </div>
            </div>
        </div>
<script>
    sessionStorage.removeItem("counter"); //Apaga o contador de tentativas de login
</script>    
@endauth
@yield('content')
<script>
<?php
    if($errors->any()){
    $msg = $errors->all(); 
?>
$(document).ready(function(){
    toastMixin.fire({
        timer: 2000,
        title: '<?= $msg[0] ?>',
        icon: 'warning'
    })
});

<?php } ?>
</script>
<?php include("_footer.php") ?>