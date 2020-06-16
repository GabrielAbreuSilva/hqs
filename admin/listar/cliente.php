<?php
    //verificar se nao esta logado
    if (!isset ($_SESSION["hqs"]["id"])) {
        exit;
    }
    ?>
    <div class="container">
        <h1 class="float-left">Listar Clientes</h1>
        <div class="float-right">
        <a href="cadastro/cliente" class="btn btn-success">Novos registros</a>
    	</div> 

    <div class="clearfix"></div>
    <table class="table table-striped table-bordered table-hover" id="tabela">
        <thead>
            <tr>
                <td>ID</td>
                <td>Nome</td>
                <td>CPF</td>
                <td>Celular</td>	
                <td>E-mail</td>
                <td>Cidade</td>
                <td>Estado</td>
                <td>Endereço</td>
                <td>Opções</td>
            </tr>
        </thead>
        <?php
        $sql = "select c. id, c.nome, c.cpf, c.celular, c.email, c.endereco, ci.cidade, ci.estado
				from cliente c
				inner join cidade ci on ci.id = c.cidade_id
				order by c.nome";
        $consulta = $pdo->prepare($sql);
        $consulta->execute();

        foreach ($consulta->fetchAll(PDO::FETCH_OBJ) as $dados) { 
        ?>
          	<tr>
         		<td><?= $dados->id; ?></td>
           		<td><?= $dados->nome; ?></td>
           		<td><?= $dados->cpf; ?></td>
           		<td><?= $dados->celular; ?></td>
           		<td><?= $dados->email; ?></td>
           		<td><?= $dados->cidade; ?></td>
           		<td><?= $dados->estado; ?></td>
           		<td><?= $dados->endereco; ?></td>
           		<td>
           			<a href="cadastro/cliente/<?= $dados->id ?>" class="btn btn-success btn-sm" title="Editar <?= $dados->id ?>"></a>
                       <i class ="fas fa-edit"></i></a>
                       <a href="javascript:excluir('<?= $dados->id; ?>')" class="btn btn-danger btn-sm">
                       <i class="fas fa-trash"></i></a>   
                    </td>
            	</tr>
     	<?php
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
        location.href="excluir/cliente/"+id;
      }
  }  
        //adicionar o dataTable a minha tabela
        $(document).ready( function () {
            $('#tabela').DataTable({
                "language": {
            "lengthMenu": "Mostrando _MENU_ registros por pagina",
            "zeroRecords": "Nenhum registro salvo!",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Não possui registros válidos!",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Busca",
            "Previous": "Anterior",
            "Next": "Próximo"
        }
        
            });
        } );
</script>