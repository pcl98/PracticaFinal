import { Component } from '@angular/core';
import { CommonModule } from '@angular/common'; // ✅ Importamos CommonModule para *ngFor

@Component({
  selector: 'app-profesores',
  standalone: true, // ✅ Lo marcamos como standalone
  imports: [CommonModule], // ✅ Importamos CommonModule para habilitar directivas
  templateUrl: './profesores.component.html',
  styleUrls: ['./profesores.component.css'] // ✅ Corregido "styleUrl" → "styleUrls"
})
export class ProfesoresComponent {
  profesores = [
    {
      nombre: 'María Fernández',
      imagen: 'assets/images/MariaFernandez.png',
      especialidad: 'Guitarra clásica y acústica',
      formacion: 'Licenciada en Pedagogía musical',
      experiencia: 'Más de 10 años enseñando guitarra en línea y presencial.',
      ensenanza:
        'Me gusta enseñar de manera práctica. Adapto canciones a mis alumnos.',
      musica: 'Rock, pop',
      cursos: 'Curso de guitarras para principiantes',
    },
    {
      nombre: 'Pedro López',
      imagen: 'assets/images/PedroLopez.png',
      especialidad: 'Flauta dulce, trompeta, trombón',
      formacion: 'Licenciado en Musicología',
      experiencia: 'Más de 20 años tocando en orquestas y enseñando.',
      ensenanza:
        'Me centro en la técnica sólida y expresión personal para que los alumnos dominen su instrumento.',
      musica: 'Jazz, Blues',
      cursos: 'Curso de flauta para principiantes',
    },
  ];
}

