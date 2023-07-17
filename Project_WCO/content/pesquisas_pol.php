<?php
    // Conexão à base de dados
    require_once 'dbConfig.php';

    $palavra = $_POST['palavra'];
    $inicio_date = $_POST['inicio_date'];
    $fim_date = $_POST['fim_date'];

    // Pesquisar a palavra de dados usando PDO
    $query = $conn->prepare("SELECT CreatedAt, Post, Polarity, URL FROM SNCrawler.dbo.Post WHERE Post LIKE :palavra AND CreatedAt BETWEEN :inicio_date AND :fim_date ORDER BY CreatedAt DESC");
    $query->bindValue(':palavra', "%$palavra%");
    $query->bindValue(':inicio_date', $inicio_date);
    $query->bindValue(':fim_date', $fim_date);
    $query->execute();
    $Table_Info = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Mensagem de Alerta caso não sejam encontrados quaisquer Tweets -->
<?php if($query->rowCount() == 0){ ?>
    <div id='msgErroPol' class='alert alert-warning text-center mx-auto m-5' role='alert' style="width:80%">
        <p>Não foi encontrado nenhum tweet relacionado com a palavra/frase <strong><?php echo ($palavra)?></strong>.</p>
        <p>Podes tentar de novo alterando as datas que introduziste, ou procura por outra palavra/frase!</p>
        <hr>
        <button id="tentarAgain2" type="button" class="btn btn-secondary">Tentar de novo</button>
    </div>
<?php } ?>

