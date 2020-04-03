<!-- Navigation -->

<h6 class="navbar-heading text-muted">
  @if(Auth()->user()->role == 'admin')
    Gestionar Datos
  @else
      Menu
  @endcan
</h6>


<ul class="navbar-nav">
  @include('includes.panel.menu.'. auth()->user()->role)
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
    <a class="nav-link" href="{{route('charts.appointments')}}">
        <i class="ni ni-collection text-yellow"></i> Frecuencia de Citas
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('charts.doctors')}}">
        <i class="ni ni-palette text-pink"></i> Médicos mas Activos
      </a>
    </li>
  </ul>
  <ul class="navbar-nav">
@endif