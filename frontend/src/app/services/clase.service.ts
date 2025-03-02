import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root', // Esto lo hace disponible globalmente
})
export class ClaseService {

  private apiUrl = 'http://127.0.0.1:8000/api';

  constructor(private http: HttpClient) { }

  // Método para obtener todas las clases
  public getClases(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/clases`);
  }

  // Método para obtener solo las clases online
  public getClasesOnline(id:number): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/clases-online/${id}`); 
  }

    // Método para obtener solo las clases online
    public getClasesPresencial(id:number): Observable<any[]> {
      return this.http.get<any[]>(`${this.apiUrl}/clases-presenciales/${id}`); 
    }
    // Método para eliminar una clase
    public eliminarClase(id:number): Observable<any[]> {
      return this.http.delete<any[]>(`${this.apiUrl}/clases/${id}`); 
    }
    // Método para crear una clase
    crearClase(clase: any): Observable<any> {
      return this.http.post(`${this.apiUrl}/clases`, clase);
    }
}


