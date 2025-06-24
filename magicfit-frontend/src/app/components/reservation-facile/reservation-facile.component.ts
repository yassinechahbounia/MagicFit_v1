import { Component } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { RouterLink, RouterModule } from '@angular/router';
import { ReservationService } from 'src/app/services/reservation.service';

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

  constructor(private fb: FormBuilder, private http: HttpClient,private reservationService: ReservationService) {
    this.reservationForm = this.fb.group({
      nom: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      type: ['collectif', Validators.required],
      date: ['', Validators.required],
      heure: ['', Validators.required]
    });
  }

  onSubmit(): void {
    if (this.reservationForm.invalid) return;

    this.reservationService.reserver(this.reservationForm.value).subscribe({
      next: () => {
        this.successMessage = 'Réservation effectuée avec succès ✅';
        this.errorMessage = '';
        this.reservationForm.reset();
      },
      error: (err) => {
        console.error(err);
        this.errorMessage = 'Une erreur est survenue ❌';
        this.successMessage = '';
      }
    });
  }
}