import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DashboardComponent } from './dashboard/dashboard.component';
import { ListjobsComponent } from './dashboard/listjobs/listjobs.component';
import { NewjobComponent } from './dashboard/newjob/newjob.component';


const routes: Routes = [
  
  {
    path:'',
    component:DashboardComponent,
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
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes,{useHash:true})],
  exports: [RouterModule]
})
export class AppRoutingModule { }
