@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Cancelar cita</h3>
        </div>
        <div class="col text-right">
        <a href="{{route('appointments.create')}}" class="btn btn-sm btn-success" title="Crear una Nueva Cita">
              Reservar nueva cita
          </a>
        </div>
      </div>
    </div>
    <div class="card-body" role="alert">
       @if(session('notification'))
    
        <div class="alert alert-success" role="alert">
          <strong>Success!</strong> {{session('notification')}}
        </div>
       @endif
      <P>Estás a punto de cancelar tu cita reservada para: {{$appointment->scheduled_date}} a horas: {{$appointment->scheduled_time_12}} con el Médico: {{$appointment->doctor->name}} en la especialidad: {{$appointment->specialty->name}} 
      </P>
    <form action="{{route('appointments.cancel',$appointment->id)}}" method="POST">
          @csrf
          <div class="form-group">
            <label for="justification">Por favor cuéntanos el motivo de la cancelación: </label>
            <textarea id= "justification" name="justification" rows="3" class="form-control" required></textarea>
          </div>
          <button type="submit" class="btn btn-danger" >Cancelar está Cita</button>  
        <a href="{{route('appointments.index')}}" class="btn btn-default" > Volver al listado de citas sin cancelar</a>
        </form>
   </div>
</div>
@endsection
