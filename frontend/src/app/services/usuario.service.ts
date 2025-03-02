import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { User, UserResponse } from '../interfaces/user.interface';

@Injectable({
  providedIn: 'root'
})
export class UsuarioService {
  private apiUrl = 'http://localhost:8000/api';

  constructor(private http: HttpClient) {}

  /**
   * Obtener todos los usuarios
   */
  getUsuarios(): Observable<User[]> {
    return this.http.get<User[]>(`${this.apiUrl}/usuarios`);
  }

  /**
   * Crear un nuevo usuario
   */
  createUsuario(usuario: User): Observable<UserResponse> {
    const payload = {
      ...usuario,
      contraseña: usuario.password,
    };
    delete payload.password;
    return this.http.post<UserResponse>(`${this.apiUrl}/usuarios`, payload);
  }

  /**
   * Obtener un usuario por su ID
   */
  getUsuarioById(id: number): Observable<UserResponse> {
    return this.http.get<UserResponse>(`${this.apiUrl}/usuarios/${id}`);
  }

  /**
   * Actualizar un usuario existente
   */
  updateUsuario(id: number, usuario: User): Observable<UserResponse> {
    const payload = {
      ...usuario,
      contraseña: usuario.password,
    };
    delete payload.password;
    return this.http.patch<UserResponse>(`${this.apiUrl}/usuarios/${id}`, payload);
  }

  /**
   * Eliminar un usuario
   */
  deleteUsuario(id: number): Observable<any> {
    return this.http.delete<any>(`${this.apiUrl}/usuarios/${id}`);
  }
}