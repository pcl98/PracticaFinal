import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { FormsModule } from '@angular/forms';
import { EstudianteService } from '../../services/estudiante.service';

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

  constructor(
    private authService: AuthService, 
    private estudianteService: EstudianteService, 
    private router: Router) {}

  onSubmit(): void {
    const contraseña = this.password;  // Renombramos "password" a "contraseña" para el backend

    this.authService.login(this.email, contraseña).subscribe({
      next: (response) => {
        console.log('Inicio de sesión exitoso:', response);
        this.authService.setToken(response.access_token);
        this.authService.setUser(response.user);

        // Guardamos info de usuario y estudiante/profesor
        const usuario = this.authService.getUser();
        if (usuario.tipo_usuario == "Estudiante") {
          this.estudianteService.getEstudianteById(usuario.id).subscribe(
            (data) => {
              const estudiante = data;
              console.log(estudiante.dni);
              sessionStorage.setItem('estudiante', JSON.stringify(estudiante));
            }
          );
        }
        else {
            // TODO
        }
        
        this.router.navigate(['/inicio']);
      },
      error: (err) => {
        console.error('Error al iniciar sesión:', err);
        this.errorMessage = 'Credenciales incorrectas';
      },
    })
  }
}
