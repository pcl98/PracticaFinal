import { Component, LOCALE_ID } from '@angular/core';
import { RouterModule, RouterOutlet } from '@angular/router';
import { NavegacionComponent } from './components/navegacion/navegacion.component';
import { InicioComponent } from './components/inicio/inicio.component';
import { CalendarioComponent } from './components/calendario/calendario.component';
import { PresencialComponent } from './components/presencial/presencial.component';
import { OnlineComponent } from './components/online/online.component';
import { ProfesoresComponent } from './components/profesores/profesores.component';
import { NuestraHistoriaComponent } from './components/nuestra-historia/nuestra-historia.component';
import { ContactoComponent } from './components/contacto/contacto.component';
import { PreguntasFrecuentesComponent } from './components/preguntas-frecuentes/preguntas-frecuentes.component';
import { PieComponent } from './components/pie/pie.component';

import { CabeceraComponent } from "./components/cabecera/cabecera.component";
import { LoginComponent } from './components/login/login.component';
import { PerfilComponent } from './components/perfil/perfil.component';
import { CalendarHeaderComponent } from './components/calendar-header/calendar-header.component';
import { CalendarDateFormatter, CalendarModule, CalendarEventTitleFormatter } from 'angular-calendar';
import { CustomDateFormatter } from './providers/custom-date-formatter.provider';
import localeEs from '@angular/common/locales/es';
import { registerLocaleData } from '@angular/common';

registerLocaleData(localeEs);

@Component({
  selector: 'app-root',
  providers: [
    {
      provide: CalendarDateFormatter,
      useClass: CustomDateFormatter,
    },
    {
      provide: LOCALE_ID,
      useValue: 'es',
    },
    {
      provide: CalendarEventTitleFormatter,
    },
  ],
  imports: [RouterOutlet, NavegacionComponent, InicioComponent, PresencialComponent, OnlineComponent, 
            CalendarioComponent, ProfesoresComponent, NuestraHistoriaComponent, ContactoComponent, 
            PreguntasFrecuentesComponent, CabeceraComponent, LoginComponent, PieComponent, PerfilComponent,
            CalendarHeaderComponent, CalendarModule],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css',
})
export class AppComponent {
  title = 'frontend';
}