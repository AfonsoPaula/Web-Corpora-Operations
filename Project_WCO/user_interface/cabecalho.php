<!doctype html>
<html lang="pt">
    
    <head>
        <!-- meta tags necessárias -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Web Corpus Operations</title>
        <link rel="shortcut icon" href="img/pag_icon.ico">

        <!-- para o CSS Bootstrap e CSS -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <!-- para as fontes de letra -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat+Subrayada:wght@700&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap">

        <!-- para o icon -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <!-- para o javascript, assim como para os gráficos chart.js -->
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Para alertas -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    </head>

    <body class="bg-image d-flex flex-column vh-100 pt-5 mb-0">
        <style>
            .bg-image{
                background-image: url('img/fundo4.jpg');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                height: 100%;
            }

            html, body {
                height: 100%;
            }
        </style>
        <!-- Construção do cabeçalho da aplicação -->
        <header class="fixed-top">
            <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #395d73">
                <div class="container">
                    <h1><a href="index.php?p=paginainicial" class="navbar-brand bg-white font-weight-bold p-3 rounded" style="font-family: 'Montserrat Subrayada', sans-serif;color: #043755">Web Corpora Operations</a></h1>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mynav" aria-controls="mynav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="mynav">  
                        <ul class="navbar-nav ml-auto text-center">
                            <li class="item nav-item"><a class="nav-link" href="index.php?p=paginainicial">Página Inicial</a></li>
                            <li class="item nav-item"><a class="nav-link" href="index.php?p=polaridade">Polaridade</a></li>
                            <li class="item nav-item"><a class="nav-link" href="index.php?p=estatisticas">Estatísticas</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <script>
                // Script para os itens do menu
                document.addEventListener('DOMContentLoaded', function() {
                    const lista = document.querySelector('ul');
                    const lis = lista.getElementsByTagName('li');
                    // Aceder a cada elemento <a> dentro de <li>
                    for (let i = 0; i < lis.length; i++) {
                        const li = lis[i];
                        const link = li.querySelector('a'); 
                        //mouseover
                        li.addEventListener('mouseover', () => {
                        li.style.backgroundColor = 'white';
                        link.style.color = '#395d73';
                        link.style.textShadow = '0 0 5px rgba(0, 0, 0, 0.3)';
                        li.style.transform = 'scale(1.1)';
                        li.style.transition = 'transform 0.3s';
                        });
                        // mouseout
                        li.addEventListener('mouseout', () => {
                        li.style.backgroundColor = 'transparent';
                        link.style.color = 'white';
                        link.style.textShadow = 'none';
                        li.style.transform = 'scale(1)';
                        li.style.transition = 'transform 0.3s';
                        });
                    }
                });
            </script>
        </header>