<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/index.css">
</head>
<body>

<div class="modal fade" id="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100">
                    <div class="alert alert-danger w-100" role="alert">
                    </div>
                </h5>
            </div>
        </div>
    </div>
</div>
<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Главная</a>
                        </li>
                        <?php if(empty($_COOKIE['token'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/user/register">Регистрация</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/user/login">Авторизация</a>
                            </li>
                        <?php endif; ?>

                        <?php if(isset($_COOKIE['token'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/profile">Профиль</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


<script>
    const modalElement = document.querySelector('#modal');

    const modalHandler = () => {
        const modal = new bootstrap.Modal(modalElement)
        const modalAlert = modalElement.querySelector('.modal-title > .alert')
        const statusToClass = {'error': 'alert-danger', 'success': 'alert-success', 'warning': 'alert-warning'}

        return{
            open: (status, message) => {
                Object.values(statusToClass).forEach(statItem => modalAlert.classList.remove(statItem))
                modalAlert.innerText = message
                modalAlert.classList.add(statusToClass[status])
                modal.show()
            }
        }
    }

    const modal = modalHandler()

</script>