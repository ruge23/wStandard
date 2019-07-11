import { Component, OnInit } from '@angular/core';
import { NgbActiveModal, NgbModal } from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'abe-venta-producto',
  templateUrl: './venta-producto.component.html',
  styleUrls: ['./venta-producto.component.scss']
})
export class VentaProductoComponent implements OnInit {

  sliderImages:any=[]; 
  constructor() { 
    this.sliderImages =[
      {
        img:'../../assets/img/casco-slider.png'
      },
      {
        img:'../../assets/img/casco-slider.png'
      },
      {
        img:'../../assets/img/casco-slider.png'
      }
    ]
  }

  ngOnInit() {
  }

  // ***********************************************************
  // ---------------- CIFRADO DE CHECKOUT
  // ***********************************************************

  /*web: string = "http://ctrlztest.com.ar/test-mercadopago/?";


  price: string = btoa("price=");
  valor: any = 4080;

  priceAgain: string = "NgUhtRF";

  idWord: string = "ID";
  idNumber: string = "zLRTC";

  checkout() {
    // let money: string = btoa(JSON.stringify(this.valor));
    // let moneyAgain: string = btoa(JSON.stringify(this.valor));

    let money: any = btoa(this.valor);
    let moneyAgain: any = btoa(this.valor);

    window.open(
      this.web +
        this.price +
        "LzY63" +
        money +
        "&" +
        this.priceAgain +
        "LzY63" +
        moneyAgain +
        "&" +
        this.idWord +
        "LzY63" +
        this.idNumber,
      "_blank",
      "location=yes"
    );
  }*/

}
