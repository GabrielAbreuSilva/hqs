<?php
//verificar se nao esta logado
if(!isset($pagina)){
  exit;
}

$msg = NULL;

//verificar se foi dado POST
if($_POST){
  //iniciar as variaveis
  $login = $senha = "";
  //recuperar o login e a senha digitados
  if(isset($_POST["login"]))
    $login = trim ( $_POST["login"]);
   
  if (isset($_POST["senha"]))
   $senha = trim ($_POST["senha"]);

  if(empty($login ) ) 
    $msg = '<p class="alert alert-danger">Preencha o campo login</p>';
    
    else if (empty($senha))
    $msg = '<p class="alert alert-danger">preencha o campo senha</p>';

    else{
      //verificar se o login existe
      $sql = "select id, nome, login, senha, foto from usuario where login = ? limit 1";
      
      //apontar a conexao com o banco
      //preparar o sql para a execucao
      $consulta = $pdo->prepare($sql);

      //passar o parametro para o sql
      $consulta->bindParam(1, $login);

      //executa o sql
      $consulta->execute();

      //puxar os dados do resultado
      $dados = $consulta->fetch(PDO::FETCH_OBJ);
    
      if (empty ( $dados->id ))
        $msg = '<p class = "alert alert-danger">O usuario não existe!</p>';
     
      //verificar se a senha esta correta
      else if (!password_verify($senha, $dados->senha)) 
      $msg = '<p class="alert alert-danger">Senha Incorreta</p>';
      //se deu certo
      else{
        //registrar este usuario na sessao
        $_SESSION["hqs"] = array("id"  => $dados->id,
                                 "nome"=> $dados->nome,
                                 "foto"=> $dados->foto);
        //redirecionar para o home
        $msg = 'Deu Certo!'; 
        //javaScript para redirecionar
        echo '<script>location.href="paginas/home";</script>';                        
      }
    }
  }

?>
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bem Vindo ao Sistema!</h1>
                  </div>
                  <?=$msg;?>
                  <form class="user" name="login" method="post" data-parsley-validate>
                    <div class="form-group">
                      <input type="text" name="login" class="form-control form-control-user" id="login" placeholder="Digite o nome de usuário..." required data-parsley-required-message="Preencha o Login">
                    </div>
                    <div class="form-group">
                      <input type="password" name="senha" class="form-control form-control-user" id="senha" placeholder="Digite a senha..." required data-parsley-required-message="Preencha a Senha">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="lembrar">
                        <label class="custom-control-label" for="lembrar">Lembrar Login</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>