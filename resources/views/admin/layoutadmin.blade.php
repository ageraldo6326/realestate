@php
    $darkModeEnabled = (bool) config('ui.dark_mode_enabled');
    $uiTheme = $darkModeEnabled && optional(Auth::user())->ui_theme === 'dark' ? 'dark' : 'light';
@endphp
<!DOCTYPE html>
<html lang="es" data-theme="{{ $uiTheme }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Alis CRM</title>

    <!-- jQuery (carga única) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Google Font: Inter -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- AdminLTE Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @php
        $faviconPath = $inmo->favicon ?? null;
        $faviconUrl = $faviconPath
            ? (\Illuminate\Support\Str::startsWith($faviconPath, ['http://', 'https://', '//', 'data:'])
                ? $faviconPath
                : url('/assets/' . ltrim($faviconPath, '/')))
            : asset('vendor/adminlte/dist/img/AdminLTELogo.png');
    @endphp
    <link rel="shortcut icon" href="{{ $faviconUrl }}" type="image/x-icon">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"
        integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- CKEditor 5 (Secure & Modern) -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <link rel="stylesheet" href="/css/start.css">
    <link rel="stylesheet" href="/css/admin-custom.css">
    <link rel="stylesheet" href="{{ asset('css/admin-dark-theme.css') }}">

    @livewireStyles

</head>

