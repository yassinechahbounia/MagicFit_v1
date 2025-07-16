import { Component, OnInit } from '@angular/core';
import {
  FormBuilder,
  FormGroup,
  FormsModule,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Chart, registerables } from 'chart.js';
import { CommonModule } from '@angular/common';

Chart.register(...registerables);

@Component({
  selector: 'app-suivi',
  templateUrl: './suivi.component.html',
  imports: [ReactiveFormsModule, CommonModule, FormsModule],
})
export class SuiviComponent implements OnInit {
  suiviForm: FormGroup;
  suivis: any[] = [];
  utilisateurs: any[] = [];
  userIdFilter: number | null = null;
  chart: any;

  constructor(private fb: FormBuilder, private http: HttpClient) {
    this.suiviForm = this.fb.group({
      user_id: ['', Validators.required],
      date: ['', Validators.required],
      poids: [''],
      repetitions: ['', Validators.required],
      commentaire: [''],
    });
  }

  ngOnInit(): void {
    this.getUtilisateurs();
    this.getSuivis();
  }

  getUtilisateurs(): void {
  const token = localStorage.getItem('token');
  const headers = new HttpHeaders({ Authorization: `Bearer ${token}` });

  this.http.get<any[]>('http://127.0.0.1:8000/api/users', { headers }).subscribe(data => {
    this.utilisateurs = data;
  });
}


  getSuivis(): void {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({ Authorization: `Bearer ${token}` });

    this.http
      .get<any[]>('http://127.0.0.1:8000/api/suivis', { headers })
      .subscribe((data) => {
        this.suivis = data;
        this.updateChart();
      });
  }

  ajouterSuivi(): void {
    if (this.suiviForm.invalid) return;

    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({ Authorization: `Bearer ${token}` });

    this.http
      .post('http://127.0.0.1:8000/api/suivis', this.suiviForm.value, {
        headers,
      })
      .subscribe(() => {
        this.suiviForm.reset();
        this.getSuivis();
      });
  }

  supprimerSuivi(id: number): void {
    const token = localStorage.getItem('token');
    const headers = new HttpHeaders({ Authorization: `Bearer ${token}` });

    this.http
      .delete(`http://127.0.0.1:8000/api/suivis/${id}`, { headers })
      .subscribe(() => {
        this.getSuivis();
      });
  }

  get filteredSuivis(): any[] {
    if (!this.userIdFilter) return this.suivis;
    return this.suivis.filter((s) => s.user_id == this.userIdFilter);
  }

  updateChart(): void {
    if (this.chart) this.chart.destroy();

    const userId = this.userIdFilter;
    const filtered = userId
      ? this.suivis.filter((s) => s.user_id == userId)
      : this.suivis;

    const sorted = [...filtered].sort(
      (a, b) => new Date(a.date).getTime() - new Date(b.date).getTime()
    );

    const labels = sorted.map((s) => s.date);
    const data = sorted.map((s) => s.poids);

    this.chart = new Chart('suiviChart', {
      type: 'line',
      data: {
        labels,
        datasets: [
          {
            label: 'Évolution du poids',
            data,
            borderWidth: 2,
            fill: false,
            tension: 0.1,
          },
        ],
      },
      options: {
        responsive: true,
        animation: {
          duration: 5000, // rapide
          easing: 'easeOutQuad', // fluide
        },
      },
    });
  }
}
