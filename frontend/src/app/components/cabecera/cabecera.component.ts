import { Component, EventEmitter, Output } from '@angular/core';
import { NotificacionesComponent } from '../notificaciones/notificaciones.component';  // Asegúrate de importar el componente de notificaciones

@Component({
  selector: 'app-cabecera',
  templateUrl: './cabecera.component.html',
  styleUrls: ['./cabecera.component.css'],
  imports: [NotificacionesComponent]
})

export class CabeceraComponent {
  mostrarNotificaciones:boolean = false;

  // Este método emite el evento para abrir la ventana de notificaciones
  abrirNotificaciones():void {
    this.mostrarNotificaciones = !this.mostrarNotificaciones;
    console.log(this.mostrarNotificaciones);
  }
}
