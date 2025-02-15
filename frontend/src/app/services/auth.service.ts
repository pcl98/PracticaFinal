import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { BehaviorSubject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private apiUrl = 'http://localhost:8000/api/login'; // url de la API
  private isAuthenticated$ = new BehaviorSubject<boolean>(this.hasToken()); // Detecta si el usuario está autenticado
  private userSubject = new BehaviorSubject<any>(null);

  constructor(private http: HttpClient, private router: Router) {}

  /**
   * Llama a la API
   */
  login(email: string, contraseña: string): Observable<any> {
    return this.http.post(`${this.apiUrl}`, { email, contraseña });
  }

  /**
   * Eliminando el token y actualizando el estado de autenticación
   */
  logout(): void {
    localStorage.removeItem('access_token');
    this.isAuthenticated$.next(false);
    this.router.navigate(['/login']);
  }

  /**
   * Comprueba si el usuario está autenticado
   */
  isLoggedIn(): Observable<boolean> {
    return this.isAuthenticated$.asObservable();
  }

  /**
   * Guarda el token en el almacenamiento local
   */
  setToken(token: string): void {
    localStorage.setItem('token', token);
    this.isAuthenticated$.next(true);
  }

  /**
   * Comprueba si hay un token almacenado
   */
  private hasToken(): boolean {
    return !!localStorage.getItem('token');
  }

  // Almacenamos el nombre de usuario
  setUser(user: any) {
    this.userSubject.next(user);
    localStorage.setItem('user', JSON.stringify(user));
  }

  // Obtén el usuario
  getUser() {
    return JSON.parse(localStorage.getItem('user') || '{}');
  }

  

}
