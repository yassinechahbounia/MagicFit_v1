import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { RouterLink, RouterModule } from '@angular/router';
import { ProgrammeService } from 'src/app/services/programme.service';

@Component({
  selector: 'app-our-programs',
  templateUrl: './our-programs.component.html',
  styleUrls: ['./our-programs.component.scss'],
  standalone: true,
  imports: [CommonModule, RouterModule, RouterLink],
})
export class OurProgramsComponent implements OnInit {

staticPrograms = [
    {
      image: '1.jpg',
      nom: 'LOSING WEIGHT',
      description: 'Effective training and coaching to help you burn fat and get in shape.',
    },
    {
      image: '2.jpg',
      nom: 'BUILDING MUSCLE',
      description: 'Structured plans designed for hypertrophy and muscle growth.',
    },
    {
      image: '3.jpg',
      nom: 'TRAINING AT HOME',
      description: 'No gym? No problem. Workout programs for your living room.',
    },
    {
      image: 'gym plan.svg',
      nom: 'GYM PLAN',
      description: 'Advanced and personalized plans for gym-goers of all levels.',
    },
  ];

  programmes: any[] = [];               // Tous les programmes
  visibleProgrammes: any;
  isLoading: any;
  programmesAffiches: any[] = [];       // Programmes visibles
  limiteAffichage = 4;                  // Nombre initial d'éléments affichés

  constructor(private programmeService: ProgrammeService) {}

  ngOnInit(): void {
     this.programmeService.getProgrammes().subscribe({
      next: (data) => {
        this.programmes = data;
        this.visibleProgrammes = this.programmes.slice(0, 3); // Affiche 3 au début
        this.isLoading = false;
      },
      error: () => {
        alert('Erreur de chargement des programmes');
        this.isLoading = false;
      },
    });
  }

  showMore() {
    const next = this.visibleProgrammes.length + 3;
    this.visibleProgrammes = this.programmes.slice(0, next);
  }

  mettreAJourProgrammesAffiches(): void {
    this.programmesAffiches = this.programmes.slice(0, this.limiteAffichage);
  }

  voirPlus(): void {
    this.limiteAffichage += 3; // augmente par 3 à chaque clic
    this.mettreAJourProgrammesAffiches();
  }
}
