@extends('layouts.panel')
@section('styles')
{{-- ESTOS CDN LOS COPIAMOS DE LA PAGINA OFICINAL DE BOOSTRAP-SELECT --}}
{{-- https://developer.snapappointments.com/bootstrap-select/ --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.12/dist/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
@endsection

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Nueva Médico</h3>
        </div>
        <div class="col text-right">
        <a href="{{ route('doctors.index') }}" class="btn btn-sm btn-default">
              Cancelar y volver
          </a>
        </div>
      </div>
    </div>
      <div class="card-body">
         @if($errors->any())
          <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error )
                    <li>{{$error}}</li>
                @endforeach
            </ul>
          </div>
         @endif  
          <form action="{{ route('doctors.store') }}" method="POST">
            @csrf 
            <div class="form-group">
                  <label for="">Nombre del Médico</label>
                  <input type="text" name="name" class="form-control" placeholder="Ingresa el Nombre" value="{{old('name')}}" required >
            </div>
            <div class="form-group">
                <label for="specialties">Especialidades </label>
                  <select name="specialties[]" class="form-control selectpicker" id="specialties" data-live-search="true" multiple title="Seleccione una o varias" data-style="btn-outline-primary" >
                    @foreach ( $specialties as $specialty )
                      <option value="{{$specialty->id}}" data-tokens="mustard">{{$specialty->name}}</option>
                    @endforeach
                  </select>
            </div>
            <div class="form-group">
               <label for="">E-mail</label>
                <input type="email" name="email" class="form-control" placeholder="Ingresa tu Email" value="{{old('email')}}" required >
           </div>
            <div class="form-group">
               <label for="">Documento de Identidad</label>
                <input type="text" name="dni" class="form-control" placeholder="Ingresa tu DNI"  value="{{old('dni')}}" >
             </div>
             <div class="form-group">
              <label for="">Direccion</label>
                <input type="text" name="address" class="form-control" placeholder="Ingresa tu Dirección" value="{{old('address')}}" required >
             </div>
             <div class="form-group">
              <label for="">Teléfono</label>
                <input type="number" name="phone" class="form-control" placeholder="Ingresa tu Telefono" value="{{old('phone')}}" required >
             </div>
             <div class="form-group">
              <label for="">Contrasñea</label>
             <input type="text" name="password" class="form-control" placeholder="Ingresa tu Telefono" value="{{str_random(6)}}" required >
             </div>
             <button type="text" class="btn btn-primary">Guardar</button>
        </form>
      </div>
</div>
@endsection
@section('scripts')
 {{-- cdn para BOOTSTRAP-SELECT--}}
    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.12/dist/js/bootstrap-select.min.js"></script>
@endsection