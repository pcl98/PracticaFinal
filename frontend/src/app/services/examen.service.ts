import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ExamenService {
  private apiUrl = 'http://localhost:8000/api';

  constructor(private http: HttpClient) {}

  /**
   * Obtener todos los exámenes
   */
  getExamenes(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/examenes`);
  }

  /**
   * Obtener exámenes de un estudiante
   */
  getExamenesByEstudianteId(id: number): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/estudiantes/${id}/examenes`);
  }

  /**
   * Obtener exámenes de un profesor
   */
  getExamenesByProfesorId(id: number): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/profesores/${id}/examenes`);
  }

  /**
   * Crear un examen
   */
  createExamen(examen: any): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/examenes`, examen);
  }

  /**
   * Actualizar un examen
   */
  updateExamen(id: number, examen: any): Observable<any> {
    return this.http.patch<any>(`${this.apiUrl}/examenes/${id}`, examen);
  }

  /**
   * Eliminar un examen
   */
  deleteExamen(id: number): Observable<any> {
    return this.http.delete<any>(`${this.apiUrl}/examenes/${id}`);
  }
}
