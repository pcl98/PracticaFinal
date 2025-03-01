import { ComponentFixture, TestBed } from '@angular/core/testing';
import { ProfesoresComponent } from './profesores.component';
import { CommonModule } from '@angular/common'; // ✅ Importamos CommonModule

describe('ProfesoresComponent', () => {
  let component: ProfesoresComponent;
  let fixture: ComponentFixture<ProfesoresComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CommonModule, ProfesoresComponent], // ✅ Importamos CommonModule y el componente standalone
    }).compileComponents();

    fixture = TestBed.createComponent(ProfesoresComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
