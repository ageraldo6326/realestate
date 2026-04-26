@extends('admin.layoutadmin')

@section('content')

    <div class="container-fluid empresa-editor py-4">
        <section class="editor-hero mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h1 class="editor-title mb-1">Crear empresa</h1>
                    <p class="editor-subtitle mb-0">Configura la informacion institucional, canales de contacto e identidad
                        visual del portal.</p>
                </div>
                <a href="{{ route('inmobiliaria.index') }}" class="btn btn-outline-secondary">Actualizar vista</a>
            </div>
        </section>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm border-0" role="alert">
            <strong>Revisa los siguientes campos:</strong>
            <ul class="mb-0 mt-2 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inmobiliaria.store') }}" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        @include('admin.empresa.partials.form-fields')
    </form>


    <style>
        .empresa-editor .editor-hero {
            background: linear-gradient(135deg, #f4f7fb 0%, #ffffff 100%);
            border: 1px solid #e5e9f2;
            border-radius: 16px;
            padding: 1.5rem;
        }

        .empresa-editor .editor-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
        }

        .empresa-editor .editor-subtitle {
            color: #6b7280;
            max-width: 680px;
        }

        .empresa-editor .section-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .empresa-editor .preview-box {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.75rem;
            background-color: #fafafa;
        }

        .empresa-editor .preview-label {
            display: block;
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .company-dropzone {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            background: #f8fafc;
            padding: 0.75rem;
            min-height: 110px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .company-dropzone-placeholder {
            color: #475569;
            font-weight: 600;
            text-align: center;
            font-size: 0.95rem;
        }

        .company-dropzone .dz-message {
            margin: 1rem 0;
            color: #475569;
            font-weight: 600;
            text-align: center;
        }

        .company-dropzone .dz-preview .dz-image {
            border-radius: 10px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 54px;
            height: 30px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #d1d5db;
            transition: .3s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .3s;
        }

        input:checked+.slider {
            background-color: #16a34a;
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }

        .slider.round {
            border-radius: 30px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        @media (max-width: 991.98px) {
            .empresa-editor .editor-title {
                font-size: 1.4rem;
            }
        }
    </style>


@endsection
