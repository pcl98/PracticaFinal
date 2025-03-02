import { CommonModule } from '@angular/common';
import { Component, Input, Output, EventEmitter } from '@angular/core';
import { CalendarView } from 'angular-calendar';

@Component({
  selector: 'calendar-header',
  templateUrl: './calendar-header.component.html',
  styleUrls: ['./calendar-header.component.css'],
  imports: [CommonModule]
})
export class CalendarHeaderComponent {
  @Input() view: CalendarView = CalendarView.Month;
  @Input() viewDate: Date = new Date();
  @Output() viewChange = new EventEmitter<CalendarView>();
  @Output() viewDateChange = new EventEmitter<Date>();

  CalendarView = CalendarView;

  onPreviousDay(): void {
    const newDate = new Date(this.viewDate);
    if (this.view === CalendarView.Month) {
      newDate.setMonth(newDate.getMonth() - 1);
    } else if (this.view === CalendarView.Week) {
      newDate.setDate(newDate.getDate() - 7);
    } else {
      newDate.setDate(newDate.getDate() - 1);
    }
    this.viewDateChange.emit(newDate);
  }
  
  onNextDay(): void {
    const newDate = new Date(this.viewDate);
    if (this.view === CalendarView.Month) {
      newDate.setMonth(newDate.getMonth() + 1);
    } else if (this.view === CalendarView.Week) {
      newDate.setDate(newDate.getDate() + 7);
    } else {
      newDate.setDate(newDate.getDate() + 1);
    }
    this.viewDateChange.emit(newDate);
  }
  
}
