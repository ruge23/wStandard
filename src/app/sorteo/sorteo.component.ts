import { ServicesService } from "./../services.service";
import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";
import { NgForm } from "@angular/forms";

@Component({
  selector: "abe-sorteo",
  templateUrl: "./sorteo.component.html",
  styleUrls: ["./sorteo.component.scss"]
})
export class SorteoComponent implements OnInit {
  data: any = [];

  model: any = {};
  constructor(private router: Router, private services: ServicesService) {}

  ngOnInit() {
    console.log("20190813");
    console.log("20190902");
  }

  onSubmit(form: NgForm) {
    this.model = form.value;

    if (
      this.model.firstName &&
      this.model.email &&
      this.model.ciudad &&
      this.model.provincia &&
      this.model.productoMP
    ) {
      this.services.sendSorteoData(this.model).subscribe(data => {
        // let x = JSON.parse(data["_body"])["data"];

        let codigo = JSON.parse(data["_body"])["data"];

        if (codigo) {
          this.services.setCodigo(codigo.trim());
          this.router.navigate(["/", "gracias"]).then(
            nav => {
              console.log(nav); // true if navigation is successful
            },
            err => {
              console.log(err); // when there's an error
            }
          );
        } else {
          alert("El mail ingresado ya tiene un código de descuento asignado");
        }
      });
    }
  }
}
