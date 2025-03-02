import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ProfesorService {
  private apiUrl = 'http://localhost:8000/api';

  constructor(private http: HttpClient) {}

  /**
   * Obtener todos los profesores (paginados)
   */
  getProfesores(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/profesores`);
  }

  /**
   * Obtener un profesor por su ID
   */
  getProfesorById(id: number): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/profesores/${id}`);
  }

  /**
   * Obtener clases de un profesor
   */
  getClasesByProfesorId(id: number): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/profesores/${id}/clases`);
  }

  /**
   * Obtener exámenes de un profesor
   */
  getExamenesByProfesorId(id: number): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/profesores/${id}/examenes`);
  }
}
