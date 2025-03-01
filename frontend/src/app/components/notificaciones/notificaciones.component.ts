import { Component, EventEmitter, Input, Output, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { EstudianteService } from '../../services/estudiante.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-notificaciones',
  templateUrl: './notificaciones.component.html',
  styleUrls: ['./notificaciones.component.css'],
  imports: [CommonModule],
})
export class NotificacionesComponent implements OnInit {
  @Input() mostrarNotificaciones: boolean = false;
  @Output() mostrarNotificacionesChange = new EventEmitter<boolean>();

  notificaciones: any[] = [];
  estudiante: any = null;
  usuario: any = null;

  constructor(public authService: AuthService, public estudianteService: EstudianteService) {}

  ngOnInit() {
    this.usuario = this.authService.getUser();
    this.estudiante = this.estudianteService.getStoredEstudiante(); 
  
    if (!this.usuario || !this.usuario.id) {
      console.error('El usuario no está autenticado o la sesión ha expirado.');
      return;
    }
  
    if (!this.estudiante) {
      console.error('No se encontró un estudiante en sessionStorage.');
      return;
    }
  }

  abrirNotificaciones() {
    this.mostrarNotificaciones = !this.mostrarNotificaciones;
    this.mostrarNotificacionesChange.emit(this.mostrarNotificaciones);

    if (this.mostrarNotificaciones) {
      this.cargarNotificaciones();
    }
  }

  cargarNotificaciones() {
    this.estudianteService.getNotificacionesByEstudianteDni(this.estudiante.dni).subscribe(
      (notificaciones) => {
        this.notificaciones = notificaciones;
      },
      (error) => {
        console.error('Error al obtener las notificaciones', error);
      }
    );
  }

  cerrar() {
    this.mostrarNotificaciones = false;
    this.mostrarNotificacionesChange.emit(this.mostrarNotificaciones);
  }
}
