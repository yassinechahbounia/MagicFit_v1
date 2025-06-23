import { Component, OnInit, } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule, FormsModule } from '@angular/forms';
import { SuiviService } from 'src/app/services/suivi.service';
import { ChartConfiguration, ChartType, ChartTypeRegistry } from 'chart.js';
import { NgChartsModule } from 'ng2-charts';

@Component({
  standalone: true,
  selector: 'app-suivi',
  templateUrl: './suivi.component.html',
  styleUrls: ['./suivi.component.scss'],
  imports: [
    CommonModule,
    ReactiveFormsModule,
    FormsModule,
    NgChartsModule
  ]
})
export class SuiviComponent implements OnInit {
  suivis: any[] = [];
  suiviForm!: FormGroup;
  filtreUtilisateur: string = '';

  // 📊 Graphique
  public barChartOptions: ChartConfiguration<'bar'>['options'] = {
    responsive: true,
  };
  public barChartType: 'bar' = 'bar';
  public barChartLabels: string[] = [];
  public barChartData: ChartConfiguration<'bar'>['data'] = {
  labels: [],
  datasets: [
    { data: [], label: 'Répétitions' }
  ]
};
utilisateurs: any;
  http: any;
  apiUrl: any;


  constructor(private suiviService: SuiviService, private fb: FormBuilder) {}

  ngOnInit(): void {
  this.suiviForm = this.fb.group({
  user_id: ['', Validators.required], 
  date: ['', Validators.required],
  poids: [''],
  repetitions: ['', Validators.required],
  commentaire: ['']
});

    
    this.chargerSuivis();
  }

  chargerSuivis(): void {
    this.suiviService.getSuivis().subscribe({
      next: (data) => {
        this.suivis = data;

        const labelMap = new Map<string, number>();
        data.forEach((s: any) => {
          const label = s.date;
          const current = labelMap.get(label) ?? 0;
          labelMap.set(label, current + parseInt(s.repetitions));
        });

       this.barChartData.labels = Array.from(labelMap.keys());
       this.barChartData.datasets[0].data = Array.from(labelMap.values());

      },
      error: () => alert('Erreur chargement des suivis')
    });
  }

  getSuivisFiltres() {
  if (!this.filtreUtilisateur) return this.suivis;
  return this.suivis.filter(s => s.user_id == this.filtreUtilisateur);
}

 ajouterSuivi(): void {
  if (this.suiviForm.invalid) return;

  const formData = {
    ...this.suiviForm.value
  };

  this.suiviService.ajouterSuivi(formData).subscribe({
    next: () => {
      this.suiviForm.reset();
      this.chargerSuivis();
    },
    error: () => alert('Erreur ajout suivi')
  });
}


  supprimerSuivi(id: number): void {
    if (!confirm('Confirmer suppression ?')) return;

    this.suiviService.supprimerSuivi(id).subscribe({
      next: () => this.chargerSuivis(),
      error: () => alert('Erreur suppression suivi')
    });
  }
}