<body class="hold-transition sidebar-mini layout-fixed {{ config('ui.modern_sidebar') ? 'modern-sidebar-enabled' : '' }}">
    @php
        $userPhotoPath = Auth::user()->foto ?? null;
        $userPhotoUrl = asset('vendor/adminlte/dist/img/AdminLTELogo.png');

        if ($userPhotoPath) {
            if (\Illuminate\Support\Str::startsWith($userPhotoPath, ['http://', 'https://', '//', 'data:'])) {
                $userPhotoUrl = $userPhotoPath;
            } elseif (\Illuminate\Support\Str::startsWith($userPhotoPath, '/')) {
                $userPhotoUrl = asset(ltrim($userPhotoPath, '/'));
            } else {
                $userPhotoUrl = asset('assets/' . ltrim($userPhotoPath, '/'));
            }
        }
    @endphp
    <div class="wrapper">

        <!-- Navbar Principal -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom shadow-sm">
            <!-- Left: Toggle + Breadcrumb -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link px-3" @if (config('ui.modern_sidebar')) data-modern-sidebar-toggle aria-expanded="false" aria-controls="modern-sidebar" aria-label="Abrir menú lateral" @else data-widget="pushmenu" @endif href="#" role="button" title="Colapsar menú">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-md-flex align-items-center">
                    <ol class="breadcrumb mb-0 bg-transparent p-0 pl-2">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-muted"><i class="fas fa-home"></i></a>
                        </li>
                        @yield('breadcrumb')
                    </ol>
                </li>
            </ul>

            <!-- Right: acciones rápidas + perfil -->
            <ul class="navbar-nav ml-auto align-items-center">
                @if ($darkModeEnabled)
                    <li class="nav-item d-flex align-items-center">
                        @livewire('theme-toggle')
                    </li>
                @endif
                <!-- Acceso rápido a propiedades -->
                <li class="nav-item d-none d-md-block">
                    <a href="{{ route('propiedades.index') }}" class="nav-link text-muted" title="Mis propiedades">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <!-- Acceso rápido a contactos -->
                <li class="nav-item d-none d-md-block">
                    <a href="{{ route('clientes.index') }}" class="nav-link text-muted" title="Contactos">
                        <i class="fas fa-users"></i>
                    </a>
                </li>
                <!-- Website público -->
                <li class="nav-item d-none d-md-block">
                    <a href="{{ url('/') }}" target="_blank" class="nav-link text-muted" title="Ver website">
                        <i class="fas fa-globe"></i>
                    </a>
                </li>
                <!-- Divider -->
                <li class="nav-item d-none d-md-block">
                    <span class="navbar-text text-muted px-1">|</span>
                </li>
                <!-- Dropdown perfil -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center pr-3" href="#"
                        id="navbarUserDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <img src="{{ $userPhotoUrl }}" alt="{{ Auth::user()->name }}" class="img-circle mr-2"
                            style="width:32px;height:32px;object-fit:cover;">
                        <span class="d-none d-md-inline font-weight-500 text-sm">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down ml-1 text-xs text-muted"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 mt-1"
                        aria-labelledby="navbarUserDropdown" style="min-width:200px">
                        <div class="px-3 py-2 border-bottom">
                            <div class="font-weight-600 text-sm">{{ Auth::user()->name }}</div>
                            <div class="text-muted text-xs">{{ Auth::user()->email }}</div>
                        </div>
                        <a href="{{ route('usuarios.index') }}" class="dropdown-item py-2">
                            <i class="fas fa-users-cog fa-fw mr-2 text-muted"></i> Gestionar usuarios
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item py-2 text-danger">
                            <i class="fas fa-sign-out-alt fa-fw mr-2"></i> Cerrar sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @if (config('ui.modern_sidebar'))
            @include('components.navigation.modern-sidebar')
        @else
            @include('admin.menu')
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header px-3 pt-3 pb-0">
                <div class="container-fluid px-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="h4 mb-0 font-weight-600">@yield('page_title', '')</h1>
                        @yield('page_actions')
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content py-3">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer py-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted text-sm">
                    <strong>{{ $inmo->empresa ?? 'Alis CRM' }}</strong> &mdash; Sistema de gestión inmobiliaria
                </div>
                <div class="text-muted text-xs d-none d-sm-block">
                    v{{ config('app.version', '1.0') }} &bull; {{ now()->year }}
                </div>
            </div>
        </footer>
    </div>


    <!-- jquery.mask (carga única al final) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.monto').mask('000,000,000,000,000', {
                reverse: true
            });
        });
    </script>

    @livewireScripts

    <!-- Bootstrap 4 (AdminLTE) -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select.select2').each(function() {
                if (!$(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2();
                }
            });
        });
    </script>

    <!-- AdminLTE -->
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.js') }}"></script>

    @if ($darkModeEnabled)
        <script>
            window.addEventListener('ui-theme-changed', function(event) {
                document.documentElement.dataset.theme = event.detail.theme === 'dark' ? 'dark' : 'light';
            });
        </script>
    @endif

    @if (config('ui.modern_sidebar'))
        <script src="{{ asset('js/modern-sidebar.js') }}"></script>
    @endif

    <!-- SweetAlert listeners (Livewire) -->
    <script>
        window.addEventListener('generarBorrarContactoSweetAlert', event => {
            Swal.fire({
                title: '¿Desea borrar este Contacto?',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Borrar',
                cancelButtonColor: '#6c757d',
                confirmButtonColor: '#dc3545',
                icon: 'warning',
            }).then((result) => {
                if (result.isConfirmed) {
                    livewire.emit('borrarContacto', event.detail.telefono);
                }
            });
        });

        window.AdminCkeditor = (() => {
            const instances = new Map();

            const isEditorStale = (selector, editor) => {
                if (!editor) {
                    return true;
                }

                const currentTextarea = document.querySelector(selector);
                const sourceElement = editor.sourceElement || null;

                // Si el textarea fue reemplazado por Livewire o ya no existe en el DOM,
                // la instancia previa no sirve y debe recrearse.
                if (!currentTextarea || !sourceElement) {
                    return true;
                }

                if (!sourceElement.isConnected) {
                    return true;
                }

                return sourceElement !== currentTextarea;
            };

            const ensure = async (selector, onChange) => {
                if (instances.has(selector)) {
                    const existingEditor = instances.get(selector);

                    if (!isEditorStale(selector, existingEditor)) {
                        return existingEditor;
                    }

                    try {
                        await existingEditor.destroy();
                    } catch (error) {
                        console.warn('No se pudo destruir instancia CKEditor obsoleta:', error);
                    }

                    instances.delete(selector);
                }

                if (typeof ClassicEditor === 'undefined') {
                    return null;
                }

                const textarea = document.querySelector(selector);
                if (!textarea) {
                    return null;
                }

                const editor = await ClassicEditor.create(textarea);

                if (typeof onChange === 'function') {
                    editor.model.document.on('change:data', () => {
                        onChange(editor.getData(), editor);
                    });
                }

                instances.set(selector, editor);

                return editor;
            };

            const setData = async (selector, value = '') => {
                const editor = await ensure(selector);
                if (editor) {
                    editor.setData(value || '');
                }
            };

            const clear = async (selector) => setData(selector, '');

            const get = (selector) => instances.get(selector) ?? null;

            return {
                ensure,
                setData,
                clear,
                get,
            };
        })();
    </script>

    @stack('scripts')

</body>

</html>
