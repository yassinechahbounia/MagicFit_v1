import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule, FormsModule } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { ApiService } from 'src/app/services/api.service';

@Component({
  selector: 'app-reservation-facile',
  standalone: true,
  templateUrl: './reservation-facile.component.html',
  styleUrls: ['./reservation-facile.component.scss'],
  imports: [CommonModule, FormsModule, ReactiveFormsModule],
})
export class ReservationFacileComponent implements OnInit {
  reservationForm: FormGroup;
  successMessage = '';
  errorMessage = '';
  reservation: any;
  constructor(private fb: FormBuilder, private http: HttpClient,private apiService:ApiService) {
    this.reservationForm = this.fb.group({
      nom: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      type: ['Cours Collectif', Validators.required],
      date: ['', Validators.required],
      heure: ['', Validators.required]
    });
  }
  
  ngOnInit(): void {
  }

  onSubmit(): void {
    if (this.reservationForm.invalid) return;

    const data = this.reservationForm.value;
    const headers={
  'Authorization':`Bearer${localStorage.getItem('token')}`
}
console.log(`check token ${headers}`)
    this.http.post('http://localhost:8000/api/reservations', data,{  headers: this.apiService.getHeaders()}).subscribe({
  
    next: () => {
        this.successMessage = 'Réservation envoyée avec succès ✅';
        this.errorMessage = '';
        this.reservationForm.reset({ type: 'Cours Collectif' });
      },
      error: () => {
        this.successMessage = '';
        this.errorMessage = 'Une erreur est survenue ❌';
      }
    });
  }
}


