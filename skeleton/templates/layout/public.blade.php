<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Chascarrillos' }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS (for Blog templates compatibility) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body { padding-top: 60px; }
        footer { margin-top: 50px; padding: 20px 0; background: #f8f9fa; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ \Modules\Chascarrillo\Controller\BlogController::url('index') }}">
                <i class="fas fa-laugh-squint me-2"></i> Chascarrillos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Application Menu (Left) -->
                @if(isset($main_menu) && is_array($main_menu))
                    <ul class="navbar-nav me-auto">
                        @foreach($main_menu as $item)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ $item['url'] }}" title="{{ $item['label'] }}">
                                    @if(!empty($item['icon']))
                                        <i class="{{ $item['icon'] }}"></i>
                                        <span class="d-none d-lg-inline ms-1">{{ $item['label'] }}</span>
                                    @else
                                        {{ $item['label'] }}
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- User Menu (Right) -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ \Modules\Chascarrillo\Controller\BlogController::url('index') }}" title="Inicio">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    
                    @if(isset($header_user_menu) && is_array($header_user_menu))
                        @foreach($header_user_menu as $item)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $item['url'] }}" title="{{ $item['label'] }}">
                                @if(!empty($item['icon']))
                                    <i class="{{ $item['icon'] }}"></i>
                                @endif
                                <!-- Show label on mobile or if no icon -->
                                @if(empty($item['icon']))
                                    {{ $item['label'] }}
                                @else
                                    <span class="d-lg-none ms-2">{{ $item['label'] }}</span>
                                @endif
                            </a>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="text-center text-muted">
        <div class="container">
            <small>&copy; {{ date('Y') }} Chascarrillos App. Powered by Alxarafe Framework.</small>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
