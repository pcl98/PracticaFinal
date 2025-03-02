import { Injectable } from '@angular/core';
import { CalendarDateFormatter, DateFormatterParams } from 'angular-calendar';
import { formatDate } from '@angular/common';

@Injectable()
export class CustomDateFormatter extends CalendarDateFormatter {
  // Capitaliza la primera letra de una cadena
  private capitalizeFirstLetter(str: string): string {
    return str.charAt(0).toUpperCase() + str.slice(1);
  }

  // Formatea el título de la vista semanal (mes y año)
  public override weekViewTitle({ date, locale }: DateFormatterParams): string {
    const formattedDate = formatDate(date, 'MMMM y', locale || 'es');
    console.log('Formatted month:', formattedDate); // Depuración
    return this.capitalizeFirstLetter(formattedDate); // Capitaliza el mes
  }

  // Formatea los encabezados de las columnas (días de la semana)
  public override weekViewColumnHeader({ date, locale }: DateFormatterParams): string {
    const formattedDate = formatDate(date, 'EEEE', locale || 'es');
    console.log('Formatted day:', formattedDate); // Depuración
    return this.capitalizeFirstLetter(formattedDate); // Capitaliza el día
  }

  // Formatea los subencabezados de las columnas (día del mes)
  public override weekViewColumnSubHeader({ date, locale }: DateFormatterParams): string {
    return formatDate(date, 'd', locale || 'es'); // No necesita capitalización
  }
}