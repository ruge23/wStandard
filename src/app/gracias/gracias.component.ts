import { Component, OnInit } from "@angular/core";
import { ServicesService } from "../services.service";

@Component({
  selector: "abe-gracias",
  templateUrl: "./gracias.component.html",
  styleUrls: ["./gracias.component.scss"]
})
export class GraciasComponent implements OnInit {
  constructor(private services: ServicesService) {}

  codigo: string;

  ngOnInit() {
    this.codigo = this.services.codigo;
  }
}
