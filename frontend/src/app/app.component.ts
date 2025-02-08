import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { NavegacionComponent } from './components/navegacion/navegacion.component';
import { CabeceraComponent } from "./components/cabecera/cabecera.component";
import { NotificacionesComponent } from "./components/notificaciones/notificaciones.component";
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, NavegacionComponent, CabeceraComponent, NotificacionesComponent, CommonModule],
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
