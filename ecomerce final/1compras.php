<?php
session_start();

// Inicializa carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Se receber um POST para adicionar item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['nome'], $_POST['preco'], $_POST['tamanho'])) {
    $chave = $_POST['id'] . '-' . $_POST['tamanho']; // chave única por produto e tamanho
    if (isset($_SESSION['carrinho'][$chave])) {
        $_SESSION['carrinho'][$chave]['quantidade']++; // se já existir, soma 1
    } else {
        $_SESSION['carrinho'][$chave] = [
            'id' => $_POST['id'],
            'nome' => $_POST['nome'],
            'preco' => $_POST['preco'],
            'tamanho' => $_POST['tamanho'],
            'quantidade' => 1
        ];
    }
    // Evita reenvio do formulário ao atualizar a página
    header("Location: 1compras.php");
    exit;
}

// Array de produtos (simulando um banco de dados)
$produtos = [
    ["id" => 1, "nome" => "Barça 2011 - Iniesta", "preco" => 299.99, "vendidas" => 5, "estoque" => 20, "imagem" => "Imagens/barça_2011.jpg"],
    ["id" => 2, "nome" => "Chelsea 2011", "preco" => 199.90, "vendidas" => 7, "estoque" => 1, "imagem" => "Imagens/chelsea_2011.jpg"],
    ["id" => 3, "nome" => "Real Madrid 2010", "preco" => 199.90, "vendidas" => 2, "estoque" => 5, "imagem" => "Imagens/real_2010.jpg"],
    ["id" => 4, "nome" => "Camisa CR7  2008", "preco" => 280.99, "vendidas" => 5, "estoque" => 3, "imagem" => "Imagens/camisa cr7 2008.jpg"],
    ["id" => 5, "nome" => "Inter de Milao 2010", "preco" => 230.90, "vendidas" => 7, "estoque" => 1, "imagem" => "Imagens/inter de milao 2010.jpg"],
    ["id" => 6, "nome" => "Milan 2010", "preco" =>150.00, "vendidas" => 2, "estoque" => 5, "imagem" => "Imagens/milan 2010.jpg"],
    ["id" => 7, "nome" => "Brasil 2001", "preco" => 240.90, "vendidas" => 7, "estoque" => 1, "imagem" => "Imagens/brasil 2001.webp"],
    ["id" => 8, "nome" => "Bayern Munique 2013", "preco" => 110.90, "vendidas" => 2, "estoque" => 5, "imagem" => "Imagens/bayern 2013.jpg"],
];

// Calcula quantidade total no carrinho para o contador
$totalCarrinho = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $totalCarrinho += $item['quantidade'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Camisas Relíquias</title>
    <style>
        .titulo {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            color: #000000ff;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 16px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
            padding: 10px;
            width: 250px;
            text-align: center;

            /* Alinhamento vertical */
            display: flex;
            flex-direction: column;
            justify-content: space-between;F
            height: 420px; /* altura fixa para padronizar */
        }
        img {
            max-width: 60%;
            height: auto;
            margin: 0 auto;
        }
        .carrinho {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .carrinho img {
            width: 40px;
            height: auto;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .carrinho img:hover {
            transform: scale(1.1);
        }
        .contador {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 14px;
        }

        .tamanhos {
            margin-top: auto; /* joga os botões pro fim do card */
            display: flex;
            justify-content: center;
            gap: 10px;
         }
        .tamanhos form {
            margin: 0;
         }
        button {
            background: #2831a7ff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 10px;
            cursor: pointer;
            margin: 5px;
            
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

    <h2 class="titulo">Camisas Relíquias</h2>

    <!-- Ícone do carrinho -->
    <div class="carrinho">
        <a href="2carrinho.php">
            <img src="imagens/carrinho.png" alt="Carrinho">
            <span class="contador"><?= $totalCarrinho ?></span> <!-- mostra quantidade de itens -->
        </a>
    </div>

    <div class="container">
        <?php foreach ($produtos as $p): ?>
            <div class="card">
                <h3><?= $p['nome'] ?></h3>
                <img src="<?= $p['imagem'] ?>" alt="<?= $p['nome'] ?>">
                <p>Preço: R$ <?= number_format($p['preco'],2,",",".") ?></p>
                <p>Unidades vendidas: <?= $p['vendidas'] ?></p>
                <p>Estoque disponível: <?= $p['estoque'] ?></p>

                <!-- Botões de tamanho enviados via POST -->
                <div class="tamanhos">
                <form method="post">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <input type="hidden" name="nome" value="<?= $p['nome'] ?>">
                    <input type="hidden" name="preco" value="<?= $p['preco'] ?>">
                    <input type="hidden" name="tamanho" value="P">
                    <button type="submit">P</button>
                </form>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <input type="hidden" name="nome" value="<?= $p['nome'] ?>">
                    <input type="hidden" name="preco" value="<?= $p['preco'] ?>">
                    <input type="hidden" name="tamanho" value="M">
                    <button type="submit">M</button>
                </form>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <input type="hidden" name="nome" value="<?= $p['nome'] ?>">
                    <input type="hidden" name="preco" value="<?= $p['preco'] ?>">
                    <input type="hidden" name="tamanho" value="G">
                    <button type="submit">G</button>
                </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>

