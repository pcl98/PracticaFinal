import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { UsuarioService } from '../../services/usuario.service'; // Importar el servicio
import { User, Estudiante, Profesor } from '../../interfaces/user.interface'; // Importar las interfaces
import { EstudianteService } from '../../services/estudiante.service';
import { ProfesorService } from '../../services/profesor.service';

@Component({
  selector: 'app-registro',
  templateUrl: './registro.component.html',
  styleUrls: ['./registro.component.css'],
  imports: [FormsModule]
})
export class RegistroComponent {
  user: User = {} as User; // Inicializa con un objeto vacío del tipo User
  errorMessage: string = '';
  successMessage: string = '';
  isProfesor: boolean = false; // Para controlar si el usuario es profesor
  dni: string = '';
  especialidad: string = '';

  constructor(
    private usuarioService: UsuarioService,
    private estudianteService: EstudianteService,
    private profesorService: ProfesorService,
    private router: Router
  ) {}

  onSubmit(): void {
    // Validar que todos los campos estén completos
    if (!this.user.nombre || !this.user.apellido || !this.user.email || !this.user.password || !this.dni) {
      this.errorMessage = 'Faltan campos por completar';
      return;
    }

    // Asignar el valor 1 al campo "nivel"
    this.user.nivel = 1;
    if (this.isProfesor) {
      this.user.tipo_usuario = 'Profesor';
    }
    else {
      this.user.tipo_usuario = 'Estudiante';
    }

    // Crear el usuario
    this.usuarioService.createUsuario(this.user).subscribe({
      next: (response) => {
        console.log(response);
        if (!response || !response.usuario || !response.usuario.id) {
          this.errorMessage = 'Error en la respuesta del servidor';
          return;
        }
        
        // Si el registro es exitoso, crear el estudiante o profesor
        const usuarioId = response.usuario.id; // Obtener el ID del usuario creado
        console.log(this.user.id);

        if (!this.isProfesor) {
          const estudiante: Estudiante = {
            id: usuarioId,
            dni: this.dni,
            historial_clases: '',
            lecciones_completadas: 0,
          };

          this.estudianteService.createEstudiante(estudiante).subscribe({
            next: () => {
              this.successMessage = 'Estudiante registrado con éxito. Redirigiendo...';
              this.redirectToLogin();
            },
            error: (err) => {
              console.error('Error al crear el estudiante', err);
              this.errorMessage = 'Hubo un error al crear el estudiante';
            },
          });
        } else if (this.isProfesor) {
          const profesor: Profesor = {
            id: usuarioId,
            dni: this.dni,
            descripcion: '',
            especialidad: this.especialidad || '', // Especialidad es opcional
            media_calificacion: 0,
          };

          this.profesorService.createProfesor(profesor).subscribe({
            next: () => {
              this.successMessage = 'Profesor registrado con éxito. Redirigiendo...';
              this.redirectToLogin();
            },
            error: (err) => {
              console.error('Error al crear el profesor', err);
              this.errorMessage = 'Hubo un error al crear el profesor';
            },
          });
        }
      },
      error: (err) => {
        console.error('Error al registrar el usuario', err);
        this.errorMessage = 'Hubo un error al registrar el usuario';
      },
    });
  }

  redirectToLogin(): void {
    setTimeout(() => {
      this.router.navigate(['/login']); // Redirigir al inicio de sesión
    }, 2000); // Redirigir después de 2 segundos
  }
}