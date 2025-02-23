import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-perfil',
  templateUrl: './perfil.component.html',
  styleUrls: ['./perfil.component.css'],
  imports: [FormsModule]
})
export class PerfilComponent implements OnInit {
  user: any = {};  // Datos del usuario
  errorMessage: string = '';

  constructor(
    private authService: AuthService,
    private http: HttpClient,
    private router: Router
  ) {}

  ngOnInit(): void {
    // Obtener datos del usuario desde el AuthService
    this.user = this.authService.getUser();
  }

  onSubmit(): void {
    /*const userData = {
      nombre: this.user.nombre,
      apellidos: this.user.apellidos,
      email: this.user.email,
      password: this.user.password,  // Si la contraseña es cambiada
    };

    this.http.put('http://localhost:8000/api/usuario', userData).subscribe({
      next: (response) => {
        // Si la actualización es exitosa, actualizamos los datos
        this.authService.setUser(response.user); // Guardamos los datos actualizados
        alert('Datos actualizados con éxito');
        this.router.navigate(['/inicio']); // Redirigimos al inicio o a donde prefieras
      },
      error: (err) => {
        console.error('Error al actualizar los datos', err);
        this.errorMessage = 'Hubo un error al actualizar los datos';
      },
    });*/
  }
}
