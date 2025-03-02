import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { UsuarioService } from '../../services/usuario.service';
import { EstudianteService } from '../../services/estudiante.service';
import { ProfesorService } from '../../services/profesor.service';
import { Pago } from '../../interfaces/user.interface';
import { CommonModule } from '@angular/common';

// Especificamos la respues http
export interface User {
  id?: number,
  nombre?: string;
  apellidos?: string;
  email?: string;
  password?: string;
}

export interface UserResponse {
  user: User;
}

@Component({
  selector: 'app-perfil',
  templateUrl: './perfil.component.html',
  styleUrls: ['./perfil.component.css'],
  imports: [FormsModule, CommonModule]
})
export class PerfilComponent implements OnInit {
  user: any = {};  // Datos del usuario
  errorMessage: string = '';
  successMessage: string = '';
  isEditing: boolean = false; // Para controlar el modo de edición
  estudiante: any = {};
  profesor: any = {};
  isProfesor: boolean = false;
  pagos: Pago[] = []; // Lista de pagos del estudiante

  constructor(
    private authService: AuthService,
    private usuarioService: UsuarioService,
    private estudianteService: EstudianteService,
    private profesorService: ProfesorService,
    private http: HttpClient,
    private router: Router
  ) {}

  ngOnInit(): void {
    // Obtener datos del usuario desde el AuthService
    const storedUser = this.authService.getUser();
    if (storedUser) {
      this.user = storedUser;
      if (this.user.tipo_usuario == 'Estudiante') {
        this.estudiante = this.estudianteService.getEstudianteById(this.user.id);
        this.estudianteService.getPagosByEstudianteId(this.user.id).subscribe({
          next: (response) => {
            this.pagos = response.data; // Guardar los pagos en la propiedad
          },
          error: (err) => {
            console.error('Error al obtener los pagos', err);
            this.errorMessage = 'Hubo un error al obtener los pagos';
          },
        });
      }
      else {
        this.profesor = this.profesorService.getProfesorById(this.user.id);
        this.isProfesor = true;
      }
    }
  }

  toggleEdit(): void {
    this.isEditing = !this.isEditing; // Cambiar entre modo edición y visualización
  }

  onSubmit(): void {
    const userData = {
      nombre: this.user.nombre,
      apellidos: this.user.apellidos,
      email: this.user.email,
      password: this.user.password,
    };
  
    // Actualizar el usuario
    this.usuarioService.updateUsuario(this.user.id, this.user).subscribe({
      next: (response) => {
        // Si la actualización es exitosa, actualizamos los datos
        this.authService.setUser(response.usuario); // Guardamos los datos actualizados
        this.successMessage = 'Datos actualizados con éxito';
        this.errorMessage = '';
        this.isEditing = false; // Salir del modo edición
      },
      error: (err) => {
        console.error('Error al actualizar los datos', err);
        this.errorMessage = 'Hubo un error al actualizar los datos';
        this.successMessage = '';
      },
    });
  }
}