import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class NotificacionesService {
  private apiUrl = 'http://tu-api.com/api/notificaciones'; // Cambia esto según tu API

  constructor(private http: HttpClient) {}

  // Obtener todas las notificaciones
  getNotificaciones(): Observable<any> {
    return this.http.get<any>(this.apiUrl);
  }

  // Obtener una notificación por ID
  getNotificacionById(id: number): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/${id}`);
  }

  // Buscar notificaciones con filtros
  searchNotificaciones(params: any): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/search`, { params });
  }

  // Crear una nueva notificación
  createNotificacion(data: any): Observable<any> {
    return this.http.post<any>(this.apiUrl, data);
  }

  // Actualizar una notificación
  updateNotificacion(id: number, data: any): Observable<any> {
    return this.http.patch<any>(`${this.apiUrl}/${id}`, data);
  }

  // Eliminar una notificación
  deleteNotificacion(id: number): Observable<any> {
    return this.http.delete<any>(`${this.apiUrl}/${id}`);
  }
}
