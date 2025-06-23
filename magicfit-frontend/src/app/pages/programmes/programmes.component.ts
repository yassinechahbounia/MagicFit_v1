
// import { Component, OnInit } from '@angular/core';
// import { HttpClient } from '@angular/common/http';
// import { RouterLink } from '@angular/router';
// import { CommonModule } from '@angular/common';

// @Component({
//   selector: 'app-programmes',
//   templateUrl: './programmes.component.html',
//   styleUrls: ['./programmes.component.scss'],
//   imports:[RouterLink,CommonModule,]
// })
// export class ProgrammesComponent implements OnInit {
//   programmes: any[] = [];
//   staticPrograms: any;

//   constructor(private http: HttpClient) {}

//   ngOnInit(): void {
//     this.http.get<any[]>('http://127.0.0.1:8000/api/programmes', {
//       headers: {
//         Authorization: `Bearer ${localStorage.getItem('token')}`,
//         Accept: 'application/json'
//       }
//     }).subscribe({
//       next: (data) => this.programmes = data,
//       error: (err) => console.error('Erreur API:', err)
//     });
//   }
// }

import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-programmes',
  templateUrl: './programmes.component.html',
  styleUrls: ['./programmes.component.scss'],
  standalone: true,
  imports: [RouterLink, CommonModule]
})
export class ProgrammesComponent implements OnInit {
  programmes: any[] = [];

  constructor(private http: HttpClient) {}

  ngOnInit(): void {
    this.getProgrammes();
  }

  getProgrammes(): void {
    const token = localStorage.getItem('token');

    if (!token) {
      console.error("❌ Aucun token trouvé. L'utilisateur n'est pas authentifié.");
      return;
    }

    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
      Accept: 'application/json'
    });

    this.http.get<any[]>('http://127.0.0.1:8000/api/programmes', { headers }).subscribe({
      next: (data) => {
        this.programmes = data;
        console.log("✅ Programmes chargés :", data);
      },
      error: (err) => {
        console.error('❌ Erreur API:', err);
        if (err.status === 401) {
          alert("Session expirée. Veuillez vous reconnecter.");
          localStorage.clear();
          window.location.href = "/login"; // ou router.navigate si disponible
        }
      }
    });
  }
}
