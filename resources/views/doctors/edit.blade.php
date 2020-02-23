@extends('layouts.panel')

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
          <form action="{{ route('doctors.update',$doctor->id) }}" method="POST">
            @csrf 
            @method('PUT')
            <div class="form-group">
                  <label for="">Nombre del Médico</label>
                  <input type="text" name="name" class="form-control" placeholder="Ingresa el Nombre" value="{{old('name', $doctor->name)}}" required >
            </div>
            <div class="form-group">
               <label for="">E-mail</label>
                <input type="email" name="email" class="form-control" placeholder="Ingresa tu Email" value="{{old('email' ,  $doctor->email )}}" required >
           </div>
            <div class="form-group">
               <label for="">Documento de Identidad</label>
                <input type="text" name="dni" class="form-control" placeholder="Ingresa tu DNI"  value="{{old('dni',  $doctor->dni)}}" >
             </div>
             <div class="form-group">
              <label for="">Direccion</label>
                <input type="text" name="address" class="form-control" placeholder="Ingresa tu Dirección" value="{{old('address' ,  $doctor->address)}}" required >
             </div>
             <div class="form-group">
              <label for="">Teléfono</label>
                <input type="number" name="phone" class="form-control" placeholder="Ingresa tu Telefono" value="{{old('phone',  $doctor->phone)}}"  >
             </div>
             <div class="form-group">
                <label for="">Contraseña</label>
              <input type="text" name="password" class="form-control" placeholder="Ingresa tu Telefono"  >
              <p>Ingrese un valor solo si desea actualizar su contraseña</p>
             </div>
             <button type="text" class="btn btn-primary">Guardar</button>
        </form>
      </div>
</div>
@endsection
