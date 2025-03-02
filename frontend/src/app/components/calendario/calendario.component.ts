import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { CalendarEvent, CalendarView, CalendarMonthViewDay } from 'angular-calendar';
import { ClaseService } from '../../services/clase.service';
import { ExamenService } from '../../services/examen.service';
import { EstudianteService } from '../../services/estudiante.service';
import { CalendarHeaderComponent } from '../calendar-header/calendar-header.component';
import { CommonModule } from '@angular/common';
import { CalendarModule, DateAdapter, CalendarUtils, CalendarA11y, CalendarDateFormatter } from 'angular-calendar';
import { adapterFactory } from 'angular-calendar/date-adapters/date-fns';
import { CustomDateFormatter } from '../../providers/custom-date-formatter.provider';
import { AuthService } from '../../services/auth.service';
import { ProfesorService } from '../../services/profesor.service';


@Component({
  selector: 'app-calendario',
  standalone: true,
  imports: [
    CommonModule,
    CalendarModule,
    CalendarHeaderComponent,
  ],
  providers: [
    {
      provide: DateAdapter,
      useFactory: adapterFactory,
    },
    CalendarUtils,
    CalendarA11y,
    {
      provide: CalendarDateFormatter,
      useClass: CustomDateFormatter,
    },
  ],
  templateUrl: './calendario.component.html',
  styleUrls: ['./calendario.component.css'],
  encapsulation: ViewEncapsulation.None,
})
export class CalendarioComponent implements OnInit {
  view: CalendarView = CalendarView.Month;
  viewDate: Date = new Date();
  events: CalendarEvent[] = [];
  weekStartsOn: number = 1;
  activeDayIsOpen: boolean = false;
  selectedDate: Date | null = null;

  constructor(
    private estudianteService: EstudianteService,
    private examenService: ExamenService,
    private profesorService: ProfesorService,
    private authService: AuthService
  ) {}

  ngOnInit(): void {
    this.cargarEventos();
  }

  cargarEventos(): void {
    console.log(this.authService.getUser().tipo_usuario);
    if (this.authService.getUser().tipo_usuario == "Estudiante") {
      
      this.estudianteService.getClasesByEstudianteId(this.authService.getUser().id).subscribe(clases => {
        this.events.push(...clases.map(clase => {
          let title = '';
          let cssClass = '';
  
          if (clase.online) {
            title = `Clase online: ${clase.online.titulo}`;
            cssClass = 'clase-online';
          } else if (clase.presencial) {
            title = `Clase de ${clase.instrumento} ubicación: ${clase.presencial.ubicacion}`;
            cssClass = 'clase-presencial';
          }
  
          return {
            title: title,
            start: new Date(clase.fecha),
            color: { primary: '#1e90ff', secondary: '#D1E8FF' },
            cssClass: cssClass,
          };
        }));
      });
  
      this.examenService.getExamenesByEstudianteId(this.authService.getUser().id).subscribe(examenes => {
        this.events.push(...examenes.map(examen => ({
          title: `${examen.titulo} - ${examen.descripcion}`,
          start: new Date(examen.fecha),
          color: { primary: '#ff5733', secondary: '#FFDDC1' },
          cssClass: 'examen',
        })));
      });
    }

    else {
      this.profesorService.getClasesByProfesorId(this.authService.getUser().tipo_usuario).subscribe(clases => {
        this.events.push(...clases.map(clase => {
          let title = '';
          let cssClass = '';
  
          if (clase.online) {
            title = `Clase online: ${clase.online.titulo}`;
            cssClass = 'clase-online';
          } else if (clase.presencial) {
            title = `Clase de ${clase.instrumento} ubicación: ${clase.presencial.ubicacion}`;
            cssClass = 'clase-presencial';
          }
  
          return {
            title: title,
            start: new Date(clase.fecha),
            color: { primary: '#1e90ff', secondary: '#D1E8FF' },
            cssClass: cssClass,
          };
        }));
      });
  
      this.examenService.getExamenesByProfesorId(this.authService.getUser().tipo_usuario).subscribe(examenes => {
        this.events.push(...examenes.map(examen => ({
          title: `${examen.titulo} - ${examen.descripcion}`,
          start: new Date(examen.fecha),
          color: { primary: '#ff5733', secondary: '#FFDDC1' },
          cssClass: 'examen',
        })));
      });
    }   

  }

  onDayClick({ day }: { day: CalendarMonthViewDay }): void {
    if (day.events.length > 0) {
      this.viewDate = day.date; // Cambiar la vista al día seleccionado
      this.selectedDate = day.date; // Guardar la fecha seleccionada
      this.activeDayIsOpen = this.selectedDate.getTime() === day.date.getTime() ? !this.activeDayIsOpen : true;
    } else {
      this.selectedDate = null;
      this.activeDayIsOpen = false;
    }
  }
  
  
}