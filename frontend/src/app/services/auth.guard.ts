import { Injectable } from "@angular/core";
import { ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot, UrlTree } from "@angular/router";
import { Observable } from "rxjs";
import { HttpService } from "./http.service";

@Injectable({
    providedIn:'root'
})
export class AuthGuard implements CanActivate{
    constructor(
        private router:Router,
        private http:HttpService
    ){}
    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
        if(this.http.isLoggedIn){
            return true
        }else{
            this.router.navigate(['/login'])
            return false
        }
                
    }
}