import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';

@Component({
  selector: 'app-mirror',
  imports: [],
  templateUrl: './mirror.component.html',
  styleUrl: './mirror.component.scss'
})
export class MirrorComponent {
  constructor(private http: HttpClient) {}

  cacher() {
    this.http.get('http://localhost:8000/api/mirror/cacher-horloge').subscribe();
  }

  afficher() {
    this.http.get('http://localhost:8000/api/mirror/afficher-horloge').subscribe();
  }

}
