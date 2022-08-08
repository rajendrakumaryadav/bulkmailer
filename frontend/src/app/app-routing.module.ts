import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './auth/login/login.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ListjobsComponent } from './dashboard/listjobs/listjobs.component';
import { NewjobComponent } from './dashboard/newjob/newjob.component';
import { AuthGuard } from './services/auth.guard';


const routes: Routes = [
  
  {
    path:'',
    component:DashboardComponent,
    canActivate:[AuthGuard],
    children:[
      {
        path:'listjobs',
        component:ListjobsComponent
      },
      {
        path:'newjob',
        component:NewjobComponent
      },
      {
        path:'',
        redirectTo:'listjobs',
        pathMatch:'full'
      }
    ]
  },
  {
    path:'login',
    component:LoginComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes,{useHash:true})],
  exports: [RouterModule]
})
export class AppRoutingModule { }
