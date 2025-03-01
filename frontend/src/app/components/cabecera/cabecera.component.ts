import { Component, EventEmitter, Output, ViewChild } from '@angular/core';
import { NotificacionesComponent } from '../notificaciones/notificaciones.component';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-cabecera',
  templateUrl: './cabecera.component.html',
  styleUrls: ['./cabecera.component.css'],
  imports: [NotificacionesComponent, CommonModule]
})

export class CabeceraComponent {
  mostrarNotificaciones:boolean = false;
  menuOpen = false;
  usuario: any = null;

  @ViewChild('notificacionesComponent') notificacionesComponent: NotificacionesComponent | undefined;

  constructor(public authService: AuthService, private router: Router) {}

  // Este método emite el evento para abrir la ventana de notificaciones
  abrirNotificaciones():void {
    if (this.notificacionesComponent) {
      this.notificacionesComponent.abrirNotificaciones();
    }
  }

  toggleMenu(): void {
    this.menuOpen = !this.menuOpen;
  }

  // Redirigir a la página del login
  redirigirLogin():void {
    this.menuOpen = !this.menuOpen;
    this.router.navigate(['/login']);
  }

  // Redirigir a la página del perfil
  redirigirPerfil():void {
    this.menuOpen = !this.menuOpen;
    this.router.navigate(['/perfil']);
  }

  ngOnInit(): void {
    // Obtener la información del usuario al inicializar el componente
  }

  logout(): void {
    this.authService.logout();
    this.menuOpen = false;
    this.router.navigate(['/']);
  }
}
