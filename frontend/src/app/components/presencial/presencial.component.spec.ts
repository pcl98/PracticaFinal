import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PresencialComponent } from './presencial.component';

describe('PresencialComponent', () => {
  let component: PresencialComponent;
  let fixture: ComponentFixture<PresencialComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [PresencialComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(PresencialComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