<!-- Div que mostra os resultados obtidos -->
<div id="pesquisaPol" class="mr-4 ml-4">
    <!-- Caso existam resultados -->
    <?php if (!empty($Table_Info)) :?>
    <!-- Div que mostra o resumo dos dados obtidos -->
    <div id="sucessoPol" class="alert alert-success mx-auto text-center border mt-5 mb-4" style="width: 50%;" role="alert">
        <h5>Foram encontrados <u><strong><?php echo count($Table_Info)?></strong></u> resultados!</h5>
        <hr>
        <h5>Palavra(s) introduzida(s): <u><strong><?php echo ($palavra)?></strong></u>.</h5>
        <hr>
        <h5>Datas: <u><strong><?php echo ($inicio_date)?></strong></u>/<u><strong><?php echo ($fim_date)?></strong></u></h5> 
        <hr>
        <button id="verResultados" type="button" class="btn btn-primary">Ver Resultados</button>
    </div>
    <!-- L E G E N D A -->
    <div id="legendaPol" class="card mx-auto mt-5" style="width: 60%">
        <div class="card-header text-center">
            <h5>Legenda</h5>
        </div>
        <div class="card-body text-center">
            <div class='row'>
                <div id="mpositivo" class='col font-weight-bold'>
                    Muito Positivo (2)
                </div>
                <div class='col'>
                    <span style="font-size: 1.5em;">&#129395;</span>
                </div>
            </div>
            <hr>
            <div class='row'>
                <div id="positivo" class='col font-weight-bold'>
                    Positivo (1)
                </div>
                <div class='col'>
                    <span style="font-size: 1.5em;">&#128077;</span>
                </div>
            </div>
            <hr>
            <div class='row'>
                <div id="neutro"class='col font-weight-bold'>
                    Neutro (0)
                </div>
                <div class='col'>
                    <span style="font-size: 1.5em;">&#128566;</span>
                </div>
            </div>
            <hr>
            <div class='row'>
                <div id="negativo" class='col font-weight-bold'>
                    Negativo (-1)
                </div>
                <div class='col'>
                    <span style="font-size: 1.5em;">&#128078;</span>
                </div>
            </div>
            <hr>
            <div class='row'>
                <div id="mnegativo" class='col font-weight-bold'>
                    Muito Negativo (-2)
                </div>
                <div class='col'>
                    <span style="font-size: 1.5em;">&#128545;</span>
                </div>
            </div>      
        </div>
    </div>
    <!-- T A B E L A   R E S U L T A D O S -->
    <style>
        .postPol-cell {
            max-width: 800px; /* Largura máxima da célula */
            white-space: nowrap; /* Impede que o texto quebre em várias linhas */
            overflow: hidden; /* Esconde o conteúdo excessivo */
            text-overflow: ellipsis; /* Adiciona reticências (...) quando o texto é cortado */
            cursor: pointer; /* Transforma o cursor numa mãozinha ao passar o mouse sobre a célula */
        }
        .postPol-cell:hover {
            white-space: normal;
            overflow: visible; /* Mostra todo o conteúdo ao passar o mouse sobre a célula */
        }
    </style>
    <div id="tabelaPol" class="bg-dark mt-5 mb-4 mx-auto" style="width: 100%;">
        <div class="table-responsive">
            <table class="table table-striped table-dark table-bordered">
                <thead class="thead-dark text-center">
                    <tr>
                    <th class="bg-info">Data de Criação</th>
                    <th class="bg-info">Tweet</th>
                    <th class="bg-info">Polaridade</th>
                    <th class="bg-info">URL</th>
                    </tr>
                </thead>
                <tbody class="thead-dark text-center">
                    <?php foreach ($Table_Info as $tweet) : ?>
                    <tr>
                    <td><?php echo $tweet["CreatedAt"]; ?></td>
                    <td class="tweets postPol-cell text-left text-white bg-secondary"><?php echo $tweet["Post"]; ?></td>
                    <td>
                        <?php if($tweet["Polarity"] == -2){ ?>
                            <span style="font-size: 2em;" data-toggle="tooltip" data-placement="right" title="-2"><?php echo '&#128545;'; ?></span>
                        <?php }elseif($tweet["Polarity"] == -1){ ?>
                            <span style="font-size: 2em;" data-toggle="tooltip" data-placement="right" title="-1"><?php echo '&#128078;'; ?></span>                            
                        <?php }elseif($tweet["Polarity"] == 0){ ?>
                            <span style="font-size: 2em;" data-toggle="tooltip" data-placement="right" title="0"><?php echo '&#128566;'; ?></span>
                        <?php }elseif($tweet["Polarity"] == 1){ ?>
                            <span style="font-size: 2em;" data-toggle="tooltip" data-placement="right" title="1"><?php echo '&#128077;'; ?></span>
                        <?php }elseif($tweet["Polarity"] == 2){ ?>
                            <span style="font-size: 2em;" data-toggle="tooltip" data-placement="right" title="2"><?php echo '&#129395;'; ?></span>
                        <?php }
                    ?></td>
                    <td><a href="<?php echo $tweet["URL"]; ?>" target="_blank" class="btn btn-primary">Link Original</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Botão que permite voltar ao topo da página -->
        <div class='row mx-auto'>
            <div class='col p-3 pr-3 text-center'>
                <button type="button" id="btnVoltarPol" class="btn btn-primary btn-lg btn-block mb-2 mt-0 mx-auto" style="width: 60%;" onclick="">&#11014; Voltar a Pesquisar &#11014;</button>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
    //--------------------------------------------------------------------------------
    // Obtém as referências para as divs que serão movidas e para o elemento pai delas
    var div1 = document.getElementById("infoPol");
        var div3 = document.getElementById("formPol");
        var elementoPai = div1.parentNode;
        // Obtém a referência para a nova div que será inserida
        var sucesso = document.getElementById("sucessoPol");
        // Insere a nova div entre as outras
        elementoPai.insertBefore(sucesso, div3);

        // Obtém a referência para o botão e para a tabela
        var botao = document.getElementById("verResultados");
        var resultados = document.getElementById("legendaPol");

        // Adiciona um manipulador de eventos ao botão
        botao.addEventListener("click", function() {
            // Usa o método scrollIntoView() para rolar até a tabela
            resultados.scrollIntoView();
        });
    //--------------------------------------------------------------------------------
    // Aguarde até que a página esteja totalmente carregada
    window.addEventListener('load', function() {
        // Obter todas as células da tabela com a classe 'cell'
        var cells = document.getElementsByClassName('postPol-cell');
        // Para cada célula
        for (var i = 0; i < cells.length; i++) {
            var cell = cells[i];

            // Salve o texto completo da célula
            cell.setAttribute('data-full-text', cell.textContent.trim());
        }
    });
    //--------------------------------------------------------------------------------
    function scrollToElement() {
        var elemento = document.getElementById("sucessoPol");
        elemento.scrollIntoView({ behavior: "smooth" });
    }
    //--------------------------------------------------------------------------------
    // Permite que o botão de "Voltar a Pesquisar" faça um scroll automático para o 
    //o formulário e selecione igualmente o campo para inserir a palavra/frase
    var botaoVoltarProcurar = document.getElementById('btnVoltarPol');
    var voltarPesquisar = document.getElementById('sucessoPol');
    var campoProcurar = document.getElementById('campoPol');
    botaoVoltarProcurar.addEventListener("click", function(){
        voltarPesquisar.scrollIntoView();
        campoProcurar.select();
    });
</script>