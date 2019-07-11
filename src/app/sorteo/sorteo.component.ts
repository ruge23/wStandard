import { ServicesService } from './../services.service';
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'abe-sorteo',
  templateUrl: './sorteo.component.html',
  styleUrls: ['./sorteo.component.scss']
})
export class SorteoComponent implements OnInit {
  data:any=[];

  model: any = {};
  constructor(
    private router: Router,
    private services: ServicesService,
  ) { }

  
  ngOnInit() {
  }

  sendSorteo(){
    console.log(this.model);
    this.services.sendSorteoData(this.model).subscribe(data=>{
      console.log('vuelta', data);
      this.data = JSON.parse(data['_body'])['data'];
      console.log('data', this.data);
      if(this.data){
        console.log('entroAlIf')
        this.router.navigate(['/', 'a']).then(nav => {
          console.log(nav); // true if navigation is successful
        }, err => {
          console.log(err) // when there's an error
        });
      }
    });
  }


}
