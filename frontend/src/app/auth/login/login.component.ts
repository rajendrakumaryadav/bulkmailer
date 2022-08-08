import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { HttpService } from 'src/app/services/http.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
	loginForm:FormGroup
  showPassError = false;

  constructor(
    private fb:FormBuilder,
    private router:Router,
    private httpService:HttpService
  ) { 
    this.loginForm = fb.group({
			email: ['',Validators.compose([Validators.required,Validators.email])],
			password: ['',Validators.compose([Validators.required])]
		})
  }

  ngOnInit() {
  }

  toVerify() {
    if(this.loginForm.invalid){
      this.showPassError=true
      return
    }else{
      this.showPassError=false
    }

    let {email,password} = this.loginForm.value

    if(email == 'admin@bulkmail.com' && password == '895623784512'){
      this.httpService.isLoggedIn=true
      this.router.navigate(['/'])
    }else{
      this.showPassError=true
    }

  }

}
