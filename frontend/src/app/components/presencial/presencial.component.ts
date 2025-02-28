import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { ClaseService } from '../../services/clase.service';
import { Console } from 'console';
import { CommonModule } from '@angular/common';


@Component({
  selector: 'app-presencial',
  imports: [CommonModule],
  templateUrl: './presencial.component.html',
  styleUrl: './presencial.component.css',
  providers: [ClaseService]
}) 
export class PresencialComponent {
  clases : any[]  = [];
  public instrumento:string = '';
  clasesFiltradas : any[] = [];
  dificultad:string = '';


  constructor(private router: Router, private claseService: ClaseService) {
    this.instrumento = 'Instrumento';
  }
  
  ngOnInit() {
    this.claseService.getClases().subscribe((response: any) => {
      this.clases = Array.isArray(response.data) ? response.data : [];
      this.clases.forEach((clase, index) => {
        this.claseService.getClasesPresencial(clase.id).subscribe((detalles: any) => {
          this.clases[index].ubicacion = detalles.ubicacion;
          console.log(detalles.ubicacion)
    
        });
      });
    }); 
    
  }

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

    if (onlineCheck.checked){
      this.router.navigate(['/clases/online']);
    }
    this.dificultad = this.getDificultad();
    this.clasesFiltradas = this.getClasesFiltro();
    
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

  private obtenerClases() {
    this.claseService.getClases().subscribe((response: any) => {
      this.clases = Array.isArray(response.data) ? response.data : [];
      console.log("Clases asignadas:", this.clases);

      this.clases.forEach((clase, index) => {
        this.claseService.getClasesPresencial(clase.id).subscribe((detalles: any) => {
          this.clases[index].ubicacion = detalles.ubicacion;
          

          if (index === this.clases.length - 1) {
            this.filtrar();
          }
        });
      });
    });
  }
  
  
  
  

  public getClasesFiltro():any[]{
    let clases_aux: any[] = [];
    this.clases.forEach(clase => {
        if (clase.instrumento === this.instrumento && clase.dificultad == this.dificultad){
          clases_aux.push(clase)
        }
        if (clase.instrumento === this.instrumento && this.dificultad === 'none'){
          clases_aux.push(clase)
        }
        if(clase.dificultad  === this.dificultad && this.instrumento === 'Instrumento'){
          clases_aux.push(clase)
        }
        if(this.dificultad === 'none' && this.instrumento === 'Instrumento'){
          clases_aux.push(clase)
        }
    });  
    return clases_aux;
  }

  public getDificultad():string{
    const prinCheck = document.getElementById('prin-chck') as HTMLInputElement;
    const interCheck = document.getElementById('inter-chck') as HTMLInputElement;
    const avanCheck = document.getElementById('avan-chck') as HTMLInputElement;
    if (prinCheck.checked){
      return 'principiante';
    
    } else if(interCheck.checked){
      return 'intermedio';
    }
    else if(avanCheck.checked){
      return 'avanzado';
    }
    return 'none';
  }

  public getInstrumento(){
    const selectInstrumento = document.getElementById('instrumentos') as HTMLSelectElement;
    this.instrumento = selectInstrumento.value;
  }
}