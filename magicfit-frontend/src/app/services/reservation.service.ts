import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ReservationService {
  private apiUrl = 'http://localhost:8000/api/reservations'; // change selon ton backend

  constructor(private http: HttpClient) {}

  reserver(data: any): Observable<any> {
    const token = localStorage.getItem('token'); // récupère le token stocké après login

    if (!token) {
      throw new Error('Token non trouvé. Utilisateur non connecté.');
    }

    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });

    return this.http.post(this.apiUrl, data, { headers });
  }
}
