import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, tap } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class EstudianteService {

  private apiUrl = 'http://localhost:8000/api';
  
    constructor(private http: HttpClient) {}
  
    /**
     * Obtener todos los estudiantes (paginados)
     */
    getEstudiantes(): Observable<any[]> {
      return this.http.get<any>(`${this.apiUrl}/estudiantes`);
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
    getPagosByEstudianteId(id: number): Observable<any[]> {
      return this.http.get<any>(`${this.apiUrl}/estudiantes/${id}/pagos`);
    }

    /**
     * Obtener clases de un estudiante
     */
    getClasesByEstudianteId(id: number): Observable<any[]> {
      return this.http.get<any>(`${this.apiUrl}/estudiantes/${id}/clases`);
    }

    /**
     * Obtener notifiaciones de un estudiante
     */
    getNotificacionesByEstudianteDni(dni: string): Observable<any[]> {
      return this.http.post<any>(`${this.apiUrl}/estudiantes/notificaciones`, {"dni": dni});
    }
  }
