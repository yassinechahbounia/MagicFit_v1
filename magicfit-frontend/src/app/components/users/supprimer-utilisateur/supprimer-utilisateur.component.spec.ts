import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SupprimerUtilisateurComponent } from './supprimer-utilisateur.component';

describe('SupprimerUtilisateurComponent', () => {
  let component: SupprimerUtilisateurComponent;
  let fixture: ComponentFixture<SupprimerUtilisateurComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SupprimerUtilisateurComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SupprimerUtilisateurComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
