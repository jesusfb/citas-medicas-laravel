@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Detale de la Cita # {{$appointment->id}}</h3>
        </div>
      </div>
    </div>
    <div class="card-body" role="alert">
        <ul>
            <li>
                <strong>Fecha: </strong>{{ $appointment->scheduled_date}}
            </li>
            <li>
                 <strong>Hora: </strong>{{ $appointment->scheduled_time_12}}
            </li>
            @if(Auth::user()->role=='doctor' ||  Auth::user()->role=='admin' )
            <li>
                <strong>Paciente: </strong>{{ $appointment->patient->name}}
           </li>
            @endif 
            @if(Auth::user()->role=='patient' || Auth::user()->role=='admin' )
            <li>
                <strong>Médico: </strong>{{ $appointment->doctor->name}}
           </li>
            @endif
            <li>
                 <strong>Especialidad: </strong>{{ $appointment->specialty->name}}
            </li>
            <li>
                <strong>Tipo: </strong>{{ $appointment->type}}
           </li>
            <li>
                 <strong>Estado:</strong>
                 @if($appointment->status == 'Cancelada')
                 <span class="badge badge-warning">  {{ $appointment->status}}</span>
                 @else 
                 <span class="badge badge-success">  {{ $appointment->status}}</span>
                 @endif
            </li>
        </ul>
        @if($appointment->status=='Cancelada')
        <div class="alert alert-warning" role="alert">
            <p> <strong>Acerca de la cancelación<strong></p>
            <ul>
                @if($appointment->cancellation)
                <li>
                    <strong>Motivo de la cancelación: </strong>{{ $appointment->cancellation->justification}}
                </li>
                <li>
                    <strong>Fecha y hora de la cancelación: </strong>{{ $appointment->cancellation->created_at}}
                </li>
                <li>
                    <strong>¿Quién canceló la cita?:</strong>
                    @if(auth()->id()==$appointment->cancellation->cancelled_by_id)
                     Tú
                    @else
                    {{$appointment->cancellation->cancelled_by->name}}
                    @endif
                </li>
                @else
                <li>
                    Esta cita fue cancelada antes de su confirmacón.
                </li>
                @endif
            </ul>
        </div>
        @endif
    <a href="{{route('appointments.index')}}" class="btn btn-default">Volver</a>
   </div>
</div>
@endsection
