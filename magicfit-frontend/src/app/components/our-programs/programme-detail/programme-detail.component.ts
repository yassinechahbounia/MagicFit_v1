import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { ProgrammeService } from 'src/app/services/programme.service';

@Component({
  selector: 'app-programme-detail',
  templateUrl: './programme-detail.component.html',
  styleUrls: ['./programme-detail.component.scss'],
  imports:[CommonModule]
})
export class ProgrammeDetailComponent implements OnInit {
  programme: any;

  constructor(
    private route: ActivatedRoute,
    private programmeService: ProgrammeService
  ) {}

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.programmeService.getProgrammeById(+id).subscribe({
        next: (data) => {
          this.programme = data;
          console.log('Programme chargé :', this.programme);
        },
        error: (err) => {
          console.error('Erreur chargement programme', err);
        }
      });
    }
  }
}
