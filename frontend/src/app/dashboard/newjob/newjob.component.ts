import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
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
    private fb:FormBuilder
  ) { 
    this.mailForm = fb.group({
      subject:['',Validators.compose([Validators.required,Validators.maxLength(50)])],
      from:['',Validators.compose([Validators.required,Validators.email])],
      body:['',Validators.compose([Validators.required])],
    })
  }

  ngOnInit() {
  }

  sendMail(){
    console.log(this.mailForm)
    if(this.mailForm.valid){

    }
  }

  onExcelSelected(e){
    console.log(e)
    this.file = e.target.files[0]
    if(this.file.type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || this.file.type == 'text/csv'){
      alert('file ok')
    }
  }

}
