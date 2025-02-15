import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
  imports: [FormsModule]
})
export class LoginComponent {
  email: string = '';
  password: string = '';
  errorMessage: string = '';
  contraseña = '';

  constructor(private authService: AuthService, private router: Router) {}

  onSubmit(): void {
    this.contraseña = this.password;  // Renombramos "password" a "contraseña" para el backend

    this.authService.login(this.email, this.contraseña).subscribe({
      next: (response) => {
        console.log('Inicio de sesión exitoso:', response);
        this.authService.setToken(response.access_token);
        this.authService.setUser(response.user); // Guardamos el nombre de usuario aquí
        this.router.navigate(['/inicio']);
      },
      error: (err) => {
        console.error('Error al iniciar sesión:', err);
        this.errorMessage = 'Credenciales incorrectas';
      },
    })
  }
}
