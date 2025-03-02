import { Routes } from '@angular/router';
import { InicioComponent } from './components/inicio/inicio.component';
import { CalendarioComponent } from './components/calendario/calendario.component';
import { PresencialComponent } from './components/presencial/presencial.component';
import { OnlineComponent } from './components/online/online.component';
import { ProfesoresComponent } from './components/profesores/profesores.component';
import { NuestraHistoriaComponent } from './components/nuestra-historia/nuestra-historia.component';
import { ContactoComponent } from './components/contacto/contacto.component';
import { PreguntasFrecuentesComponent } from './components/preguntas-frecuentes/preguntas-frecuentes.component';
import { LoginComponent } from './components/login/login.component';
import { AuthGuard } from './guards/auth.guard';
import { PerfilComponent } from './components/perfil/perfil.component';
import { AddClaseComponent } from './components/add-clase/add-clase.component';


export const routes: Routes = [
    {path: '', component: InicioComponent},
    {path: 'inicio', component: InicioComponent},
    {path: 'clases/presencial', component: PresencialComponent},
    {path: 'clases/online', component: OnlineComponent},
    {path: 'inicio', component: InicioComponent},
    {path: 'calendario', component: CalendarioComponent},
    {path: 'profesores', component: ProfesoresComponent},
    {path: 'nuestrahistoria', component: NuestraHistoriaComponent},
    {path: 'contacto', component: ContactoComponent},
    {path: 'preguntasfrecuentes', component: PreguntasFrecuentesComponent},
    {path: 'login', component: LoginComponent },
    {path: 'perfil', component: PerfilComponent },
    {path: 'clases/online/addclase', component: AddClaseComponent },
    
];
