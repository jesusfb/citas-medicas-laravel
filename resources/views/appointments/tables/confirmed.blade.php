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
          <!-- Citas confirmadas -->
      <tbody>
          @foreach ($confirmedAppointments as $appointment)
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
              <a data-toggle="Ver detalles de la cita"class="btn btn-sm btn-primary"href="{{route('appointments.show',$appointment->id)}}">Ver</a>
            @endif
              <a  toggle-data="Cancelar esta cita" class="btn btn-sm btn-danger"href="{{route('appointments.show.form.cancel',$appointment->id)}}">Cancelar</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card-body">
    {{$confirmedAppointments->links()}}
  </div>