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
  private userSubject = new BehaviorSubject<any>(this.getUser()); // Usuario actual, cargado desde sessionStorage

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
    sessionStorage.removeItem('access_token'); // Elimina el token de sessionStorage
    sessionStorage.removeItem('user'); // Elimina el usuario de sessionStorage
    this.isAuthenticated$.next(false); // Actualiza el estado de autenticación
    this.router.navigate(['/login']); // Redirige al usuario a la página de login
  }

  /**
   * Comprueba si el usuario está autenticado (hay un token)
   */
  isLoggedIn(): boolean {
    return this.getToken() !== null;
  }

  /**
   * Guarda el token de autenticación
   */
  setToken(token: string): void {
    if (typeof sessionStorage !== 'undefined') {
      sessionStorage.setItem('access_token', token);
      this.isAuthenticated$.next(true);
    }
  }

  /**
   * Obtener el token del sessionStorage
   */
  getToken(): string | null {
    return typeof sessionStorage !== 'undefined' ? sessionStorage.getItem('access_token') : null;
  }
  /**
   * Comprueba si el token está presente
   */
  private hasToken(): boolean {
    return typeof sessionStorage !== 'undefined' && !!sessionStorage.getItem('access_token');
  }

  /**
   * Guarda los datos del usuario en el servicio y en sessionStorage
   */
  setUser(user: any): void {
    if (typeof sessionStorage !== 'undefined') {
      sessionStorage.setItem('user', JSON.stringify(user));
      this.userSubject.next(user);
      console.log('Usuario guardado en sessionStorage:', user); // Verifica que se guarda
    }
  }

  /**
   * Obtiene los datos del usuario
   */
  getUser(): any {
    if (typeof sessionStorage !== 'undefined') {
      const user = sessionStorage.getItem('user');
      return user ? JSON.parse(user) : null;
    }
    return null;
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