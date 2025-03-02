import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { forkJoin, map, Observable, tap } from 'rxjs';
import { Estudiante, PaginatedResponse, Pago } from '../interfaces/user.interface';

@Injectable({
  providedIn: 'root'
})
export class EstudianteService {

  private apiUrl = 'http://localhost:8000/api';
  
    constructor(private http: HttpClient) {}
  
    /**
     * Obtener todos los estudiantes (paginados)
     */
    getEstudiantes(): Observable<PaginatedResponse<Estudiante>> {
      return this.http.get<PaginatedResponse<Estudiante>>(`${this.apiUrl}/estudiantes`);
    }
  
    /**
     * Crear un nuevo usuario
     */
    createEstudiante(estudiante: any): Observable<any> {
      return this.http.post<any>(`${this.apiUrl}/estudiantes`, estudiante);
    }
  
    /**
     * Obtener un usuario por su ID
     */
    getEstudianteById(id: number): Observable<any> {
      return this.http.get<any>(`${this.apiUrl}/estudiantes/${id}`).pipe(
        tap((estudiante) => {
          sessionStorage.setItem('estudiante', JSON.stringify(estudiante));
        })
      );
    }

    /**
     * Obtener el estudiante guardado en sessionStorage
     */
    getStoredEstudiante(): any {
      if (typeof window !== 'undefined' && window.sessionStorage) {
        const estudiante = sessionStorage.getItem('estudiante');
        return estudiante ? JSON.parse(estudiante) : null;
      }
      return null; // Si no está disponible, devuelve null
    }
    
  
    /**
     * Actualizar un usuario existente
     */
    updateEstudiante(id: number, estudiante: any): Observable<any> {
      return this.http.patch<any>(`${this.apiUrl}/estudiantes/${id}`, estudiante);
    }
  
    /**
     * Eliminar un usuario
     */
    deleteEstudiante(id: number): Observable<any> {
      return this.http.delete<any>(`${this.apiUrl}/estudiantes/${id}`);
    }

    /**
     * Obtener pagos de un estudiante
     */
    getPagosByEstudianteId(id: number): Observable<PaginatedResponse<Pago>> {
      return this.http.get<PaginatedResponse<Pago>>(`${this.apiUrl}/estudiantes/${id}/pagos`);
    }

    // Método para obtener las clases online de un estudiante
    getClasesOnlineByEstudianteId(estudianteId: number): Observable<any[]> {
      const url = `${this.apiUrl}/estudiantes/${estudianteId}/clases-online`;
      return this.http.get<any[]>(url);
    }

    // Método para obtener las clases presenciales de un estudiante
    getClasesPresencialesByEstudianteId(estudianteId: number): Observable<any[]> {
      const url = `${this.apiUrl}/estudiantes/${estudianteId}/clases-presenciales`;
      return this.http.get<any[]>(url);
    }

    /**
     * Obtener clases de un estudiante
     */
    getClasesByEstudianteId(estudianteId: number): Observable<any[]> {
      return forkJoin([
        this.getClasesOnlineByEstudianteId(estudianteId),
        this.getClasesPresencialesByEstudianteId(estudianteId),
      ]).pipe(
        map(([clasesOnline, clasesPresenciales]) => {
          // Combinar los datos sin transformarlos
          return [...clasesOnline, ...clasesPresenciales];
        })
      );
    }

    /**
     * Obtener exámenes
     */
    getexamenesByEstudianteId(id: number): Observable<any[]> {
      return this.http.get<any>(`${this.apiUrl}/estudiantes/${id}/examenes`);
    }

    /**
     * Obtener notifiaciones de un estudiante
     */
    getNotificacionesByEstudianteDni(dni: string): Observable<any[]> {
      return this.http.post<any>(`${this.apiUrl}/estudiantes/notificaciones`, {"dni": dni});
    }
  }
