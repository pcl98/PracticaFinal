import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable()
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
}

