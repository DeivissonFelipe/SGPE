<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            
            
            @if( Auth::check() && Auth::user()->hasAnyRole(['Admin']))
              <li class="header">ADMINISTRAÇÂO</li>
              <li>
                <a href="/cursos/"><i class="fa fa-graduation-cap"></i> <span>Cursos</span></a>
              </li>

              <li>
                <a href="/departamentos/"><i class="fa fa-institution"></i> <span>Departamentos</span></a>
              </li>

              <li>
                <a href="/disciplinas/"><i class="fa fa-paste"></i> <span>Disciplinas</span></a>
              </li>

              <li>
                <a href="/feriados/"><i class="fa fa-calendar-times-o"></i> <span>Feriados</span></a>
              </li>
              
              <li>
                <a href="/semestres/"><i class="fa fa-calendar"></i> <span>Semestres</span></a>
              </li>

              <li>
                <a href="/trocas/"><i class="fa fa-exchange"></i> <span>Substituições</span></a>
              </li>

              <li>
                <a href="/turmas/"><i class="fa fa-users"></i> <span>Turmas</span></a>
              </li>

              <li>
                <a href="/planos/"><i class="fa fa-file-text-o"></i> <span>Planos</span></a>
              </li>

              <li>
                <a href="/aprovacao"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <span>Aprovação de Planos</span></a>
              </li>
            
            @endif 

            @if( Auth::check() && Auth::user()->onlyProfessor())
                <li class="header">PROFESSORES</li>

                <li>
                  <a href="/turmas/"><i class="fa fa-users"></i> <span>Turmas</span></a>
                </li>

                <li>
                  <a href="/planos/"><i class="fa fa-file-text-o"></i> <span>Planos</span></a>
                </li>
              
            @endif
            
        </ul><!-- /.sidebar-menu -->
    </section><!-- /.sidebar -->
</aside>