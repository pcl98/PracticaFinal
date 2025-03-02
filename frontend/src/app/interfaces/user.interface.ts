export interface User {
  id: number; // El ID es opcional porque no siempre se envía
  nombre: string;
  apellido: string;
  email: string;
  password?: string;
  nivel: number;
  tipo_usuario: string;
}

export interface UserResponse {
  usuario: User;
}

export interface Estudiante {
  id: number;
  dni: string;
  historial_clases: string;
  lecciones_completadas: number;
}

export interface Profesor {
  id: number;
  dni: string;
  especialidad: string;
  media_calificacion: number;
}

export interface Pago {
  id: number;
  fecha_pago: string;
  metodo_pago: string;
  cantidad: string;
  concepto: string;
  id_estudiante: number;
  id_clase: number;
}

export interface PaginatedResponse<T> {
  current_page: number;
  data: T[];
  first_page_url: string;
  from: number;
  last_page: number;
  last_page_url: string;
  links: {
    url: string | null;
    label: string;
    active: boolean;
  }[];
  next_page_url: string | null;
  path: string;
  per_page: number;
  prev_page_url: string | null;
  to: number;
  total: number;
}