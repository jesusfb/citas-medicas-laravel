<!-- Navigation -->

<h6 class="navbar-heading text-muted">
  @if(Auth()->user()->role == 'admin')
    Gestionar Datos
  @else
      Menu
  @endcan
</h6>


<ul class="navbar-nav">
  @if(Auth()->user()->role == 'admin')
    <li class="nav-item  active ">
      <a class="nav-link  active " href="/home">
        <i class="ni ni-tv-2 text-primary"></i> Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="{{route('specialties.index')}}">
        <i class="ni ni-planet text-blue"></i> Especialidades
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link "  href="{{route('doctors.index')}}">
        <i class="ni ni-single-02 text-orange"></i>  Medicos
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="{{route('patients.index')}}">
        <i class="ni ni-satisfied text-info"></i>  Pacientes
      </a>
    </li>
   @elseif(Auth()->user()->role == 'doctor') 
    <li class="nav-item  active ">
    <a class="nav-link  active " href="{{route('schedule.edit')}}">
        <i class="ni ni-calendar-grid-58 text-blue"></i> Gestionar Horario
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="{{route('specialties.index')}}">
        <i class="ni ni-time-alarm text-orange"></i> Mis Citas
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="{{route('specialties.index')}}">
        <i class="ni ni-satisfied text-green"></i> Mis Pacientes
      </a>
    </li>
   @else  {{-- Quiere decir que no soy admin  ni doctor entonces soy un PACIENTE --}}
    <li class="nav-item  active ">
      <a class="nav-link  active " href="/home">
        <i class="ni ni-tablet-button text-blue"></i> Reservar Cita
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="{{route('specialties.index')}}">
        <i class="ni ni-time-alarm text-orange"></i> Mis Citas
      </a>
    </li>

   @endif  
    <li class="nav-item">
           <a class="nav-link" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById  ('formLogout').  submit();">
          <i class="ni ni-key-25"></i> Cerrar Sesión
            </a>
          <form action="{{route('logout')}}" method="POST" style="display:none;" id="formLogout">
              @csrf
          </form>
    </li>
  </ul>
  @if(Auth()->user()->role == 'admin')
  <!-- Divider -->
  <hr class="my-3">
  <!-- Heading -->
  <h6 class="navbar-heading text-muted">Reportes</h6>
  <!-- Navigation -->
  <ul class="navbar-nav mb-md-3">
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="ni ni-collection text-yellow"></i> Frecuencia de Citas
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="ni ni-palette text-pink"></i> Médicos mas Activos
      </a>
    </li>
  </ul>
  <ul class="navbar-nav">
@endif