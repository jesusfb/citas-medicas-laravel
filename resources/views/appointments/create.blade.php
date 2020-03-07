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
          <form action="{{ route('appointments.store') }}" method="POST">
            @csrf 
            <div class="form-group">
              <label for="description">DescripciÓn</label>
                <input name="description" id="description" type="text" class="form-control" placeholder="Describe brevemente tu consulta" value="{{old('description')}}" required >
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="specialty">Especialidad</label> {{-- el atributo for debe ser el mismo que el id--}}
                  <select name="specialty_id" id="specialty" class="form-control" required>
                    <option selected="true" disabled="disabled">Seleccionar Especialidad</option>
                      @foreach ($specialties as $specialty)
                      <option value="{{$specialty->id}}" 
                        @if(old('specialty_id') == $specialty->id) selected @endif >{{$specialty->name}}
                      </option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group col-md-6">
                  <label for="doctor">Médico</label>
                  <select name="doctor_id" id="doctor" class="form-control" required>
                    {{-- ESTE SELECT PEUDE ESTAR VACIO SOLO SE VA ACTIVAR SI EXISTE EL CAMPO OLD--}}
                    @foreach ($doctors as $doctor) 
                    <option value="{{$doctor->id}}" 
                       @if(old('doctor_id') == $doctor->id) selected @endif >{{$doctor->name}}
                    </option>
                    @endforeach  
                  </select>
              </div>
            </div>
            <div class="form-group">
               <label for="date">Fecha</label>
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                  <input class="form-control datepicker" placeholder="Seleccionar Fecha" 
                    id="date" type="text" name="scheduled_date" value="{{old('scheduled_date',date('Y-m-d')) }}" 
                    data-date-format="yyyy-mm-dd"
                    data-date-start-date="{{date('Y-m-d')}}" 
                    data-date-end-date="+30d" required>
                  </div>
                </div>
             </div>
             <div class="form-group">
              <label>Hora de Atención</label>
                <div id="hours">
                    {{-- aqui se van a llnear los intervalos, o se va lanzar el mensaje de alerta---}}
                    <div class= "alert alert-info" role="alert">
                        Selecciona un médico y una fecha, para ver sus horarios disponibles.
                    </div>
                </div>
             </div>
             <div class="form-group">
              <label  for="type">Tipo de Consulta</label>
                <div class="custom-control custom-radio mb-3"> 
                    <input name="type" class="custom-control-input" id="type1" checked type="radio" required
                    @if(old('type','Consulta') == 'Consulta') checked @endif value="Consulta" >
                    <label class="custom-control-label" for="type1">Consulta</label>
                 </div>
                 <div class="custom-control custom-radio mb-3"> 
                    <input name="type" class="custom-control-input" id="type2"  type="radio" required
                    @if(old('type') == 'Examen')  checked @endif value="Examen">
                    <label class="custom-control-label" for="type2">Examen</label>
                 </div>
                <div class="custom-control custom-radio mb-3"> 
                    <input name="type" class="custom-control-input" id="type3"  type="radio" required 
                    @if(old('type') == 'Operación')  checked @endif value="Operación">
                    <label class="custom-control-label" for="type3">Operación</label>
                </div>
             </div> 
             <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>

</div>
@endsection
@section('scripts')
<script src="{{asset('js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('js/scripts/appointment/select_doctor.js')}}"></script>
@endsection