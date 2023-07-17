<?php
    // Conexão à base de dados
    require_once 'dbConfig.php';

    $palavra = $_POST['palavra'];
    $inicio_date = $_POST['inicio_date'];
    $fim_date = $_POST['fim_date'];

    // Pesquisar a palavra de dados usando a classe PDO
    $query = $conn->prepare("SELECT [CreatedAt], [Post], [Polarity], [URL] FROM [SNCrawler].[dbo].[Post] WHERE [Post] LIKE :palavra AND [CreatedAt] BETWEEN :inicio_date AND  :fim_date ORDER BY CreatedAt DESC");
    $query->bindValue(':palavra', "%$palavra%");
    $query->bindValue(':inicio_date', $inicio_date);
    $query->bindValue(':fim_date', $fim_date);
    $query->execute();
    $Table_Info = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Mensagem de Alerta caso não sejam encontrados quaisquer Tweets -->
<?php if($query->rowCount() == 0){ ?>
    <div id='msgErroProcurar' class='alert alert-warning text-center mx-auto m-5' role='alert' style="width:80%">
        <p>Não foi encontrado nenhum tweet relacionado com a palavra/frase <strong><?php echo ($palavra)?></strong>.</p>
        <p>Podes tentar de novo alterando as datas que introduziste, ou procura por outra palavra/frase!</p>
        <hr>
        <button id="tentarAgain" type="button" class="btn btn-secondary">Tentar de novo</button>
    </div>
<?php } ?>

<!-- Div que mostra os resultados obtidos -->
<div class="pesquisaProc ml-4 mr-4">
    <!-- Caso existam resultados -->
    <?php if (!empty($Table_Info)) : ?>
        <!-- Div que mostra o resumo dos dados obtidos -->
        <div id="sucessoProc" class="alert alert-success mx-auto text-center border mt-5 mb-3" style="width: 50%;" role="alert">
            <h5>Foram encontrados <u><strong><?php echo count($Table_Info)?></strong></u> resultados!</h5>
            <hr>
            <h5>Palavra(s) introduzida(s): <u><strong><?php echo ($palavra)?></strong></u>.</h5>
            <hr>
            <h5>Datas: <u><strong><?php echo ($inicio_date)?></strong></u>/<u><strong><?php echo ($fim_date)?></strong></u></h5> 
            <hr>
            <button id="verResultadosProc" type="button" class="btn btn-primary">Ver Resultados</button>
        </div>
        <!-- T A B E L A   R E S U L T A D O S -->
        <style>
            .postProc-cell {
                max-width: 800px; /* Largura máxima da célula */
                white-space: nowrap; /* Impede que o texto quebre em várias linhas */
                overflow: hidden; /* Esconde o conteúdo excessivo */
                text-overflow: ellipsis; /* Adiciona reticências (...) quando o texto é cortado */
                cursor: pointer; /* Transforma o cursor numa mãozinha ao passar o mouse sobre a célula */
            }
            .postProc-cell:hover {
                white-space: normal;
                overflow: visible; /* Mostra todo o conteúdo ao passar o mouse sobre a célula */
            }
        </style>
        <div id="tabelaProc" class="bg-dark mt-5 mx-auto" style="width: 100%;">
            <div class="table-responsive">
                <table class="table table-striped table-dark table-bordered mx-auto">
                    <thead class="thead-dark text-center">
                        <tr>
                        <th class="bg-info">Data de Criação</th>
                        <th class="bg-info">Tweet</th>
                        <th class="bg-info">URL</th>
                        </tr>
                    </thead>
                    <tbody class="thead-dark text-center">
                        <?php foreach ($Table_Info as $tweet) : ?>
                        <tr>
                        <td><?php echo $tweet["CreatedAt"]; ?></td>
                        <td class="postProc-cell text-white text-left bg-secondary"><?php echo $tweet["Post"]; ?></td>
                        <td><a href="<?php echo $tweet["URL"]; ?>" target="_blank" class="btn btn-primary">Link Original</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Botão que permite voltar ao topo da página -->
            <div class='row mx-auto'>
                <div class='col p-3 pr-3 text-center'>
                    <button type="button" id="btnVoltarPesquisar" class="btn btn-primary btn-lg btn-block mb-2 mt-0 mx-auto" style="width: 60%;" onclick="">&#11014; Voltar a Pesquisar &#11014;</button>
                </div>
            </div>
        </div>
    <?php endif;?>
</div>

<script>
    //------------------------------------------------------------------------------------
    // Caso existam palavras encontradas, inserimos um resumo dos resultados, onde
    // é feito o posicionamento desse resumo, assim como é adicionado um botão com um
    // evento de 'scroll' ao ser usado.

    // Obtém as referências para a que será movida e para o elemento pai delas
    var div1 = document.getElementById("infoProc");
    var div3 = document.getElementById("formProc");
    var elementoPai = div1.parentNode;
    // Obtém a referência para a nova div que será inserida
    var sucesso = document.getElementById("sucessoProc");
    
    // Insere a nova div entre as outras
    elementoPai.insertBefore(sucesso, div3);

    // Obtém a referência para o botão e para a tabela
    var botao = document.getElementById("verResultadosProc");
    var resultados = document.getElementById("formProc");

    // Adiciona um manipulador de eventos ao botão
    botao.addEventListener("click", function() {
        // Usa o método scrollIntoView() para rolar até a tabela
        resultados.scrollIntoView();
    });

    function scrollToElement() {
        var elemento = document.getElementById("sucessoProc");
        elemento.scrollIntoView({ behavior: "smooth" });
    }
    //------------------------------------------------------------------------------------
    // Aguarda até que a página esteja totalmente carregada
    window.addEventListener('load', function() {
        // Obtenha todas as células da tabela com a classe 'cell'
        var cells = document.getElementsByClassName('postProc-cell');

        // Para cada célula
        for (var i = 0; i < cells.length; i++) {
            var cell = cells[i];

            // Guarda o texto completo da célula
            cell.setAttribute('data-full-text', cell.textContent.trim());
        }
    });    
    //------------------------------------------------------------------------------------
    // Permite que o botão de "Voltar a Pesquisar" faça um scroll automático para o 
    //o formulário e selecione igualmente o campo para inserir a palavra/frase
    var botaoVoltarProcurar = document.getElementById('btnVoltarPesquisar');
    var voltarPesquisar = document.getElementById('sucessoProc');
    var campoProcurar = document.getElementById('campoProcurar');
    botaoVoltarProcurar.addEventListener("click", function(){
        voltarPesquisar.scrollIntoView();
        campoProcurar.select();
    });
    //------------------------------------------------------------------------------------
</script>