<?php
    //verificar se nao esta logado
    if (!isset ($_SESSION["hqs"]["id"])) {
        exit;
    }
    ?>
    <div class="container">
        <h1 class="float-left">Listar Editora</h1>
        <div class="float-right">
        <a href="cadastro/editora" class="btn btn-success">Novos registros</a>
        <a href="listar/editora" class="btn btn-info">Listar registros</a>
        </div> 

        <div class="clearfix"></div>
    <table class="table table-striped table-bordered table-hover" id="tabela">
        <thead>
            <tr>
                <td>ID</td>
                <td>Nome da Editora</td>
                <td>Site da Editora</td>
                <td>Opções</td>
            </tr>
        </thead>
            <?php
            //buscar as editoras alfabeticamente
            $sql = "select * from editora order by nome";
            $consulta = $pdo->prepare($sql);
            $consulta->execute();
            
            while($dados = $consulta->fetch(
                PDO::FETCH_OBJ)){
                    //separar os dados
                    $id     = $dados->id;
                    $nome   = $dados->nome;
                    $site   = $dados->site;
                    //mostrar na tela
                    echo '<tr>
                        <td>'.$id.'</td>
                        <td>'.$nome.'</td>
                        <td>'.$site.'</td>
                        
                        <td>
                            <a href="cadastro/editora/'.$id.'"class="btn btn-success btn-sm">
                            <i class ="fas fa-edit"></i></a>

                            <a href="javascript:excluir('.$id.')" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i></a>
                       
                        </td>
                    </tr>';
                    }
            
            ?>
    </table>
</div>    

<script>
  //funcao para perguntar se deseja excluir
  //se sim direcionar para o endereço de exclusao
  function excluir( id ){
      //perguntar
      if(confirm("Deseja mesmo excluir?")){
          //direcionar pra exclusao
        location.href="excluir/editora/"+id;
      }
  }  
        //adicionar o dataTable a minha tabela
        $(document).ready( function () {
            $('#tabela').DataTable({
                "language": {
            "lengthMenu": "Mostrando _MENU_ registros por pagina",
            "zeroRecords": "Nenhum arquivo - Desculpe-nos!",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Não contem registros válidos!",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Busca",
            "Previous": "Anterior",
            "Next": "próximo"
        }
        
            });
        } );
</script>