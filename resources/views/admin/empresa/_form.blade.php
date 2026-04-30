@php
    $isEdit = ($mode ?? 'create') === 'edit';
    $company = $inmobiliaria ?? null;
@endphp

<div class="container-fluid px-3 empresa-shell">
    <style>
        .empresa-shell-wrap {
            display: grid;
            gap: 1rem;
        }

        .empresa-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .empresa-stat {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 1rem;
            padding: 1rem;
        }

        .company-dropzone {
            width: 100%;
            min-height: 180px;
            padding: 1.25rem;
            border: 2px dashed #94a3b8;
            border-radius: 1rem;
            background: linear-gradient(180deg, #f8fbff 0%, #eef6ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
        }

        .company-dropzone:hover,
        .company-dropzone:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.12);
        }

        .company-dropzone .dz-message {
            font-size: 1rem;
            margin: 1.25rem 0;
            color: #334155;
            font-weight: 600;
            text-align: center;
        }

        .company-dropzone .dz-preview .dz-image {
            width: 140px;
            height: 140px;
            border-radius: 0.85rem;
        }

        .brand-swatch-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .75rem;
        }

        .brand-swatch-card {
            border: 1px solid #dbe4f0;
            border-radius: 1rem;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
        }

        .brand-swatch-preview {
            min-height: 72px;
        }

        .brand-swatch-meta {
            padding: .75rem .85rem;
        }

        .brand-swatch-label {
            display: block;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #64748b;
            margin-bottom: .15rem;
        }

        .brand-swatch-value {
            color: #0f172a;
            font-weight: 700;
        }

        .brand-color-input {
            display: flex;
            align-items: center;
            gap: .75rem;
            border: 1px solid #dbe4f0;
            border-radius: 1rem;
            background: #fff;
            padding: .55rem .75rem;
        }

        .brand-color-input input[type='color'] {
            width: 52px;
            min-width: 52px;
            height: 44px;
            border: none;
            background: transparent;
            padding: 0;
        }

        .brand-color-input input[type='text'] {
            border: none;
            box-shadow: none;
            padding-left: 0;
            font-weight: 600;
        }

        .brand-color-input input[type='text']:focus {
            box-shadow: none;
        }

        .brand-theme-chip {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .35rem .75rem;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: .8rem;
            font-weight: 700;
        }

        .brand-status-list {
            display: grid;
            gap: .75rem;
        }

        .brand-status-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: .85rem .95rem;
            border: 1px solid #dbe4f0;
            border-radius: 1rem;
            background: #fff;
        }

        .brand-theme-radio {
            display: block;
            border: 1px solid #dbe4f0;
            border-radius: 1rem;
            padding: .9rem 1rem;
            background: #fff;
        }

        .brand-theme-radio.active {
            border-color: #2563eb;
            background: #eff6ff;
        }

        .brand-restore-actions {
            display: grid;
            gap: .75rem;
        }

        .brand-muted {
            color: #64748b;
            font-size: .88rem;
        }

        @media (max-width: 575.98px) {
            .company-dropzone {
                min-height: 155px;
                padding: 1rem;
            }

            .brand-swatch-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="empresa-shell-wrap">
        <section class="empresa-hero">
            <div class="row align-items-end">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Configuracion del CRM</span>
                    <h1 class="h3 font-weight-bold mb-2">{{ $isEdit ? 'Editar empresa' : 'Crear empresa' }}</h1>
                    <p class="mb-0 text-white-50">Gestiona informacion institucional, redes y activos visuales con una
                        vista dedicada consistente con el modulo Usuarios.</p>
                </div>
                <div class="col-lg-4">
                    <div class="empresa-stat">
                        <div class="text-uppercase small text-white-50">Modo</div>
                        <div class="h4 mb-1 font-weight-bold">{{ $isEdit ? 'Edicion' : 'Alta' }}</div>
                        <div class="small text-white-50">
                            {{ $isEdit ? 'Registro principal de empresa' : 'Configuracion inicial de empresa' }}</div>
                    </div>
                </div>
            </div>
        </section>

        @if (session('status'))
            <div class="alert alert-success border-0 shadow-sm rounded-lg mb-0">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0" role="alert">
                <strong>Revisa los siguientes campos:</strong>
                <ul class="mb-0 mt-2 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $action }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            @include('admin.empresa.partials.form-fields', [
                'inmobiliaria' => $company,
                'submitLabel' => $isEdit ? 'Guardar cambios' : 'Guardar empresa',
            ])
        </form>
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('submit', (event) => {
                const form = event.target;

                if (!(form instanceof HTMLFormElement) || !form.closest('.empresa-shell')) {
                    return;
                }

                const submitter = event.submitter;

                if (submitter && submitter.dataset.skipLoading === '1') {
                    return;
                }

                if (!submitter) {
                    return;
                }

                submitter.disabled = true;

                if (submitter.tagName === 'INPUT') {
                    submitter.dataset.originalValue = submitter.value;
                    submitter.value = 'Guardando...';
                } else {
                    submitter.dataset.originalHtml = submitter.innerHTML;
                    submitter.innerHTML = submitter.dataset.loadingText || 'Guardando...';
                }
            }, true);
        </script>
    @endpush
@endonce
