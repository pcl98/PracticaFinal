import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable()
export class ClaseService {
  constructor(private http: HttpClient) { }
  getClases(): Observable<any> {
    return this.http.get('http://127.0.0.1:8000/api/clase');
  }
} 