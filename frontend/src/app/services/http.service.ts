import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";

@Injectable({
    providedIn:'root'
})
export class HttpService{
    endPoint='http://15.206.153.112:8000'

    constructor(
        private http:HttpClient
    ){

    }

    sendmail(body){
        return this.http.post<{status_code:any,message:string}>(this.endPoint+'/api/sendmail',body)
    }
}