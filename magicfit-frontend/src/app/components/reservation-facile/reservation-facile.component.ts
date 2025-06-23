import { Component } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { RouterLink, RouterModule } from '@angular/router';

@Component({
  selector: 'app-reservation-facile',
  templateUrl: './reservation-facile.component.html',
  styleUrls: ['./reservation-facile.component.scss'],
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterLink, RouterModule],
})
export class ReservationFacileComponent {
  reservationForm: FormGroup;
  submitted = false;
  successMessage = '';
  errorMessage = '';

  constructor(private fb: FormBuilder, private http: HttpClient) {
    this.reservationForm = this.fb.group({
      nom: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      type: ['collectif', Validators.required],
      date: ['', Validators.required],
      heure: ['', Validators.required]
    });
  }

  onSubmit() {
    this.submitted = true;
    if (this.reservationForm.valid) {
      this.http.post('http://localhost:8000/api/reservations', this.reservationForm.value).subscribe({
        next: () => this.successMessage = "✅ Réservation envoyée avec succès !",
        error: () => this.errorMessage = "❌ Une erreur est survenue."
      });
    }
  }
}
