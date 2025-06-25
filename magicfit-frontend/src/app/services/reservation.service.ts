import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Reservation } from '../modals/reservation.model';

@Injectable({
  providedIn: 'root'
})
export class ReservationService {
  getAllReservations(): Observable<Reservation[]> {
  const token = localStorage.getItem('token');
  const headers = new HttpHeaders({
    'Authorization': `Bearer ${token}`
  });

  return this.http.get<Reservation[]>('http://localhost:8000/api/reservations', { headers });
}

createReservation(data: Reservation): Observable<any> {
  const token = localStorage.getItem('token');
  const headers = new HttpHeaders({
    'Authorization': `Bearer ${token}`
  });

  return this.http.post('http://localhost:8000/api/reservations', data, { headers });
}

updateReservation(id: number, data: Reservation): Observable<any> {
  const token = localStorage.getItem('token');
  const headers = new HttpHeaders({
    'Authorization': `Bearer ${token}`
  });

  return this.http.put(`http://localhost:8000/api/reservations/${id}`, data, { headers });
}

deleteReservation(id: number): Observable<void> {
  const token = localStorage.getItem('token');
  const headers = new HttpHeaders({
    'Authorization': `Bearer ${token}`
  });

  return this.http.delete<void>(`http://localhost:8000/api/reservations/${id}`, { headers });
}


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
