import { Component } from '@angular/core';
import { Router } from '@angular/router';
@Component({
  selector: 'app-online',
  imports: [],
  templateUrl: './online.component.html',
  styleUrl: './online.component.css'
})
export class OnlineComponent {

  constructor(private router: Router) {}

  public cambioCheckClase(tipoclase:string){
    const onlineCheck = document.getElementById('online-chck') as HTMLInputElement;
    const presencialCheck = document.getElementById('presencial-chck') as HTMLInputElement;
    
    if (tipoclase == 'online' && onlineCheck.checked){
      presencialCheck.checked = false;
    } else if (tipoclase == 'presencial' && presencialCheck.checked) {
      onlineCheck.checked = false;
    }
  }

  public filtrar(){
    const onlineCheck = document.getElementById('online-chck') as HTMLInputElement;
    const presencialCheck = document.getElementById('presencial-chck') as HTMLInputElement;

    if (presencialCheck.checked){
      this.router.navigate(['/presencial']);
    }
  }

  public cambioCheckDificultad(nivel: string) {
    const prinCheck = document.getElementById('prin-chck') as HTMLInputElement;
    const interCheck = document.getElementById('inter-chck') as HTMLInputElement;
    const avanCheck = document.getElementById('avan-chck') as HTMLInputElement;
  
    if (nivel === 'principiante' && prinCheck.checked) {
      interCheck.checked = false;
      avanCheck.checked = false;
    } else if (nivel === 'intermedio' && interCheck.checked) {
      prinCheck.checked = false;
      avanCheck.checked = false;
    } else if (nivel === 'avanzado' && avanCheck.checked) {
      prinCheck.checked = false;
      interCheck.checked = false;
    }
  }
}