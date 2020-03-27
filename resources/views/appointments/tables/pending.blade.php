<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col">Descripción</th>
          <th scope="col">Especialidad</th>
          @if($role=='doctor')
          <th scope="col">Paciente</th>
          @elseif($role=='patient')
          <th scope="col">Medico</th>
          @endif
         
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Tipo</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ( $pendingAppointments as $appointment )
        <tr>
          <th scope="row">
             {{ $appointment->description}}  
          </th>
          <td>
              {{ $appointment->specialty->name}}  
          </td>
          @if($role=='doctor')
          <td>
            {{ $appointment->patient->name}}  
          </td>
          @elseif($role=='patient')
          <td>
            {{ $appointment->doctor->name}}  
          </td>
          @endif
          <td>
              {{ $appointment->scheduled_date}}  
          </td>
          <td>
              {{ $appointment->scheduled_time_12}}  
          </td>
          <td>
              {{ $appointment->type}}  
          </td>
          <td>
              
            @if($role=='admin')
            <a class="btn btn-sm btn-primary" href="{{route('appointments.show',$appointment->id)}}" title="Ver detalle">Ver</a>
            @endif
            
            @if($role=='doctor' || $role=='admin')
            <form action="{{route('appointments.confirm',$appointment->id)}}" method="POST" class="d-inline-block">
              @csrf
              <button data-toggle="tooltip" title= "Aprobar Cita Médica" type="submit" class="btn btn-success btn-sm">
                <i class="ni ni-check-bold"></i></button>
            @endif   
            <form action="{{route('appointments.cancel',$appointment->id)}}" method="post"    class="d-inline-block">
                @csrf
                <button data-toggle="tooltip" title= "Cancelar Cita Médica" type="submit" class="btn btn-danger btn-sm">
                  <i class="ni ni-fat-remove"></i>
                </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card-body">
    {{$pendingAppointments->links()}}
  </div>