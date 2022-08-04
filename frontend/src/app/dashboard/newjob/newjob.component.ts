import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { HttpService } from 'src/app/services/http.service';
import * as ClassicEditor from '../../../assets/ckeditor5-34.2.0/build/ckeditor';

@Component({
  selector: 'app-newjob',
  templateUrl: './newjob.component.html',
  styleUrls: ['./newjob.component.scss']
})
export class NewjobComponent implements OnInit {

  public Editor = ClassicEditor;
  emailBody=''
  step=1
  file:File
  mailForm:FormGroup

  constructor(
    private fb:FormBuilder,
    private router:Router,
    private httpService:HttpService
  ) { 
    this.mailForm = fb.group({
      subject:['',Validators.compose([Validators.required,Validators.maxLength(50)])],
      senderName:['',Validators.compose([Validators.required,Validators.maxLength(50)])],
      from:['',Validators.compose([Validators.required,Validators.email])],
      body:['',Validators.compose([Validators.required])],
      replyTo:['',Validators.compose([Validators.email])],
    })
  }

  ngOnInit() {
  }

  sendMail(){
    console.log(this.mailForm)
    if(!this.file){
      return this.step=1
    }

    if(this.mailForm.valid){
      let {subject,senderName,from,body,replyTo} = this.mailForm.value

      let bodyForm = new FormData()
      bodyForm.append('file',this.file)
      bodyForm.append('subject',subject)
      bodyForm.append('template',body)
      bodyForm.append('reply_to',replyTo)
      bodyForm.append('from',from)
      bodyForm.append('sender_name',senderName)

      this.httpService.sendmail(bodyForm)
      .subscribe(
        res=>{
          if(res.status_code == '200'){
            alert('mail sent')
            this.router.navigate(['/'])
          }else{
            alert('mail sending error '+res.status_code)
          }
          console.log(res)
        },
        err=>{
          alert(err)
          console.log(err)
        }
      )

      // alert('mail sent')
      // this.router.navigate(['/'])
    }
  }

  onExcelSelected(e){
    console.log(e)
    this.file = e.target.files[0]
    // if(this.file.type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || this.file.type == 'text/csv'){
      
    // }
  }

}
