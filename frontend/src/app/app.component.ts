import { Component } from '@angular/core';
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
import { CabeceraComponent } from "./components/cabecera/cabecera.component";

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, NavegacionComponent, InicioComponent, PresencialComponent, OnlineComponent, CalendarioComponent, ProfesoresComponent, NuestraHistoriaComponent, ContactoComponent, PreguntasFrecuentesComponent, CabeceraComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'frontend';

  mostrarVentanaNotificaciones = false;

  mostrarNotificaciones() {
    this.mostrarVentanaNotificaciones = true;
  }
}
