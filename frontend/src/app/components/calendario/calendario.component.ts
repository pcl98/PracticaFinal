import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-calendario',
  imports: [FormsModule],
  templateUrl: './calendario.component.html',
  styleUrl: './calendario.component.css'
})
export class CalendarioComponent {
  public persona: any;

  constructor(){
    this.persona = {
      nombre : '',
      apellido : ''
    }
  }
  public submit(){
    console.log(this.persona);
  }
}
