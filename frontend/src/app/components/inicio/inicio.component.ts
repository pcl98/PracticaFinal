import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-inicio',
  imports: [],
  templateUrl: './inicio.component.html',
  styleUrl: './inicio.component.css'
})
export class InicioComponent {
  nombreUsuario: string = '';

  constructor(private authService: AuthService) {}

  ngOnInit(): void {
    const user = this.authService.getUser();
    this.nombreUsuario = user.nombre || 'Usuario'; // Usamos un valor predeterminado si no está disponible
  }

  // Comprobar si el usuario está autenticado
  get isUserAuthenticated(): boolean {
    let isAuth = false;
    this.authService.isLoggedIn().subscribe(value => {
      isAuth = value;
    });
    return isAuth;
  }
}
