@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>DISPONIBLE PARA</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route("disponiblepara.update",$disponiblespara->id) }}" method="post">
                @method("put")
                @csrf
                <div class="form-group">

                    <div class="form-group">
                        <label for="tipo">Titulo</label>
                        <input type="text" class="form-control" id="disponible_para" name="disponible_para"
                            placeholder="Disponible para" value="{{ $disponiblespara->disponible_para }}">
                    </div>


                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="submit" id="submit" value="Grabar">
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('css')
{{-- Add here extra stylesheets --}}
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!"); 
</script>
@stop

