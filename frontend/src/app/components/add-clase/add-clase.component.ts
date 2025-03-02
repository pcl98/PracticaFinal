import { Component } from '@angular/core';
import { ClaseService } from '../../services/clase.service';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-add-clase',
  imports: [FormsModule],
  templateUrl: './add-clase.component.html',
  styleUrl: './add-clase.component.css',
  providers: [ClaseService]
})
export class AddClaseComponent {
  nuevaClase = {
    instrumento: '',
    dificultad: '',
    duracion: null,
    max_alumnos: null,
    precio: null,
    profesor_id: null
  };

  constructor(private claseService: ClaseService) {}

  crearClase() {
    if (!this.nuevaClase.instrumento || !this.nuevaClase.dificultad || 
        !this.nuevaClase.duracion || !this.nuevaClase.max_alumnos || 
        !this.nuevaClase.precio || !this.nuevaClase.profesor_id) {
      alert('Por favor, completa todos los campos');
      return;
    }

    this.claseService.crearClase(this.nuevaClase).subscribe(
      (response) => {
        alert('Clase creada exitosamente');
        location.reload(); // Recargar la página
      }
    );
  }
}
