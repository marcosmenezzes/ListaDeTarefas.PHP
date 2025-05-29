<?php
    session_start();
    
    // If user is already logged in, redirect to index.php
    if(isset($_SESSION['id'])) {
        header('Location: index.php');
        exit();
    }
?>

<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Lista Tarefas</title>
        <link rel="stylesheet" href="css/estilo.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    </head>
    <body class="auth-container">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-5">
                    <div class="auth-card slide-in">
                        <div class="text-center">
                            <img src="img/logo.png" alt="Logo" class="auth-logo">
                            <h1 class="auth-title">Bem-vindo de volta!</h1>
                            <p class="auth-subtitle">Entre para gerenciar suas tarefas</p>
                        </div>

                        <?php if(isset($_GET['login']) && $_GET['login'] == 'erro') { ?>
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <span>Usuário ou senha inválido(s)</span>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>

                        <form action="autenticar.php" method="post" class="auth-form">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user me-2"></i>Nome de usuário
                                </label>
                                <input name="usuario" type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-lock me-2"></i>Senha
                                </label>
                                <input name="senha" type="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn-auth">
                                <i class="fas fa-sign-in-alt me-2"></i>Entrar
                            </button>
                        </form>

                        <div class="auth-footer">
                            <p>Ainda não tem uma conta? 
                                <a href="registro.php">Registre-se aqui</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap 5 JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
