import { Component, EventEmitter, Input, Output } from '@angular/core';

@Component({
  selector: 'app-notificaciones',
  templateUrl: './notificaciones.component.html',
  styleUrls: ['./notificaciones.component.css']
})
export class NotificacionesComponent {
  @Input() mostrarNotificaciones:boolean = false;
  @Output() mostrarNotificacionesChange = new EventEmitter<boolean>();

  cerrar() {
    this.mostrarNotificaciones = false;
    this.mostrarNotificacionesChange.emit(this.mostrarNotificaciones);
    console.log(this.mostrarNotificaciones);
  }
}
