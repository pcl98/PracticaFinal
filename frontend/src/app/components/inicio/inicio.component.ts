import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-inicio',
  imports: [],
  templateUrl: './inicio.component.html',
  styleUrl: './inicio.component.css'
})
export class InicioComponent {
  nombreUsuario: string = 'usuario';

  constructor(private authService: AuthService) {}

  ngOnInit(): void {
    if (this.isUserAuthenticated) {
      const user = this.authService.getUser();
      this.nombreUsuario = user.nombre;
    }
  }

  // Comprobar si el usuario está autenticado
  get isUserAuthenticated(): boolean {
    return this.authService.isLoggedIn();
  }
}
