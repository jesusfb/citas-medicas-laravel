<div class="table-responsive">
    <!-- Projects table -->

    {{-- HISTORIAL TOTAL DE CADA PACIENTE todas las citas atentidadas, canceladas etc...--}}
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col">Especialidad</th>
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Estado</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
          @foreach ( $oldAppointments as $appointment )
        <tr>
          <td>
              {{ $appointment->specialty->name}}  
          </td>
          <td>
              {{ $appointment->scheduled_date}}  
          </td>
          <td>
              {{ $appointment->scheduled_time_12}}  
          </td> 
          <td>
              {{ $appointment->status}}  
          </td> 
          <td>
          <a href="{{route('appointments.show',$appointment->id)}}" class="btn btn-primary btn-sm">Ver</a>
        </td> 
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card-body">
    {{$oldAppointments->links()}}
  </div>