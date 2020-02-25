@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Registrar Nueva Cita</h3>
        </div>
        <div class="col text-right">
        <a href="{{ route('patients.index') }}" class="btn btn-sm btn-default">
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
          <form action="{{ route('patients.store') }}" method="POST">
            @csrf 
            <div class="form-group">
                <label for="">Especialidad</label>
                <select name="especialidad" id="especialidad" class="form-control">
                    @foreach ($specialties as $specialty)
                     <option value="{{$specialty->id}}">{{$specialty->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
               <label for="">Médico</label>
               <select name="medico" id="medico" class="form-control">
                              
              </select>
           </div>
            <div class="form-group">
               <label for="">Fecha</label>
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    <input type="text" class="form-control datepicker" placeholder="Select date" >
                  </div>
                </div>
             </div>
             <div class="form-group">
              <label for="">Hora de Atención</label>
                <input type="text" name="address" class="form-control" value="{{old('address')}}" required >
             </div>
             <div class="form-group">
              <label for="">Teléfono</label>
                <input type="number" name="phone" class="form-control" placeholder="Ingresa tu Telefono" value="{{old('phone')}}" required >
             </div>
             <div class="form-group">
              <label for="password">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="Ingresa tu Telefono" required >
             </div>
             
             <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>

</div>
@endsection
@section('scripts')
<script src="{{asset('js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
@endsection
