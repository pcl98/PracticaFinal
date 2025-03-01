import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UsuarioService {
  private apiUrl = 'http://localhost:8000/api';

  constructor(private http: HttpClient) {}

  /**
   * Obtener todos los usuarios
   */
  getUsuarios(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/usuarios`);
  }

  /**
   * Crear un nuevo usuario
   */
  createUsuario(usuario: any): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/usuarios`, usuario);
  }

  /**
   * Obtener un usuario por su ID
   */
  getUsuarioById(id: number): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/usuarios/${id}`);
  }

  /**
   * Actualizar un usuario existente
   */
  updateUsuario(id: number, usuario: any): Observable<any> {
    return this.http.patch<any>(`${this.apiUrl}/usuarios/${id}`, usuario);
  }

  /**
   * Eliminar un usuario
   */
  deleteUsuario(id: number): Observable<any> {
    return this.http.delete<any>(`${this.apiUrl}/usuarios/${id}`);
  }
}