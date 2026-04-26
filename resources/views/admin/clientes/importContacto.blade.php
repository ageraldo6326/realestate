@extends('admin.layoutadmin')

@section('title', 'Importar Contactos')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Contactos</a></li>
    <li class="breadcrumb-item active">Importar</li>
@endsection

@section('page_title', 'Importar Contactos')

@section('page_actions')
    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary btn-sm">
        Volver a contactos
    </a>
@endsection

@section('content')
    <style>
        .content-wrapper {
            background: linear-gradient(180deg, #f8fafc 0%, #eef4f7 100%);
        }

        .import-shell {
            display: grid;
            gap: 1rem;
        }

        .import-hero {
            background: linear-gradient(135deg, #12343b 0%, #1c4f59 55%, #b66a20 100%);
            color: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 18px 40px rgba(18, 52, 59, 0.14);
        }

        .import-panel {
            border: 1px solid #dfe7ef;
            border-radius: 1.25rem;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.06);
        }

        .import-dropzone {
            position: relative;
            border: 2px dashed #cbd5e1;
            border-radius: 1rem;
            background: #f8fafc;
            padding: 1.5rem;
            text-align: center;
            transition: all .2s ease;
        }

        .import-dropzone:hover {
            border-color: #1c4f59;
            background: #f3f7f8;
        }

        .import-file-input {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .import-format-table th,
        .import-format-table td {
            vertical-align: middle;
        }

        .import-code {
            display: block;
            background: #0f172a;
            color: #e2e8f0;
            border-radius: .9rem;
            padding: 1rem;
            overflow-x: auto;
            font-size: .9rem;
            white-space: pre;
        }
    </style>

    <div class="container-fluid px-3 import-shell">
        <section class="import-hero p-4 p-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <p class="text-uppercase mb-2" style="letter-spacing:.14em; opacity:.75; font-size:.78rem;">Carga masiva</p>
                    <h2 class="h3 font-weight-bold mb-2">Importa contactos desde CSV o Excel</h2>
                    <p class="mb-0" style="opacity:.88; max-width:48rem;">Sube un archivo con la estructura esperada y el sistema creará contactos nuevos asignándolos al usuario autenticado como captador y responsable inicial.</p>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white text-dark rounded-lg p-3 shadow-sm">
                        <div class="small text-uppercase text-muted mb-1" style="letter-spacing:.08em;">Formatos permitidos</div>
                        <div class="font-weight-bold">CSV, XLS y XLSX</div>
                    </div>
                </div>
            </div>
        </section>

        <div class="row">
            <div class="col-xl-5 mb-4">
                <div class="card import-panel h-100">
                    <div class="card-body p-4">
                        <h3 class="h5 font-weight-bold mb-3">Subir archivo</h3>

                        @error('document_csv')
                            <div class="alert alert-danger border-0 shadow-sm">
                                {{ $message }}
                            </div>
                        @enderror

                        @if (session('success'))
                            <div class="alert alert-success border-0 shadow-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any() && !$errors->has('document_csv'))
                            <div class="alert alert-danger border-0 shadow-sm">
                                Revisa el archivo e intenta nuevamente.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('import.csv') }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            <label for="document_csv" class="import-dropzone d-block mb-3">
                                <input type="file" class="import-file-input" id="document_csv" name="document_csv" accept=".csv,.txt,.xls,.xlsx">
                                <div class="mb-2"><i class="fas fa-file-upload fa-2x text-muted"></i></div>
                                <div class="font-weight-bold mb-1">Haz clic para seleccionar el archivo</div>
                                <div class="text-muted small">Usa archivos con encabezados en la primera fila.</div>
                            </label>

                            <div class="small text-muted mb-3">
                                El importador toma cada fila como un contacto nuevo. Si el archivo tiene columnas con otros nombres, esos datos no se mapearán.
                            </div>

                            <button class="btn btn-primary btn-block" type="submit">
                                Importar contactos
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-7 mb-4">
                <div class="card import-panel h-100">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                            <div>
                                <h3 class="h5 font-weight-bold mb-1">Formato esperado del archivo</h3>
                                <p class="text-muted mb-0">Estos son los encabezados que el importador lee actualmente en el proceso de carga de contactos.</p>
                            </div>
                            <a href="{{ route('import.template') }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-download mr-1"></i> Descargar plantilla CSV
                            </a>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered import-format-table mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Columna</th>
                                        <th>Uso en el sistema</th>
                                        <th>Obligatoria</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>first_name</code></td>
                                        <td>Nombre del contacto</td>
                                        <td>Sí</td>
                                    </tr>
                                    <tr>
                                        <td><code>last_name</code></td>
                                        <td>Apellido del contacto</td>
                                        <td>Sí</td>
                                    </tr>
                                    <tr>
                                        <td><code>campaign_name</code></td>
                                        <td>Se guarda como campaña</td>
                                        <td>Recomendado</td>
                                    </tr>
                                    <tr>
                                        <td><code>correo_electronico</code></td>
                                        <td>Correo del contacto</td>
                                        <td>Recomendado</td>
                                    </tr>
                                    <tr>
                                        <td><code>numero_de_telefono</code></td>
                                        <td>Teléfono del contacto</td>
                                        <td>Sí</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h4 class="h6 font-weight-bold mb-2">Ejemplo de encabezado y una fila</h4>
                        <code class="import-code">first_name,last_name,campaign_name,correo_electronico,numero_de_telefono
Juan,Perez,Meta Ads,juan@email.com,8095551234</code>

                        <div class="alert alert-warning border-0 mt-4 mb-0">
                            <strong>Importante:</strong> la primera fila debe contener exactamente esos encabezados. Durante la importación, cada contacto se crea con tipo <code>Persona Fisica</code>, estado <code>NUEVO</code> y queda captado/asignado al usuario autenticado.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection