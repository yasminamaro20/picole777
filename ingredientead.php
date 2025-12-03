<?php

// Conexão com o banco
$con = new mysqli("localhost", "root", "", "ingredientes");
if ($con->connect_error) {
    die("Erro na conexão: " . $con->connect_error);
}

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $preco = $_POST['precounitario'];
    $unidade = $_POST['unidademedia'];
    $estoqueatual = $_POST['EstoqueAtual'];
    $estoqueminimo = $_POST['EstoqueMinimo'];

    $stmt = $con->prepare("INSERT INTO cadastroingredientes  (nome, preco , unidademedida, estoqueatual, estoqueminimo) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $nome, $preco, $unidade, $estoqueatual, $estoqueminimo);
    $stmt->execute();
    $stmt->close();

    // Atualiza a página após salvar
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Buscar sabores cadastrados
$result = $con->query("SELECT * FROM cadastroingredientes ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

  <style>
        /* --- Variáveis e Estilos Globais --- */
        :root {
            --cor-fundo-claro: #f8f9fc;
            --cor-texto-principal: #333333;
            --cor-texto-secundario: #666666;

            /* Cores Gerais */
            --gradiente-roxo-nav: linear-gradient(90deg, #5D54FE 0%, #EE3F89 100%);
            --gradiente-cadastro-ativo: linear-gradient(90deg, #FF69B4 0%, #E94F8A 100%);

            /* Cores Específicas do Módulo Ingredientes (Verde) */
            --cor-modulo-principal: #4CD964;
            /* Verde principal */
            --gradiente-novo-ingrediente: linear-gradient(45deg, #4CD964, #34AA44);
            /* Verde vibrante */
            --cor-tag-bg: #e6ffec;
            /* Verde bem claro para a tag */

            --cor-botao-cancelar: #f0f0f5;
            --cor-input-borda: #ccc;
            --cor-placeholder: #a0a0a0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            line-height: 1.6;
            background: radial-gradient(circle at top left, rgba(238, 238, 255, 0.5) 0%, transparent 40%),
                radial-gradient(circle at bottom right, rgba(255, 230, 255, 0.5) 0%, transparent 40%),
                var(--cor-fundo-claro);
            min-height: 100vh;
        }

        /* ------------------------------------------------------------------ */
        /* --- NAV BAR --- */
        /* ------------------------------------------------------------------ */
        .navbar-container {
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 10px 0;
        }

        .navbar {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-icon {
            width: 35px;
            height: 35px;
            margin-right: 10px;
            background: var(--gradiente-roxo-nav);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 1.4rem;
        }

        .logo-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--cor-texto-principal);
            display: block;
            line-height: 1;
        }

        .logo-subtitle {
            font-size: 0.75rem;
            font-weight: 400;
            color: var(--cor-texto-secundario);
            display: block;
            line-height: 1;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 10px;
        }

        .nav-links a {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 15px;
            color: var(--cor-texto-principal);
            font-weight: 600;
            transition: background 0.3s, color 0.3s;
        }

        .nav-links .active {
            background: var(--gradiente-cadastro-ativo);
            color: white !important;
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.5);
        }

        /* ------------------------------------------------------------------ */
        /* --- CONTEÚDO PRINCIPAL --- */
        /* ------------------------------------------------------------------ */
        .main-content {
            max-width: 1300px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header-gerenciamento {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-gerenciamento .tag-gerenciamento {
            background-color: var(--cor-tag-bg);
            color: var(--cor-modulo-principal);
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .header-gerenciamento .tag-gerenciamento i {
            margin-right: 5px;
        }

        .header-gerenciamento h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: -webkit-linear-gradient(45deg, var(--cor-modulo-principal), #2E8B57);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }

        .header-gerenciamento p {
            font-size: 1rem;
            color: var(--cor-texto-secundario);
            margin-top: 5px;
        }

        /* Botão Novo Ingrediente */
        .btn-novo-item {
            display: inline-flex;
            align-items: center;
            padding: 12px 25px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            color: white;
            background: var(--gradiente-novo-ingrediente);
            box-shadow: 0 4px 15px rgba(76, 217, 100, 0.6);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-novo-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 217, 100, 0.8);
        }

        .btn-novo-item i {
            margin-right: 10px;
        }

        /* Card de Conteúdo */
        .content-card {
            gap:100px;
            justify-content: space-around;
            display:flex;
            background-color: white;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        /* Estado Vazio */
        .empty-state {
            padding: 40px 0;
        }

        .empty-state-icon i.fa-leaf {
            font-size: 5rem;
            color: #C8E6C9;
            margin-bottom: 20px;
            display: block;
        }

        .empty-state-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--cor-texto-principal);
            margin-bottom: 5px;
        }

        .empty-state-subtitle {
            color: var(--cor-texto-secundario);
            margin-bottom: 30px;
        }

        .btn-adicionar-item {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            color: white;
            background: var(--gradiente-novo-ingrediente);
            box-shadow: 0 2px 10px rgba(76, 217, 100, 0.4);
            transition: transform 0.3s;
        }

        .btn-adicionar-item i {
            margin-right: 8px;
        }

        /* Tabela de Ingredientes */
        .ingredient-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
            text-align: left;
        }

        .ingredient-table th {
            color: var(--cor-texto-secundario);
            font-weight: 600;
            padding: 10px 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .ingredient-table td {
            background-color: #fcfcfc;
            border-radius: 10px;
            padding: 15px 20px;
            color: var(--cor-texto-principal);
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .ingredient-table tbody tr:hover td {
            background-color: #f6f6f6;
        }

        .ingredient-table .actions-cell {
            text-align: right;
        }

        .ingredient-table .action-btn {
            background: none;
            border: none;
            color: #888;
            cursor: pointer;
            font-size: 1rem;
            margin-left: 15px;
            transition: color 0.2s;
        }

        .ingredient-table .action-btn:hover {
            color: var(--cor-modulo-principal);
        }

        .stock-level {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-block;
        }

        .stock-ok {
            background-color: #e6ffec;
            color: #38a169;
        }

        /* Verde para estoque OK */
        .stock-low {
            background-color: #fffde7;
            color: #f6ad55;
        }

        /* Amarelo para estoque Baixo */
        .stock-critical {
            background-color: #fee2e2;
            color: #e53e3e;
        }

        /* Vermelho para estoque Crítico */


        /* ------------------------------------------------------------------ */
        /* --- MODAL --- */
        /* ------------------------------------------------------------------ */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-card {
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 500px;
            position: relative;
            background: radial-gradient(circle at top left, rgba(238, 238, 255, 0.2) 0%, transparent 40%), radial-gradient(circle at bottom right, rgba(255, 230, 255, 0.2) 0%, transparent 40%), white;
        }

        .modal-card h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: left;
            background: -webkit-linear-gradient(45deg, #FF69B4, #EE3F89);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }

        .modal-card .close-btn {
            position: absolute;
            top: 25px;
            right: 25px;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--cor-texto-secundario);
            cursor: pointer;
            transition: color 0.2s;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
            flex: 1;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--cor-texto-principal);
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--cor-input-borda);
            border-radius: 10px;
            font-size: 1rem;
            background-color: #fcfcfc;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group input:focus {
            border-color: #EE3F89;
            box-shadow: 0 0 0 3px rgba(238, 63, 137, 0.2);
            outline: none;
        }

        .unidade-exemplo {
            display: block;
            font-size: 0.75rem;
            color: var(--cor-placeholder);
            margin-top: -15px;
            margin-bottom: 10px;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-cancelar {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            background-color: var(--cor-botao-cancelar);
            color: var(--cor-texto-principal);
            transition: background-color 0.2s;
        }

        .btn-cadastrar {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            color: white;
            background: var(--gradiente-novo-ingrediente);
            box-shadow: 0 4px 10px rgba(76, 217, 100, 0.4);
            transition: background 0.2s;
        }
        .juncao{
            display:flex;
            gap:300px;
        }
    </style>
</head>
<body>
    <body onload="loadIngredients()">

    <header class="navbar-container">
        <nav class="navbar">
            <div class="logo">
                <div class="logo-icon"><i class="fas fa-ice-cream"></i></div>
                <div>
                    <span class="logo-name">Picolé Manager</span>
                    <span class="logo-subtitle">Sistema de Gestão Premium</span>
                </div>
            </div>
            <ul class="nav-links">
                <li><a href="index.html">Início</a></li>
                <li><a href="cadastros-modulo.html" class="active">Cadastros</a></li>
                <li><a href="#">Produção</a></li>
                <li><a href="#">Relatórios</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">

        <!--title header-->

        <div class="header-gerenciamento">
            <div>
                <span class="tag-gerenciamento"><i class="fas fa-seedling"></i> Gerenciamento</span>
                <h1>Ingredientes</h1>
                <p>Controle de estoque e preços</p>
            </div>
        </div>

        <!--separação entre form e local que aparece os dados-->

      
        <div class="content-card">

          <section class="juncao">
            
            <form method="post" action="" class="form-card">
                <div class="form-group">
                    <label for="nome">Ingrediente </label>
                    <input type="text" name="nome" id="nomesorvete" required>
                </div>

                <div class="form-group">
                    <label for="precounitario">Preço unitário</label>
                    <input type="text" name="precounitario" id="precounitario" required>
                </div>

                <div class="form-group">
                    <label for="descricao">Unidade media</label>
                    <input name="unidademedia" id="descricao" required>
                </div>
                 <div class="form-group">
                    <label for="descricao">Estoque Atual</label>
                    <input name="EstoqueAtual" id="descricao" required>
                </div>
                
                <div class="form-group">
                    <label for="descricao">Estoque minimo</label>
                    <input name="EstoqueMinimo" id="descricao" required>
                </div>

                <button type="submit" class="btn-adicionar-sabor full-width">
                    <i class="fas fa-save"></i> Salvar ingrediente
                </button>
            </form>


            
             <section id="mainCard" class="main-card-content" >
            <?php
$temDados = ($result->num_rows > 0);
?>


           <div id="emptyState" class="empty-state" style="display: <?= $temDados ? 'none' : 'block' ?>;">

                <div class="empty-icon"><i class="fas fa-tint"></i></div>
                <h3>Nenhum sabor cadastrado</h3>
                <p>Comece adicionando seu primeiro sabor de picolé</p>
                <button type="button" class="btn-adicionar-sabor" onclick="abrirModal('novo')">
                    <i class="fas fa-plus"></i> Adicionar Sabor
                </button>
            </div>

           <div id="dataTable" class="sabores-table-container" style="display: <?= $temDados ? 'block' : 'none' ?>;">

                <table class="sabores-table">
                    <thead>
                        <tr>
                            <th>Nome e Descrição</th>
                            <th>Preço Unitário</th>
                            <th style="width: 150px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="saboresList">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <div class="sabor-nome"><?= $row['nome'] ?></div>
                    <div class="sabor-descricao"><?= $row['descricao'] ?></div>
                </td>
                <td class="sabor-preco">R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
                <td>
                    <button class="btn-novo-sabor">Editar</button>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php endif; ?>
</tbody>
                </table>
            </div>

        </section>
            </section>


           
        </div>

    </main>

    
</body>
</html>



