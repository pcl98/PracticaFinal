import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { CabeceraComponent } from '../cabecera/cabecera.component';
import { EstudianteService } from '../../services/estudiante.service';
import { ProfesorService } from '../../services/profesor.service';
import { Route } from '@angular/router';
import { User } from '../../interfaces/user.interface';

@Component({
  selector: 'app-inicio',
  imports: [],
  templateUrl: './inicio.component.html',
  styleUrl: './inicio.component.css'
})
export class InicioComponent {
  user: User = {
    id: 0,
    nombre: '',
    apellido: '',
    email: '',
    nivel: 0,
    tipo_usuario: ''
  };
  proximoEvento: any = null;
  titulo: string = '';

  constructor(
    private authService: AuthService,
    private estudianteService: EstudianteService,
    private profesorService: ProfesorService
  ) {}

  ngOnInit(): void {
    if (this.authService.isLoggedIn()) {
      this.user = this.authService.getUser();
      this.cargarProximoEvento();
    }
  }

  /**
   * Cargar el próximo evento (clase o examen) del estudiante
   */
  cargarProximoEvento(): void {
    if (this.user.tipo_usuario === 'Estudiante') {
      this.estudianteService.getClasesByEstudianteId(this.user.id).subscribe({
        next: (clases) => {
          // Filtrar y encontrar la próxima clase
          this.proximoEvento = this.encontrarProximoEvento(clases);
          this.actualizarMensaje();
        },
        error: (err) => {
          console.error('Error al obtener las clases', err);
        },
      });
    } else if (this.user.tipo_usuario === 'Profesor') {
      this.profesorService.getClasesByProfesorId(this.user.id).subscribe({
        next: (clases) => {
          // Filtrar y encontrar la próxima clase
          this.proximoEvento = this.encontrarProximoEvento(clases);
          this.actualizarMensaje();
        },
        error: (err) => {
          console.error('Error al obtener las clases', err);
        },
      });
    }
  }

  /**
   * Encontrar el próximo evento (clase o examen) más cercano
   */
  encontrarProximoEvento(eventos: any[]): any {
    const ahora = new Date(); // Fecha y hora actual
    const eventosFuturos = eventos.filter((evento) => new Date(evento.fecha) > ahora); // Filtrar eventos futuros

    if (eventosFuturos.length > 0) {
      // Ordenar eventos por fecha y devolver el más cercano
      return eventosFuturos.sort((a, b) => new Date(a.fecha).getTime() - new Date(b.fecha).getTime())[0];
    }

    return null; // No hay eventos futuros
  }

  /**
   * Actualizar el mensaje según el próximo evento
   */
  actualizarMensaje(): void {
    if (this.proximoEvento) {
      if (this.proximoEvento.online) {
        this.titulo = `Clase online de ${this.proximoEvento.online.titulo}`;
      }
      else if (this.proximoEvento.presencial) {
        this.titulo = `Clase presencial en ${this.proximoEvento.presencial.ubicacion}`;
      }
      else {
        console.log(this.proximoEvento);
        this.titulo = this.proximoEvento.examen.titulo;
      }
      
    } 
  }

  /**
   * Formatear la fecha para mostrarla en un formato legible
   */
  formatearFecha(fecha: string): string {
    return new Date(fecha).toLocaleDateString('es-ES', {
      day: 'numeric',
      month: 'long',
      year: 'numeric',
    });
  }

  // Comprobar si el usuario está autenticado
  get isUserAuthenticated(): boolean {
    return this.authService.isLoggedIn();
  }
}
