<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col">Descripción</th>
          <th scope="col">Especialidad</th>
          <th scope="col">Medico</th>
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Tipo</th>
          <th scope="col">Estado</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($confirmedAppointments as $appointment)
        <tr>
          <th scope="row">
             {{ $appointment->description}}  
          </th>
          <td>
              {{ $appointment->specialty->name}}  
          </td>
          <td>
            {{ $appointment->doctor->name}}  
          </td>
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
            <span class="badge badge-primary" title="Estado actual de la cita">{{ $appointment->status}} </span>
          </td>
          <td>
              <form action="#" method="post">
                  @csrf
                  @method('DELETE')
                  <button title= "Cancelar Cita Medica" type="submit" class="btn btn-danger btn-sm">Cancelar</button>
              </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card-body">
    {{$confirmedAppointments->links()}}
  </div>