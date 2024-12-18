<?php // Simulando um banco de dados na memória (arquivo único)
session_start();
if (!isset($_SESSION['posts'])) {
    $_SESSION['posts'] = [];
}

// Função para adicionar um novo post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_post'])) {
    $post_content = htmlspecialchars($_POST['new_post']);
    $_SESSION['posts'][] = [
        'content' => $post_content,
        'comments' => []
    ];
}

// Função para adicionar um comentário a um post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_comment'])) {
    $post_id = intval($_POST['post_id']);
    $comment_content = htmlspecialchars($_POST['new_comment']);
    if (isset($_SESSION['posts'][$post_id])) {
        $_SESSION['posts'][$post_id]['comments'][] = $comment_content;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google-site-verification" content="HW4ajMuFplkUQElMoszhFfzyXZEKJ6wsVIEWXhHuZtU" />
    <meta name="chat" content="Desabafo Anonimo">
    <meta name="author" content="PeakWeb">
 <link rel="shortcut icon" href="Icon.png" type="image/x-icon">
    <title>Desafafo Anônimo</title>
    <style>*{
margin: 0;
padding: 0;
}
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
       .titulo{ 
height: 100px;
font-family: serif;
color: aqua;
text-shadow: 0 2px 0 blue;
}
        .post, .comment {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .comment {
            margin-left: 20px;
            margin-top: 20px;
        }
input, textarea{
outline: 0;
}
button{
width: 80px;
height: 30px;
border-radius: 8px;
background-color: orange;
border-color: red;
color: blue;
}
    </style>
</head>
<body>
<details>
<summary>Detalhes</summary>
<br>
<p>Desabafe de forma anonima e segura</p>
</details>
<br>
    <h1 class="titulo">Desabafo Anônimo</h1>
    
    <!-- Formulário para criar um novo post -->
    <form method="post" style="margin-bottom: 20px;">
        <textarea name="new_post" placeholder="Escreva um post..." required rows="3" style="width: 100%;"></textarea><br>
        <button type="submit">Publicar</button>
    </form>

    <!-- Listagem de posts -->
    <?php if (empty($_SESSION['posts'])): ?>
        <p>Nenhum post ainda. Seja o primeiro a postar!</p>
    <?php else: ?>
        <?php foreach ($_SESSION['posts'] as $id => $post): ?>
            <div class="post">
                <p><strong>Postagem:</strong> <?= $post['content'] ?></p>

                <!-- Comentários -->
                <?php if (!empty($post['comments'])): ?>
                    <?php foreach ($post['comments'] as $comment): ?>
                        <div class="comment">
                            <p><strong>Comentário:</strong> <?= $comment ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Formulário para adicionar comentários -->
                <form method="post">
                    <input type="hidden" name="post_id" value="<?= $id ?>">
                    <input type="text" name="new_comment" placeholder="Escreva um comentário..." required style="width: 80%;">
                    <button type="submit">Comentar</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
	