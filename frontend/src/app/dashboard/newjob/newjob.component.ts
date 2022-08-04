import { Component, OnInit } from '@angular/core';
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
  constructor() { }

  ngOnInit() {
  }

  onExcelSelected(e){
    console.log(e)
    this.file = e.target.files[0]
    if(this.file.type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || this.file.type == 'text/csv'){
      alert('file ok')
    }
  }

}
