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
                <a href="/aprovacao"><i class="fa fa-check"></i> <span>Aprovação de Planos
                <!-- 
                $qtd gerado em \App\Providers\AppServiceProvider\view() e \App\Plano\esperando_analise() 
                Para mais informações: https://laravel.com/docs/5.4/views#view-composers
                -->
                @if($qtdPlanAnalise > 0) 
                <small class="label pull-right bg-yellow">{{$qtdPlanAnalise}}</small></span>
                @endif 
                </a>
              </li>
            
            @endif 

            @if( Auth::check() && Auth::user()->hasRole(['Professor']))
                <li class="header">PROFESSORES</li>

                <li>
                  <a href="/planos/create"><i class="fa fa-plus-circle"></i> <span>Novo Plano</span></a>
                </li>

                <li>
                  <a href="/planos/"><i class="fa fa-file-text-o"></i> <span>Meus Planos</span>
                  <!-- 
                  $qtd gerado em \App\Providers\AppServiceProvider\view() e \App\Plano\planos_pendencia() 
                  Para mais informações: https://laravel.com/docs/5.4/views#view-composers
                  -->
                  @if($qtdPlanPend > 0) 
                  <small class="label pull-right bg-red">{{$qtdPlanPend}}</small></span>
                  @endif 
                  </a>
                </li>
              
                <li>
                  <a href="/index_geral"><i class="fa fa-folder-open"></i> <span>Planos em Geral</span></a>
                </li>
            @endif
            
        </ul><!-- /.sidebar-menu -->
    </section><!-- /.sidebar -->
</aside>