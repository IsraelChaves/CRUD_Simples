<?php
require_once 'conexao.php';
?>
<h1>Listas de Usuários</h1>

<?php
    $sql = "SELECT * FROM usuarios";
    $res = $conn->query($sql);
    $qtd = $res->num_rows;

    if ($qtd > 0) {
        print "<table class='table table-hover table-striped table-bordered'>";
        print "<thead>";
        print "<tr>";
        print "<th>ID</th>";
        print "<th>Nome</th>";
        print "<th>Email</th>";
        print "<th>Ações</th>";
        print "</tr>";
        print "</thead>";
        print "<tbody>";

        while ($row = $res->fetch_object()) {
            print "<tr>";
            print "<td>$row->id</td>";
            print "<td>$row->nome</td>";
            print "<td>$row->email</td>";
            print "<td>
                    <a href='?page=editar&id=$row->id' class='btn btn-warning'>Editar</a>
                    <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=salvar&acao=excluir&id=".$row->id."';}else{false;}\" class='btn btn-danger'>Excluir</button>
                  </td>";
            print "</tr>";
        }

        print "</tbody>";
        print "</table>";
    } else {
        print "Nenhum usuário cadastrado.";
    }

?>