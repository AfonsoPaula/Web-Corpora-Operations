        <style>
            footer {
                bottom: 0;
                left: 0;
                width: 100%;
            }
        </style>
        
        <footer class="text-center mt-5 pt-1" style="background-color: #043755;">
            <div class="container text-white">
                <div class="row">
                    <div class="col-12">
                        <p>&copy; <span id="anoAtual"></span> Universidade da Beira Interior. Todos os direitos reservados.</p>
                        <p>Visite a página do <a href="https://www.ubi.pt/Entidade/Departamento_de_Informatica" target="_blank">Departamento de Informática</a> para mais informações.</p>
                    </div>
                </div>
            </div>
        </footer>

        <script>
            // Obter o ano atual
            var anoAtual = new Date().getFullYear();
            
            // Atualizar o elemento de texto com o ano atual
            document.getElementById("anoAtual").textContent = anoAtual;
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>