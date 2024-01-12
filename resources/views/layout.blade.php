<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <script type="text/javascript">
        document.addEventListener('hidden.bs.collapse', event => {
            if (event.target.id === 'sidebar') {
                document.getElementById('sidebar-placeholder').classList.remove('d-none');
            }
        });
        document.addEventListener('show.bs.collapse', event => {
            if (event.target.id === 'sidebar') {
                document.getElementById('sidebar-placeholder').classList.add('d-none');
            }
        });
    </script>
</head>
<body>
<div class="d-flex flex-row h-100 align-items-stretch">
    <div id="sidebar" class="collapse multi-collapse flex-shrink-0 p-2 bg-white show">
        <div
            class="d-flex align-items-center justify-content-between pb-3 mb-3 link-dark text-decoration-none border-bottom">
            <span class="fs-5 fw-semibold">Application</span>
            <i class="right fs-3 bi bi-justify-right"
               data-bs-toggle="collapse" data-bs-target="#sidebar" aria-expanded="false"></i>
        </div>
        <ul class="w-100 list-unstyled ps-0">
            <li class="mb-1">
                <a class="nav-parent w-100 d-flex align-items-center justify-content-between rounded collapsed"
                   data-bs-toggle="collapse" data-bs-target="#pages-collapse" aria-expanded="false">
                    Pages
                    <i class="fs-6 bi bi-caret-right-fill"></i>
                </a>
                <div class="collapse" id="pages-collapse">
                    <ul class="mt-2 ms-4 list-unstyled fw-normal pb-1 small">
                        <li><a href="{{ route('book.index') }}" class="link-dark rounded">Books</a></li>
                        <li><a href="{{ route('library.index') }}" class="link-dark rounded">Libraries</a></li>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <a class="nav-parent w-100 d-flex align-items-center justify-content-between rounded collapsed"
                   data-bs-toggle="collapse" data-bs-target="#actions-collapse" aria-expanded="false">
                    Actions
                    <i class="fs-6 bi bi-caret-right-fill"></i>
                </a>
                <div class="collapse" id="actions-collapse">
                    <ul class="mt-2 ms-4 list-unstyled fw-normal pb-1 small">
                        <li><a href="{{ route('book.create') }}" class="link-dark rounded">Create a Book</a></li>
                        <li><a href="{{ route('library.create') }}" class="link-dark rounded">Create a Library</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div id="sidebar-placeholder" class="flex-shrink-0 p-2 bg-white d-none">
        <i class="right fs-3 bi bi-justify-right"
           data-bs-toggle="collapse" data-bs-target="#sidebar" aria-expanded="false"></i>
    </div>
    <div class="w-100 m-4">
        @yield('content')
    </div>
</div>
</body>
</html>
