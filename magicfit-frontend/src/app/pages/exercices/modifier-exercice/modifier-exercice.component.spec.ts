import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ModifierExerciceComponent } from './modifier-exercice.component';

describe('ModifierExerciceComponent', () => {
  let component: ModifierExerciceComponent;
  let fixture: ComponentFixture<ModifierExerciceComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ModifierExerciceComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ModifierExerciceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
