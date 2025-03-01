import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { BehaviorSubject, Observable, tap } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private apiUrl = 'http://localhost:8000/api/login'; // URL de la API
  private isAuthenticated$ = new BehaviorSubject<boolean>(this.hasToken()); // Estado de autenticación
  private userSubject = new BehaviorSubject<any>(this.getUser()); // Usuario actual, cargado desde localStorage

  constructor(private http: HttpClient, private router: Router) {}

  /**
   * Llama a la API para iniciar sesión
   */
  login(email: string, contraseña: string): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}`, { email, contraseña }).pipe(
      tap((response) => {
        console.log('Respuesta del backend:', response);  // Verifica qué datos estás recibiendo
        if (response && response.user) {
          this.setUser(response.user);
          this.setToken(response.token);
        }
      })
    );
  }
  

  /**
   * Realiza logout, eliminando el token y el usuario
   */
  logout(): void {
    localStorage.removeItem('access_token');
    localStorage.removeItem('user');
    this.isAuthenticated$.next(false);
    this.router.navigate(['/login']);
  }

  /**
   * Comprueba si el usuario está autenticado (hay un token)
   */
  isLoggedIn(): Observable<boolean> {
    return this.isAuthenticated$.asObservable();
  }

  /**
   * Guarda el token de autenticación
   */
  setToken(token: string): void {
    localStorage.setItem('access_token', token);  // Guardamos el token en localStorage
    this.isAuthenticated$.next(true);  // Actualizamos el estado de autenticación
  }

  /**
   * Comprueba si el token está presente
   */
  private hasToken(): boolean {
    return !!localStorage.getItem('access_token');  // Verifica si hay un token
  }

  /**
   * Guarda los datos del usuario en el servicio y en localStorage
   */
  setUser(user: any): void {
    this.userSubject.next(user);  // Actualiza el valor del usuario en el BehaviorSubject
    localStorage.setItem('user', JSON.stringify(user));  // Guarda el usuario en localStorage
  }

  /**
   * Obtiene los datos del usuario
   */
  getUser(): any {
    return JSON.parse(localStorage.getItem('user') || '{}');  // Recupera el usuario desde localStorage
  }

  /**
   * Verifica si el usuario está autenticado
   */
  getUserObservable(): Observable<any> {
    return this.userSubject.asObservable();  // Proporciona un Observable para que los componentes se suscriban
  }
  esProfesor(): boolean {
    const user = this.getUser();
    return user && user.tipo_usuario === 'Profesor'; 
  }


}