import { Component, EventEmitter, Output } from '@angular/core';
import { NotificacionesComponent } from '../notificaciones/notificaciones.component';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-cabecera',
  templateUrl: './cabecera.component.html',
  styleUrls: ['./cabecera.component.css'],
  imports: [NotificacionesComponent]
})

export class CabeceraComponent {
  mostrarNotificaciones:boolean = false;
  menuOpen = false;

  constructor(public authService: AuthService, private router: Router) {

  }

  // Este método emite el evento para abrir la ventana de notificaciones
  abrirNotificaciones():void {
    this.mostrarNotificaciones = !this.mostrarNotificaciones;
    console.log(this.mostrarNotificaciones);
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

  // Comprobar si el usuario está autenticado
  get isUserAuthenticated(): boolean {
    let isAuth = false;
    this.authService.isLoggedIn().subscribe(value => {
      isAuth = value;
    });
    return isAuth;
  }

  logout(): void {
    this.authService.logout();
    this.menuOpen = false;
    this.router.navigate(['/']);
  }
}
