<?php
    //verificar se nao esta logado
    if (!isset ($_SESSION["hqs"]["id"])) {
        exit;
    }
    ?>
    <div class="container">
        <h1 class="float-left">Lista de Tipo de Quadrinhos</h1>
        <div class="float-right">
        <a href="cadastro/tipo" class="btn btn-success">Novos Registros</a>
        <a href="listar/tipo" class="btn btn-info">Lista de Registros</a>
        </div> 

        <div class="clearfix"></div>
    <table class="table table-striped table-bordered table-hover" id="tabela">
        <thead>
            <tr>
                <td>ID</td>
                <td>Tipo do Quadrinho</td>
                <td>Opções</td>
            </tr>
        </thead>
        <tbody>
            <?php
            //buscar os tipos alfabeticamente
            $sql = "select * from tipo order by id";
            $consulta = $pdo->prepare($sql);
            $consulta->execute();
            
            while($dados = $consulta->fetch(
                PDO::FETCH_OBJ)){
                    //separar os dados
                    $id     = $dados->id;
                    $tipo   = $dados->tipo;
                    //mostrar na tela
                    echo '<tr>
                        <td>'.$id.'</td>
                        <td>'.$tipo.'</td>
                        <td>
                            <a href="cadastro/tipo/'.$id.'"class="btn btn-success btn-sm">
                            <i class ="fas fa-edit"></i></a>
                        </td>
                    </tr>';
                    }
            
            ?>
        </tbody>    
    </table>

    <script type="text/javascript">
        //adicionar o dataTable a minha tabela
        $(document).ready( function () {
            $('#tabela').DataTable({
                "language": {
            "lengthMenu": "Mostrando _MENU_ registros por pagina",
            "zeroRecords": "Nenhum arquivo - Desculpe-nos!",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Não contem registros válidos!",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Busca"
            
        }
        
            });
        } );
    
    
    </script>

</div>    